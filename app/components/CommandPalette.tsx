"use client";

import { useState, useEffect, useRef, useCallback } from "react";
import { AI_CHIPS } from "../content";
import { readUsage, addTokens, hasTokens, timeUntilReset, type UsageState } from "../lib/usage";

interface Message { who: "user" | "bot"; text: string; loading?: boolean; }

export default function CommandPalette() {
  const [open, setOpen] = useState(false);
  const [messages, setMessages] = useState<Message[]>([]);
  const [input, setInput] = useState("");
  const [loading, setLoading] = useState(false);
  const [usage, setUsage] = useState<UsageState | null>(null);
  const inputRef = useRef<HTMLInputElement>(null);
  const convRef = useRef<HTMLDivElement>(null);

  // Read usage on mount
  useEffect(() => { setUsage(readUsage()); }, []);

  // ⌘K / Ctrl+K global shortcut
  useEffect(() => {
    function onKey(e: KeyboardEvent) {
      if ((e.metaKey || e.ctrlKey) && e.key === "k") {
        e.preventDefault();
        setOpen(prev => !prev);
      }
      if (e.key === "Escape") setOpen(false);
    }
    document.addEventListener("keydown", onKey);
    return () => document.removeEventListener("keydown", onKey);
  }, []);

  // Autofocus input when palette opens
  useEffect(() => {
    if (open) {
      // Small delay so the animation settles first
      const t = setTimeout(() => inputRef.current?.focus(), 80);
      return () => clearTimeout(t);
    }
  }, [open]);

  // Scroll conversation to bottom on new messages
  useEffect(() => {
    if (convRef.current) {
      convRef.current.scrollTop = convRef.current.scrollHeight;
    }
  }, [messages]);

  // Prevent body scroll when open
  useEffect(() => {
    document.body.style.overflow = open ? "hidden" : "";
    return () => { document.body.style.overflow = ""; };
  }, [open]);

  async function ask(q: string) {
    if (!q.trim() || loading) return;
    setInput("");

    const u = readUsage();
    if (!hasTokens()) {
      setMessages(p => [
        ...p,
        { who: "user", text: q },
        { who: "bot", text: `Daily limit of ${u.limit} tokens reached. Resets in ${timeUntilReset()}.` },
      ]);
      return;
    }

    setMessages(p => [
      ...p,
      { who: "user", text: q },
      { who: "bot", text: "", loading: true },
    ]);
    setLoading(true);

    try {
      const apiBase = process.env.NEXT_PUBLIC_API_BASE || "https://irmhanif-github-io.vercel.app";
      const cleanBase = apiBase.replace(/\/$/, "");
      const res = await fetch(`${cleanBase}/api/ask`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ question: q, deviceId: u.deviceId }),
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
      patch({ who: "bot", text: "Can't reach assistant right now - email idrishan1996@gmail.com, 24h response." });
    } finally {
      setLoading(false);
    }
  }

  function patch(msg: Message) {
    setMessages(p => { const n = [...p]; n[n.length - 1] = msg; return n; });
  }

  const used = usage?.tokensUsed ?? 0;
  const limit = usage?.limit ?? 2000;
  const pct = Math.min(100, (used / limit) * 100);

  const handleBackdropClick = useCallback((e: React.MouseEvent) => {
    if (e.target === e.currentTarget) setOpen(false);
  }, []);

  return (
    <>
      {/* ── Floating dock button ── */}
      <button
        id="cmd-dock-btn"
        className="cmd-dock"
        onClick={() => setOpen(true)}
        aria-label="Open AI assistant (⌘K)"
      >
        <span className="cmd-glyph" aria-hidden="true">ai</span>
        Ask Mohamed
        <span className="cmd-dock-kbd">⌘K</span>
      </button>

      {/* ── Command palette overlay ── */}
      {open && (
        <div
          className="cmd-backdrop"
          onClick={handleBackdropClick}
          role="dialog"
          aria-modal="true"
          aria-label="AI assistant - ask about Mohamed Idris"
        >
          <div className="cmd-panel">
            {/* Header */}
            <div className="cmd-hd">
              <div className="cmd-hd-left">
                <div className="cmd-glyph" aria-hidden="true">ai</div>
                <div className="cmd-title">
                  Ask about Mohamed
                  <small>answers from his CV</small>
                </div>
              </div>
              <button
                className="cmd-close"
                onClick={() => setOpen(false)}
                aria-label="Close"
              >
                ✕
              </button>
            </div>

            {/* Input */}
            <div className="cmd-input-wrap">
              <form onSubmit={e => { e.preventDefault(); ask(input); }} autoComplete="off">
                <label htmlFor="cmd-q" className="sr-only">Ask about Mohamed</label>
                <input
                  id="cmd-q"
                  ref={inputRef}
                  className="cmd-input"
                  type="text"
                  value={input}
                  onChange={e => setInput(e.target.value)}
                  placeholder="Stack, UAE roles, availability, Playwright, architecture…"
                  disabled={loading}
                />
              </form>
            </div>

            {/* Suggestion chips */}
            <div className="cmd-chips">
              {AI_CHIPS.map(c => (
                <button
                  key={c.label}
                  className="cmd-chip"
                  onClick={() => ask(c.q)}
                  disabled={loading}
                >
                  {c.label}
                </button>
              ))}
            </div>

            {/* Send button */}
            <div className="cmd-send-row">
              <button
                className="cmd-send"
                onClick={() => ask(input)}
                disabled={loading || !input.trim()}
              >
                {loading ? "Thinking…" : "Ask →"}
              </button>
            </div>

            {/* Conversation */}
            {messages.length > 0 && (
              <div className="cmd-conv" ref={convRef} role="log" aria-live="polite">
                {messages.map((m, i) => (
                  <div key={i} className={`cmd-msg ${m.who}`}>
                    <span className="who">{m.who === "user" ? "You" : "Mohamed Idris (AI)"}</span>
                    {m.loading
                      ? <div className="dot-spin"><span /><span /><span /></div>
                      : <div>{m.text}</div>}
                  </div>
                ))}
              </div>
            )}

            {/* Usage meter */}
            {usage !== null && (
              <div className="cmd-usage">
                <div className="cmd-usage-bar">
                  <div className="cmd-usage-fill" style={{ width: `${pct}%` }} />
                </div>
                <span className="cmd-usage-text">
                  {used} / {limit} tokens · resets in {timeUntilReset()}
                </span>
              </div>
            )}
          </div>
        </div>
      )}
    </>
  );
}
