"use client";
import { useEffect } from "react";

export default function ClientScripts() {
  useEffect(() => {
    /* ── CUSTOM CURSOR ── */
    const cur = document.getElementById("cur");
    const ring = document.getElementById("cur-ring");
    if (cur && ring) {
      let mx = 0, my = 0, rx = 0, ry = 0;
      document.addEventListener("mousemove", (e) => {
        mx = e.clientX; my = e.clientY;
        cur.style.left = mx + "px";
        cur.style.top = my + "px";
      });
      (function loop() {
        rx += (mx - rx) * 0.1;
        ry += (my - ry) * 0.1;
        ring.style.left = rx + "px";
        ring.style.top = ry + "px";
        requestAnimationFrame(loop);
      })();
      const hoverEls = "a,button,.pill,.pcard,.service-row,.proof-card,.role-card,.filter-btn,.clink";
      document.querySelectorAll(hoverEls).forEach((el) => {
        el.addEventListener("mouseenter", () => document.body.classList.add("hovering"));
        el.addEventListener("mouseleave", () => document.body.classList.remove("hovering"));
      });
    }

    /* ── SCROLL PROGRESS ── */
    const nav = document.getElementById("nav");
    const prog = document.getElementById("prog");
    const onScroll = () => {
      if (nav) nav.classList.toggle("stuck", window.scrollY > 70);
      if (prog) {
        const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        prog.style.width = pct + "%";
      }
    };
    window.addEventListener("scroll", onScroll, { passive: true });

    /* ── REVEAL ON SCROLL ── */
    const revObs = new IntersectionObserver((entries) => {
      entries.forEach((e, i) => {
        if (e.isIntersecting) {
          setTimeout(() => e.target.classList.add("on"), i * 60);
          revObs.unobserve(e.target);
        }
      });
    }, { threshold: 0.08 });
    document.querySelectorAll(".reveal").forEach((r) => revObs.observe(r));

    /* ── STAT COUNTERS ── */
    function countUp(el: HTMLElement, end: number, suffix: string, isFloat: boolean) {
      const dur = 1800;
      let start: number | null = null;
      const step = (ts: number) => {
        if (!start) start = ts;
        const p = Math.min((ts - start) / dur, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        el.textContent = (isFloat ? (ease * end).toFixed(1) : Math.floor(ease * end)) + suffix;
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    }
    const statObs = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          const el = e.target as HTMLElement;
          countUp(el, parseFloat(el.dataset.val!), el.dataset.suffix || "", el.dataset.float === "1");
          statObs.unobserve(el);
        }
      });
    }, { threshold: 0.5 });
    document.querySelectorAll(".hstat-n[data-val]").forEach((el) => statObs.observe(el));

    /* ── ESC key closes video modal (handled by ShowcaseClient, but belt+suspenders) ── */
    const onKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") {
        const vmodal = document.getElementById("vmodal");
        if (vmodal?.classList.contains("open")) {
          vmodal.classList.remove("open");
          document.body.style.overflow = "";
        }
      }
    };
    document.addEventListener("keydown", onKey);

    return () => {
      window.removeEventListener("scroll", onScroll);
      document.removeEventListener("keydown", onKey);
    };
  }, []);

  return null;
}
