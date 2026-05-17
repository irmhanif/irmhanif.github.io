import Groq from "groq-sdk";
import { NextRequest } from "next/server";
import { readFileSync, appendFileSync, mkdirSync } from "fs";
import { join } from "path";
import { AI_TOKEN_LIMIT } from "@/app/content";

// ─── Groq client ────────────────────────────────────────────────
const groq = new Groq({ apiKey: process.env.GROQ_API_KEY });

// ─── Server-side rate limit (in-memory, resets on redeploy) ─────
const serverUsage = new Map<string, { tokens: number; resetAt: number }>();
const RESET_MS    = 24 * 60 * 60 * 1000;

function getRecord(key: string) {
  const now = Date.now();
  const rec = serverUsage.get(key);
  if (!rec || rec.resetAt < now) {
    const r = { tokens: 0, resetAt: now + RESET_MS };
    serverUsage.set(key, r);
    return r;
  }
  return rec;
}

// ─── Resume / about-me context ───────────────────────────────────
function readData(file: string): string {
  try { return readFileSync(join(process.cwd(), "data", file), "utf-8").trim(); }
  catch { return ""; }
}

function buildSystem(): string {
  const resume  = readData("resume.txt");

  const base = `You are Mohamed Idris speaking in first person. Senior React Developer, 7.5 years. Current: Comcast Dev Engineer 3, FreeWheel MRM, Spotlight Award Q2 2025, ~90% Playwright test coverage. Stack: React, TypeScript, Redux, GraphQL, Node.js, Go, Playwright. Open to UK, EU, Canada, UAE, Singapore, remote. Answer in ≤90 words, first person, confident and direct. No bullet lists. No invented metrics. If you don't know something, say so honestly.`;

  const rSection = resume  && !resume.startsWith("RESUME — Mohamed Idris")
    ? `\n\n--- RESUME ---\n${resume}`  : "";

  return base + rSection;
}

// ─── Geo lookup (server-side, 2 s timeout) ───────────────────────
interface GeoInfo { city: string; region: string; country: string; }

async function fetchGeo(ip: string): Promise<GeoInfo> {
  const blank = { city: "-", region: "-", country: "-" };
  if (!ip || ip === "unknown" || ip.startsWith("127.") || ip === "::1") {
    return { city: "localhost", region: "-", country: "-" };
  }
  const ctrl = new AbortController();
  const t    = setTimeout(() => ctrl.abort(), 2000);
  try {
    const res  = await fetch(
      `http://ip-api.com/json/${ip}?fields=status,city,regionName,country`,
      { signal: ctrl.signal }
    );
    const data = await res.json();
    return data.status === "success"
      ? { city: data.city, region: data.regionName, country: data.country }
      : blank;
  } catch { return blank; }
  finally   { clearTimeout(t); }
}

// ─── Append one line to data/ai-logs.jsonl ───────────────────────
function appendLog(entry: object) {
  try {
    const dir = join(process.cwd(), "data");
    mkdirSync(dir, { recursive: true });
    appendFileSync(join(dir, "ai-logs.jsonl"), JSON.stringify(entry) + "\n", "utf-8");
  } catch { /* filesystem may be read-only on some hosts */ }
}

// ─── Route handler ───────────────────────────────────────────────
export async function POST(request: NextRequest) {
  if (!process.env.GROQ_API_KEY || process.env.GROQ_API_KEY === "your_groq_api_key_here") {
    return Response.json(
      { error: "AI not configured. Add GROQ_API_KEY to .env.local (get one free at console.groq.com)." },
      { status: 503 }
    );
  }

  const { question, context, deviceId } = await request.json();

  if (!question?.trim()) {
    return Response.json({ error: "Question is required." }, { status: 400 });
  }

  // Build a stable key from deviceId + IP
  const ip  = request.headers.get("x-forwarded-for")?.split(",")[0]?.trim()
            ?? request.headers.get("x-real-ip")
            ?? "unknown";
  const key = deviceId ? `${deviceId}:${ip}` : ip;
  const rec = getRecord(key);

  if (rec.tokens >= AI_TOKEN_LIMIT) {
    return Response.json(
      { error: "Token limit reached for today. Try again in 24 hours.", limited: true },
      { status: 429 }
    );
  }

  const prompt = context ? `(Project context: ${context}) ${question}` : question;

  // Groq + geo lookup run in parallel — geo never delays the AI response
  const [completionResult, geoResult] = await Promise.allSettled([
    groq.chat.completions.create({
      model:      "llama-3.3-70b-versatile",
      max_tokens: 200,
      messages: [
        { role: "system", content: buildSystem() },
        { role: "user",   content: prompt },
      ],
    }),
    fetchGeo(ip),
  ]);

  if (completionResult.status === "rejected") {
    return Response.json({ error: "AI service error. Please try again." }, { status: 500 });
  }

  const completion = completionResult.value;
  const geo        = geoResult.status === "fulfilled"
    ? geoResult.value
    : { city: "-", region: "-", country: "-" };

  const answer = completion.choices[0]?.message?.content ?? "No response received.";
  const used   = completion.usage?.total_tokens ?? 50;

  rec.tokens += used;
  serverUsage.set(key, rec);

  appendLog({
    ts:         new Date().toISOString(),
    ip,
    city:       geo.city,
    region:     geo.region,
    country:    geo.country,
    deviceId:   deviceId ?? null,
    question,
    context:    context ?? null,
    answer,
    tokensUsed: used,
  });

  return Response.json({
    answer,
    tokensUsed:       used,
    serverTokensUsed: rec.tokens,
    tokenLimit:       AI_TOKEN_LIMIT,
  });
}
