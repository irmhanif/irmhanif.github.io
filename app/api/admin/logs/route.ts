import { NextRequest } from "next/server";
import { readFileSync } from "fs";
import { join } from "path";

export const dynamic = "force-static";

export async function GET(request: NextRequest) {
  const url      = new URL(request.url);
  const password = request.headers.get("x-admin-password") ?? url.searchParams.get("p");

  if (!process.env.ADMIN_PASSWORD || password !== process.env.ADMIN_PASSWORD) {
    return Response.json({ error: "Unauthorized" }, { status: 401 });
  }

  try {
    const raw  = readFileSync(join(process.cwd(), "data", "ai-logs.jsonl"), "utf-8");
    const logs = raw
      .trim()
      .split("\n")
      .filter(Boolean)
      .map(line => JSON.parse(line))
      .reverse();
    return Response.json({ logs, total: logs.length });
  } catch {
    return Response.json({ logs: [], total: 0 });
  }
}
