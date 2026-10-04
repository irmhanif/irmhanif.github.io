"use client";

import { useState, useEffect, useCallback } from "react";
import { PROJECTS } from "../content";

// Tag → category CSS class mapping for coloured category badges
const catClass: Record<string, string> = {
  "Comcast": "enterprise",
  "Cognizant": "healthcare",
  "CodeCraft Technologies": "telecom",
  "Zinavo": "",
  "Production": "",
};

function getCatClass(client: string) {
  const company = client.split("·")[0].trim();
  return catClass[company] ?? "";
}

// Featured projects get wider card treatment
const FEATURED = new Set(["fw", "wg"]);

export default function Projects() {
  const [openId, setOpenId] = useState<string | null>(null);
  const open = PROJECTS.find(p => p.id === openId);

  // Lock body scroll when modal is open
  useEffect(() => {
    document.body.style.overflow = openId ? "hidden" : "";
    return () => { document.body.style.overflow = ""; };
  }, [openId]);

  // Escape key closes modal
  useEffect(() => {
    function onKey(e: KeyboardEvent) {
      if (e.key === "Escape") setOpenId(null);
    }
    document.addEventListener("keydown", onKey);
    return () => document.removeEventListener("keydown", onKey);
  }, []);

  const closeModal = useCallback(() => setOpenId(null), []);

  const handleBackdrop = useCallback((e: React.MouseEvent) => {
    if (e.target === e.currentTarget) setOpenId(null);
  }, []);

  return (
    <section id="projects" className="alt" aria-labelledby="proj-h">
      <div className="wrap layout-casestudy">
        {/* Full-width editorial header */}
        <div className="cs-header reveal">
          <div>
            <h2 className="cs-title" id="proj-h">Selected work</h2>
            <p className="cs-subtitle">
              Enterprise frontend · React · TypeScript · Production at scale
            </p>
          </div>
          <span className="cs-count">{PROJECTS.length} projects</span>
        </div>

        <div className="proj-grid reveal reveal-d2">
          {PROJECTS.map(p => (
            <button
              key={p.id}
              className={`proj${FEATURED.has(p.id) ? " featured" : ""}`}
              onClick={() => setOpenId(p.id)}
              aria-haspopup="dialog"
            >
              <div className="proj-head">
                <span className={`proj-cat-tag ${getCatClass(p.client)}`}>
                  {p.client}
                </span>
              </div>
              <div className="proj-name">{p.name}</div>
              <div className="proj-desc">{p.desc}</div>
              <div className="proj-kpi">{p.kpi}</div>
              <div className="proj-foot">
                <div className="proj-tags">
                  {p.tags.map((t, i) => (
                    <span key={t} className="proj-tag">{i > 0 && " · "}{t}</span>
                  ))}
                </div>
                {/* Always-visible CTA - no hover-only opacity trick */}
                <span className="proj-more">Case study →</span>
              </div>
            </button>
          ))}
        </div>
      </div>

      {/* ── Case study modal overlay ── */}
      {open && (
        <div
          className="cs-modal-backdrop"
          onClick={handleBackdrop}
          role="dialog"
          aria-modal="true"
          aria-labelledby="cs-modal-title"
        >
          <div className="cs-modal">
            {/* Modal header */}
            <div className="cs-modal-hd">
              <div>
                <div className="cs-modal-title" id="cs-modal-title">{open.name}</div>
                <div className="cs-modal-client">{open.client}</div>
              </div>
              <button
                className="cs-modal-close"
                onClick={closeModal}
                aria-label="Close case study"
              >
                ✕
              </button>
            </div>

            {/* Stack + KPI bar */}
            <div className="cs-modal-meta">
              <div className="cs-modal-meta-group">
                <span className="cs-modal-meta-label">Stack</span>
                <div>{open.tags.map(t => <span key={t} className="tok">{t}</span>)}</div>
              </div>
              <div className="cs-modal-meta-group">
                <span className="cs-modal-meta-label">Impact</span>
                <div className="cs-modal-kpi">{open.kpi}</div>
              </div>
            </div>

            {/* Main body - scrollable */}
            <div className="cs-modal-body">
              <div className="cs-modal-text">
                {open.detail}
              </div>
              {open.link && (
                <a
                  href={open.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="cs-modal-link"
                >
                  Visit Website ↗
                </a>
              )}
            </div>

            {/* Footer hint */}
            <div className="cs-modal-foot">
              <span>Press <kbd>Esc</kbd> to close</span>
              <button className="cs-modal-close-btn" onClick={closeModal}>
                Close case study ✕
              </button>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
