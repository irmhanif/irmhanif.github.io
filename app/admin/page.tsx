"use client";

import { useState } from "react";

interface LogEntry {
  ts:         string;
  ip:         string;
  city:       string;
  region:     string;
  country:    string;
  deviceId:   string | null;
  question:   string;
  context:    string | null;
  answer:     string;
  tokensUsed: number;
}

export default function AdminPage() {
  const [password, setPassword] = useState("");
  const [authed,   setAuthed]   = useState(false);
  const [logs,     setLogs]     = useState<LogEntry[]>([]);
  const [total,    setTotal]    = useState(0);
  const [error,    setError]    = useState("");
  const [loading,  setLoading]  = useState(false);
  const [savedPw,  setSavedPw]  = useState("");
  const [expanded, setExpanded] = useState<number | null>(null);

  async function fetchLogs(pw: string) {
    setLoading(true);
    setError("");
    try {
      const apiBase = process.env.NEXT_PUBLIC_API_BASE ?? "";
      const res  = await fetch(`${apiBase}/api/admin/logs`, {
        headers: { "x-admin-password": pw },
      });
      const data = await res.json();
      if (!res.ok) {
        setError(data.error ?? "Access denied.");
        return false;
      }
      setLogs(data.logs);
      setTotal(data.total);
      return true;
    } catch {
      setError("Network error — check server.");
      return false;
    } finally {
      setLoading(false);
    }
  }

  async function handleLogin(e: React.FormEvent) {
    e.preventDefault();
    const ok = await fetchLogs(password);
    if (ok) { setAuthed(true); setSavedPw(password); }
  }

  function fmt(ts: string) {
    return new Date(ts).toLocaleString("en-GB", {
      day: "2-digit", month: "short", year: "numeric",
      hour: "2-digit", minute: "2-digit", second: "2-digit",
    });
  }

  /* ── styles ── */
  const s = {
    page:    { minHeight: "100vh", background: "#0d0d0f", color: "#e8e8ec", fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif", padding: "40px 32px" } as React.CSSProperties,
    wrap:    { maxWidth: 1300, margin: "0 auto" } as React.CSSProperties,
    hdr:     { marginBottom: 32 } as React.CSSProperties,
    h1:      { fontSize: 22, fontWeight: 800, letterSpacing: "-.02em", marginBottom: 4 } as React.CSSProperties,
    sub:     { color: "#666680", fontSize: 13 } as React.CSSProperties,
    card:    { background: "#141416", border: "1px solid #2a2a30", borderRadius: 12, padding: "28px 24px", maxWidth: 380 } as React.CSSProperties,
    label:   { display: "block", fontSize: 11, color: "#a0a0b0", marginBottom: 8, fontWeight: 700, letterSpacing: ".06em", textTransform: "uppercase" as const },
    input:   { width: "100%", background: "#0d0d0f", border: "1px solid #2a2a30", borderRadius: 8, padding: "10px 14px", color: "#e8e8ec", fontSize: 14, outline: "none", marginBottom: 14, boxSizing: "border-box" as const },
    btn:     { background: "#7c6dff", color: "#fff", border: "none", borderRadius: 8, padding: "10px 20px", fontSize: 13, fontWeight: 700, cursor: "pointer", width: "100%" } as React.CSSProperties,
    err:     { color: "#f87171", fontSize: 12, marginBottom: 12 } as React.CSSProperties,
    th:      { padding: "10px 14px", textAlign: "left" as const, fontSize: 10, fontWeight: 700, letterSpacing: ".07em", textTransform: "uppercase" as const, color: "#666680", borderBottom: "1px solid #2a2a30", whiteSpace: "nowrap" as const, background: "#141416" },
    td:      { padding: "10px 14px", borderBottom: "1px solid #1c1c20", verticalAlign: "top" as const },
    mono:    { fontFamily: "'JetBrains Mono', 'Fira Code', monospace", fontSize: 11.5 } as React.CSSProperties,
    pill:    (c: string) => ({ display: "inline-block", padding: "2px 8px", borderRadius: 20, fontSize: 10, fontWeight: 700, letterSpacing: ".04em", textTransform: "uppercase" as const, background: c === "country" ? "rgba(79,195,247,.12)" : "rgba(124,109,255,.12)", color: c === "country" ? "#4fc3f7" : "#7c6dff" }),
  };

  /* ── login screen ── */
  if (!authed) {
    return (
      <div style={s.page}>
        <div style={s.wrap}>
          <div style={s.hdr}>
            <h1 style={s.h1}>AI Interaction Log</h1>
            <p style={s.sub}>Admin access — enter password to view logged questions.</p>
          </div>
          <form onSubmit={handleLogin} style={s.card}>
            <label style={s.label}>Admin password</label>
            <input
              type="password"
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="••••••••"
              autoFocus
              style={s.input}
            />
            {error && <p style={s.err}>{error}</p>}
            <button type="submit" disabled={loading || !password} style={{ ...s.btn, opacity: !password ? .4 : 1, cursor: loading ? "wait" : "pointer" }}>
              {loading ? "Checking…" : "View logs →"}
            </button>
          </form>
        </div>
      </div>
    );
  }

  /* ── dashboard ── */
  return (
    <div style={s.page}>
      <div style={s.wrap}>

        {/* header bar */}
        <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", marginBottom: 28, flexWrap: "wrap", gap: 12 }}>
          <div>
            <h1 style={s.h1}>AI Interaction Log</h1>
            <p style={s.sub}><span style={{ color: "#e8e8ec", fontWeight: 700 }}>{total}</span> total interactions · newest first</p>
          </div>
          <div style={{ display: "flex", gap: 12, alignItems: "center" }}>
            <button
              onClick={() => fetchLogs(savedPw)}
              disabled={loading}
              style={{ background: "transparent", border: "1px solid #2a2a30", borderRadius: 8, padding: "7px 14px", color: "#a0a0b0", fontSize: 12, cursor: "pointer" }}
            >
              {loading ? "…" : "↻ Refresh"}
            </button>
            <button
              onClick={() => { setAuthed(false); setLogs([]); setPassword(""); setSavedPw(""); }}
              style={{ background: "transparent", border: "1px solid #2a2a30", borderRadius: 8, padding: "7px 14px", color: "#666680", fontSize: 12, cursor: "pointer" }}
            >
              Lock ⎋
            </button>
          </div>
        </div>

        {logs.length === 0 ? (
          <div style={{ textAlign: "center", padding: "80px 20px", color: "#666680", fontSize: 14 }}>
            No questions logged yet. Once a visitor uses the AI widget, entries will appear here.
          </div>
        ) : (
          <div style={{ overflowX: "auto", borderRadius: 10, border: "1px solid #2a2a30" }}>
            <table style={{ width: "100%", borderCollapse: "collapse", fontSize: 13 }}>
              <thead>
                <tr>
                  {["#", "Time (UTC)", "IP Address", "Location", "Question / Context", "Answer", "Tokens"].map(h => (
                    <th key={h} style={s.th}>{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {logs.map((log, i) => {
                  const isOpen = expanded === i;
                  const rowBg  = i % 2 === 0 ? "transparent" : "rgba(255,255,255,.013)";
                  return (
                    <tr key={i} style={{ background: rowBg, cursor: "pointer" }} onClick={() => setExpanded(isOpen ? null : i)}>

                      {/* row number */}
                      <td style={{ ...s.td, ...s.mono, color: "#444460", width: 36, textAlign: "right" }}>
                        {total - i}
                      </td>

                      {/* timestamp */}
                      <td style={{ ...s.td, ...s.mono, color: "#666680", whiteSpace: "nowrap" }}>
                        {fmt(log.ts)}
                      </td>

                      {/* IP */}
                      <td style={{ ...s.td, ...s.mono, color: "#a0a0b0", whiteSpace: "nowrap" }}>
                        {log.ip}
                      </td>

                      {/* location */}
                      <td style={{ ...s.td, whiteSpace: "nowrap" }}>
                        <div style={{ color: "#e8e8ec", fontSize: 12, fontWeight: 600 }}>{log.city}</div>
                        {log.region && log.region !== "-" && (
                          <div style={{ color: "#666680", fontSize: 11 }}>{log.region}</div>
                        )}
                        {log.country && log.country !== "-" && (
                          <span style={s.pill("country")}>{log.country}</span>
                        )}
                      </td>

                      {/* question */}
                      <td style={{ ...s.td, maxWidth: 300 }}>
                        {log.context && (
                          <div style={{ fontSize: 10, color: "#7c6dff", marginBottom: 4, fontFamily: "monospace", background: "rgba(124,109,255,.08)", display: "inline-block", padding: "1px 7px", borderRadius: 4 }}>
                            {log.context}
                          </div>
                        )}
                        <div style={{ color: "#e8e8ec", lineHeight: 1.55, fontSize: 13 }}>
                          {log.question}
                        </div>
                      </td>

                      {/* answer */}
                      <td style={{ ...s.td, maxWidth: 380, color: "#a0a0b0", lineHeight: 1.6, fontSize: 12 }}>
                        {isOpen
                          ? log.answer
                          : log.answer.length > 120
                            ? <>{log.answer.slice(0, 120)}<span style={{ color: "#444460" }}>… (click to expand)</span></>
                            : log.answer
                        }
                      </td>

                      {/* tokens */}
                      <td style={{ ...s.td, ...s.mono, textAlign: "right", color: "#666680", whiteSpace: "nowrap", width: 64 }}>
                        {log.tokensUsed}
                      </td>

                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
        )}

        {/* stats bar */}
        {logs.length > 0 && (
          <div style={{ marginTop: 20, display: "flex", gap: 24, flexWrap: "wrap" }}>
            {[
              { label: "Total questions", value: total },
              { label: "Total tokens used", value: logs.reduce((s, l) => s + (l.tokensUsed ?? 0), 0).toLocaleString() },
              { label: "Unique IPs", value: new Set(logs.map(l => l.ip)).size },
              { label: "Countries", value: new Set(logs.map(l => l.country).filter(c => c && c !== "-")).size },
            ].map(stat => (
              <div key={stat.label} style={{ background: "#141416", border: "1px solid #2a2a30", borderRadius: 8, padding: "12px 18px" }}>
                <div style={{ fontSize: 11, color: "#666680", textTransform: "uppercase", letterSpacing: ".06em", fontWeight: 700 }}>{stat.label}</div>
                <div style={{ fontSize: 22, fontWeight: 800, color: "#e8e8ec", marginTop: 2 }}>{stat.value}</div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
