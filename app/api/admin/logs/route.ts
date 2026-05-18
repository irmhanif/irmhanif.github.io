import { NextRequest } from "next/server";
import { readFileSync } from "fs";
import { join } from "path";

export const dynamic = "force-dynamic";

const CORS_ORIGIN = process.env.CORS_ORIGIN || "https://idrism.com";
const corsHeaders = {
  "Access-Control-Allow-Origin":  CORS_ORIGIN,
  "Access-Control-Allow-Methods": "GET, OPTIONS",
  "Access-Control-Allow-Headers": "Content-Type, x-admin-password",
};

export function OPTIONS() {
  return new Response(null, { status: 204, headers: corsHeaders });
}

function json(body: object, status = 200) {
  return Response.json(body, { status, headers: corsHeaders });
}

export async function GET(request: NextRequest) {
  const url      = new URL(request.url);
  const password = request.headers.get("x-admin-password") ?? url.searchParams.get("p");

  if (!process.env.ADMIN_PASSWORD || password !== process.env.ADMIN_PASSWORD) {
    return json({ error: "Unauthorized" }, 401);
  }

  try {
    const raw  = readFileSync(join(process.cwd(), "data", "ai-logs.jsonl"), "utf-8");
    const logs = raw
      .trim()
      .split("\n")
      .filter(Boolean)
      .map(line => JSON.parse(line))
      .reverse();
    return json({ logs, total: logs.length });
  } catch {
    return json({ logs: [], total: 0 });
  }
}
