"use client";

import { useState, useEffect } from "react";
import { SITE } from "../content";

export default function Nav() {
  const [isDark,   setIsDark]   = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    setIsDark(localStorage.getItem("v4-theme") === "dark");
  }, []);

  function toggleTheme() {
    const next = isDark ? "light" : "dark";
    document.documentElement.setAttribute("data-theme", next);
    localStorage.setItem("v4-theme", next);
    setIsDark(!isDark);
  }

  function toggleMenu() {
    const next = !menuOpen;
    setMenuOpen(next);
    document.body.style.overflow = next ? "hidden" : "";
  }

  function closeMenu() {
    setMenuOpen(false);
    document.body.style.overflow = "";
  }

  return (
    <>
      <nav className="main" aria-label="Primary navigation">
        <div className="nav-inner">
          <a href="#" className="brand">
            {SITE.name}<span className="dot">.</span>
            <span className="role">{SITE.roleTag}</span>
          </a>
          <div className="nav-links">
            <a href="#about">About</a>
            <a href="#stack">Stack</a>
            <a href="#experience">Experience</a>
            <a href="#projects">Work</a>
            <a href="#contact">Contact</a>
          </div>
          <div className="nav-controls">
            <button className="nav-icon-btn" onClick={toggleTheme} aria-label="Toggle dark mode">
              {isDark ? "☀" : "☾"}
            </button>
            <a href="#contact" className="nav-cta">Hire me →</a>
            <button
              className={`ham-btn${menuOpen ? " open" : ""}`}
              onClick={toggleMenu}
              aria-label="Open menu"
              aria-expanded={menuOpen}
            >
              <span /><span /><span />
            </button>
          </div>
        </div>
      </nav>

      <div className={`mobile-menu${menuOpen ? " open" : ""}`} aria-hidden={!menuOpen}>
        <a href="#about"      onClick={closeMenu}>About</a>
        <a href="#stack"      onClick={closeMenu}>Stack</a>
        <a href="#experience" onClick={closeMenu}>Experience</a>
        <a href="#projects"   onClick={closeMenu}>Work</a>
        <a href="#contact"    onClick={closeMenu}>Contact</a>
        <a href={`mailto:${SITE.email}`} className="mobile-cta" onClick={closeMenu}>
          Get in touch →
        </a>
      </div>
    </>
  );
}
