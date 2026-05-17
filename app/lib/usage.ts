// Client-side token usage tracking — browser only (localStorage).
// All AI widgets share the same limit across the entire portfolio.

import { AI_TOKEN_LIMIT } from "../content";

const KEY      = "portfolio_ai_v1";
const RESET_MS = 24 * 60 * 60 * 1000;

export interface UsageState {
  deviceId: string;
  tokensUsed: number;
  limit: number;
  resetAt: number;
}

function fresh(): UsageState {
  return {
    deviceId:  crypto.randomUUID(),
    tokensUsed: 0,
    limit:      AI_TOKEN_LIMIT,
    resetAt:    Date.now() + RESET_MS,
  };
}

export function readUsage(): UsageState {
  try {
    const raw = localStorage.getItem(KEY);
    if (raw) {
      const d = JSON.parse(raw) as UsageState;
      // Reset if past the 24 h window but keep same deviceId
      if (d.resetAt > Date.now()) return d;
      const reset: UsageState = { ...fresh(), deviceId: d.deviceId };
      localStorage.setItem(KEY, JSON.stringify(reset));
      return reset;
    }
  } catch { /* SSR or private-mode guard */ }
  const s = fresh();
  localStorage.setItem(KEY, JSON.stringify(s));
  return s;
}

export function addTokens(n: number): UsageState {
  const s = readUsage();
  s.tokensUsed = Math.min(s.tokensUsed + n, s.limit);
  localStorage.setItem(KEY, JSON.stringify(s));
  return s;
}

export function hasTokens(): boolean {
  const s = readUsage();
  return s.tokensUsed < s.limit;
}

export function timeUntilReset(): string {
  const ms = Math.max(0, readUsage().resetAt - Date.now());
  const h  = Math.floor(ms / 3_600_000);
  const m  = Math.floor((ms % 3_600_000) / 60_000);
  return h > 0 ? `${h}h ${m}m` : `${m}m`;
}
