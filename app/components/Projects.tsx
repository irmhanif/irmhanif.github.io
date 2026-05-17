"use client";

import { useState, useEffect } from "react";
import AIWidget from "./AIWidget";
import { PROJECTS } from "../content";

export default function Projects() {
  const [openId, setOpenId] = useState<string | null>(null);

  // Auto-scroll to the AI chat whenever a project is opened
  useEffect(() => {
    if (!openId) return;
    // Double rAF — ensures detail panel is in DOM before we measure
    const id = requestAnimationFrame(() =>
      requestAnimationFrame(() => {
        const widget = document.querySelector<HTMLElement>(".proj-detail .ai-widget");
        if (widget) widget.scrollIntoView({ behavior: "smooth", block: "nearest" });
      })
    );
    return () => cancelAnimationFrame(id);
  }, [openId]);

  const open = PROJECTS.find(p => p.id === openId);

  return (
    <section id="projects" className="alt" aria-labelledby="proj-h">
      <div className="wrap">
        <div className="grid-2 reveal">
          <div className="sec-label reveal reveal-d1">
            <span className="num">04</span>Selected work
          </div>
          <div className="reveal reveal-d2">
            <h2 className="sr-only" id="proj-h">Selected work</h2>

            <div className="proj-grid">
              {PROJECTS.map(p => (
                <button
                  key={p.id}
                  className="proj"
                  aria-expanded={openId === p.id}
                  onClick={() => setOpenId(prev => prev === p.id ? null : p.id)}
                >
                  <div className="proj-head">
                    <span className="proj-num">{p.num}</span>
                    <span className={`proj-cat-tag`}>{p.client.split("·")[0].trim()}</span>
                  </div>
                  <div className="proj-name">{p.name}</div>
                  <div className="proj-client">{p.client}</div>
                  <div className="proj-desc">{p.desc}</div>
                  <div className="proj-kpi">{p.kpi}</div>
                  <div className="proj-foot">
                    <div className="proj-tags">
                      {p.tags.map((t, i) => (
                        <span key={t} className="proj-tag">{i > 0 && " · "}{t}</span>
                      ))}
                    </div>
                    <span className="proj-more">Details →</span>
                  </div>
                </button>
              ))}

              {open && (
                <div className="proj-detail">
                  <div className="proj-detail-hd">
                    <div>
                      <div className="proj-detail-title">{open.name}</div>
                      <div style={{ fontFamily: "var(--font-mono)", fontSize: "10.5px", color: "var(--ink-4)", marginTop: 3, textTransform: "uppercase" }}>
                        {open.client}
                      </div>
                    </div>
                    <button
                      className="proj-close-btn"
                      onClick={e => { e.stopPropagation(); setOpenId(null); }}
                    >
                      Close ✕
                    </button>
                  </div>
                  <div className="proj-detail-body">
                    <div>
                      <p style={{ fontSize: 14, lineHeight: 1.7, color: "var(--ink-2)" }}>{open.detail}</p>
                      <div style={{ marginTop: 16 }}>
                        <AIWidget projectContext={`${open.name} for ${open.client}. ${open.detail}`} />
                      </div>
                    </div>
                    <div>
                      <div className="proj-detail-meta-label">Stack</div>
                      <div>{open.tags.map(t => <span key={t} className="tok">{t}</span>)}</div>
                      <div className="proj-detail-meta-label" style={{ marginTop: 16 }}>KPI</div>
                      <div className="proj-detail-kpi">{open.kpi}</div>
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
