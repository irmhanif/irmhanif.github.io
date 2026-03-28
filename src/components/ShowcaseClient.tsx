"use client";
import { useState } from "react";
import type { Projects, Person, ProjectItem } from "@/types";

interface VideoModalState {
  open: boolean;
  src: string;
  title: string;
  desc: string;
}

function VideoModal({ modal, onClose }: { modal: VideoModalState; onClose: () => void }) {
  return (
    <div
      id="vmodal"
      className={modal.open ? "open" : ""}
      onClick={(e) => { if (e.target === e.currentTarget) onClose(); }}
    >
      <div id="vmodal-inner">
        <button id="vmodal-close" aria-label="Close" onClick={onClose}>✕</button>
        {/* eslint-disable-next-line jsx-a11y/media-has-caption */}
        <video key={modal.src} id="vmodal-video" controls playsInline preload="metadata" src={modal.src} />
        <div id="vmodal-info">
          <div id="vmodal-title">{modal.title}</div>
          <div id="vmodal-desc">{modal.desc}</div>
        </div>
      </div>
    </div>
  );
}

function ProjectCard({
  p,
  email,
  onPlayVideo,
  hidden,
}: {
  p: ProjectItem;
  email: string;
  onPlayVideo: (src: string, title: string, desc: string) => void;
  hidden?: boolean;
}) {
  return (
    <div
      className={`pcard pcard-${p.size}${hidden ? " hidden" : ""}`}
      data-cats={p.cats.join(" ")}
    >
      <div className="pcard-media">
        <div className="pcard-cover" style={{ background: p.coverGradient }}>
          {p.coverPattern && (
            <div style={{ position: "absolute", inset: 0, background: p.coverPattern }} />
          )}
          <span className="pcard-cover-emoji">{p.emoji}</span>
        </div>

        <span className={`pcard-cat ${p.categoryType}`}>{p.category}</span>

        {p.link && !p.videoSrc && (
          <a href={p.link} target="_blank" rel="noopener noreferrer" className="pcard-link-badge" title="Live site">↗</a>
        )}

        {p.videoSrc && (
          <button
            className="pcard-play-btn"
            aria-label="Play demo video"
            onClick={() => onPlayVideo(p.videoSrc!, p.videoTitle ?? p.name, p.videoDesc ?? "")}
          >
            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
          </button>
        )}
      </div>

      <div className="pcard-body">
        <div className="pcard-header">
          <div>
            <div className="pcard-name">{p.name}</div>
            <div className="pcard-client">{p.client}</div>
          </div>
        </div>
        {p.desc && <p className="pcard-desc">{p.desc}</p>}
        {p.kpi && <div className="pcard-kpi">{p.kpi}</div>}
        <div className="pcard-footer">
          <div className="pcard-tags">
            {p.tags.map((t) => <span className="ptag" key={t}>{t}</span>)}
          </div>
          <div className="pcard-actions">
            {p.isNDA && <span className="pcard-action-btn">🔒 NDA</span>}
            {p.link && !p.videoSrc && (
              <a href={p.link} target="_blank" rel="noopener noreferrer" className="pcard-action-btn">↗ Live Site</a>
            )}
            {p.videoSrc && (
              <button
                className="pcard-action-btn"
                onClick={() => onPlayVideo(p.videoSrc!, p.videoTitle ?? p.name, p.videoDesc ?? "")}
              >▶ Watch Demo</button>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

export default function ShowcaseClient({ projects, person }: { projects: Projects; person: Person }) {
  const [activeFilter, setActiveFilter] = useState("all");
  const [modal, setModal] = useState<VideoModalState>({ open: false, src: "", title: "", desc: "" });

  const openVideo = (src: string, title: string, desc: string) => {
    setModal({ open: true, src, title, desc });
    document.body.style.overflow = "hidden";
  };
  const closeVideo = () => {
    setModal((m) => ({ ...m, open: false, src: "" }));
    document.body.style.overflow = "";
  };

  const visibleCount = projects.items.filter(
    (p) => activeFilter === "all" || p.cats.includes(activeFilter)
  ).length;

  return (
    <>
      <VideoModal modal={modal} onClose={closeVideo} />

      <div className="filter-bar">
        {projects.filters.map((label, i) => (
          <button
            key={label}
            className={`filter-btn${activeFilter === projects.filterKeys[i] ? " active" : ""}`}
            onClick={() => setActiveFilter(projects.filterKeys[i])}
          >
            {label}
          </button>
        ))}
        <span className="filter-count">{visibleCount} projects</span>
      </div>

      <div className="showcase-grid">
        {projects.items.map((p) => (
          <ProjectCard
            key={p.id}
            p={p}
            email={person.email}
            onPlayVideo={openVideo}
            hidden={activeFilter !== "all" && !p.cats.includes(activeFilter)}
          />
        ))}

        {/* CTA card — always visible */}
        <div
          className="pcard pcard-sm reveal"
          style={{ background: "var(--goldbg2)", borderStyle: "dashed", borderColor: "var(--gold3)" }}
        >
          <div className="pcard-cta-inner">
            <div style={{ fontSize: 40 }}>🚀</div>
            <div style={{ fontFamily: "var(--font-serif)", fontSize: 22, color: "var(--gold)", fontWeight: 700, lineHeight: 1.2 }}>
              Your Project<br />Next?
            </div>
            <div style={{ fontSize: 12, color: "var(--dim2)", lineHeight: 1.7 }}>
              Senior React Dev available.<br />React · TypeScript · Testing
            </div>
            <a href={`mailto:${person.email}`} className="cta-primary" style={{ fontSize: 12, padding: "10px 20px" }}>
              Let&apos;s Talk →
            </a>
          </div>
        </div>
      </div>
    </>
  );
}
