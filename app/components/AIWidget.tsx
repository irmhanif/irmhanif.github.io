"use client";

import { useState, useEffect } from "react";
import { AI_CHIPS } from "../content";
import { readUsage, addTokens, hasTokens, timeUntilReset, type UsageState } from "../lib/usage";

interface Message { who: "user" | "bot"; text: string; loading?: boolean; }

export default function AIWidget({ projectContext }: { projectContext?: string }) {
  const [messages, setMessages] = useState<Message[]>([]);
  const [input,    setInput]    = useState("");
  const [loading,  setLoading]  = useState(false);
  const [usage,    setUsage]    = useState<UsageState | null>(null);

  useEffect(() => { setUsage(readUsage()); }, []);

  async function ask(q: string) {
    if (!q.trim() || loading) return;
    setInput("");

    const u = readUsage();
    if (!hasTokens()) {
      setMessages(p => [
        ...p,
        { who: "user", text: q },
        { who: "bot",  text: `Daily limit of ${u.limit} tokens reached. Resets in ${timeUntilReset()}.` },
      ]);
      return;
    }

    setMessages(p => [
      ...p,
      { who: "user", text: q },
      { who: "bot",  text: "", loading: true },
    ]);
    setLoading(true);

    try {
      const apiBase = process.env.NEXT_PUBLIC_API_BASE ?? "";
      const res  = await fetch(`${apiBase}/api/ask`, {
        method:  "POST",
        headers: { "Content-Type": "application/json" },
        body:    JSON.stringify({ question: q, context: projectContext, deviceId: u.deviceId }),
      });
      const data = await res.json();

      if (data.limited) {
        patch({ who: "bot", text: `Daily limit reached. Resets in ${timeUntilReset()}.` });
        return;
      }

      const newUsage = addTokens(data.tokensUsed ?? 50);
      setUsage(newUsage);
      patch({ who: "bot", text: data.answer || data.error || "Something went wrong." });
    } catch {
      patch({ who: "bot", text: "Can't reach assistant right now — email idrishan1996@gmail.com, 24h response." });
    } finally {
      setLoading(false);
    }
  }

  function patch(msg: Message) {
    setMessages(p => { const n = [...p]; n[n.length - 1] = msg; return n; });
  }

  const used    = usage?.tokensUsed ?? 0;
  const limit   = usage?.limit      ?? 2000;
  const pct     = Math.min(100, (used / limit) * 100);
  const inputId = projectContext ? "projAiQ" : "aiQ";

  return (
    <div className="ai-widget" aria-label="AI assistant — ask about Mohamed">
      <div className="ai-hd">
        <div className="ai-hd-left">
          <div className="ai-glyph" aria-hidden="true">ai</div>
          <div className="ai-title">
            Ask about Mohamed <small>answers from his CV</small>
          </div>
        </div>
        <div className="ai-online">online · 24h response</div>
      </div>

      <div className="ai-body">
        {!projectContext && (
          <div className="ai-chips">
            {AI_CHIPS.map(c => (
              <button key={c.label} className="ai-chip" onClick={() => ask(c.q)} disabled={loading}>
                {c.label}
              </button>
            ))}
          </div>
        )}

        <form className="ai-row" onSubmit={e => { e.preventDefault(); ask(input); }} autoComplete="off">
          <label htmlFor={inputId} className="sr-only">Ask about Mohamed</label>
          <input
            id={inputId}
            className="ai-input"
            type="text"
            value={input}
            onChange={e => setInput(e.target.value)}
            placeholder={projectContext ? "Ask about this project…" : "Ask anything — stack, availability, architecture…"}
            disabled={loading}
          />
          <button type="submit" className="ai-send" disabled={loading || !input.trim()}>Ask</button>
        </form>

        {messages.length > 0 && (
          <div className="ai-conv show" role="log" aria-live="polite">
            {messages.map((m, i) => (
              <div key={i} className={`ai-msg ${m.who}`}>
                <span className="who">{m.who === "user" ? "You" : "Mohamed Idris(AI)"}</span>
                {m.loading
                  ? <div className="dot-spin"><span /><span /><span /></div>
                  : <div>{m.text}</div>}
              </div>
            ))}
          </div>
        )}

        {/* ── Usage meter — shared across all widgets via localStorage ── */}
        {usage !== null && (
          <div className="ai-usage">
            <div className="ai-usage-bar">
              <div className="ai-usage-fill" style={{ width: `${pct}%` }} />
            </div>
            <span className="ai-usage-text">
              {used} / {limit} tokens · resets in {timeUntilReset()}
            </span>
          </div>
        )}
      </div>
    </div>
  );
}
