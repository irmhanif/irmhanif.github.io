"use client";
import { useState } from "react";

const NAV_LINKS = [
  { href: "#skills", label: "About" },
  { href: "#experience", label: "Experience" },
  { href: "#showcase", label: "Projects" },
  { href: "#freelance", label: "Freelance" },
  { href: "#abroad", label: "Abroad" },
  { href: "#contact", label: "Contact" },
];

export default function MobileNav({ email }: { email: string }) {
  const [open, setOpen] = useState(false);

  const close = () => setOpen(false);
  const toggle = () => setOpen((v) => !v);

  return (
    <>
      {/* Hamburger button */}
      <button
        className="hb"
        aria-label="Menu"
        onClick={toggle}
      >
        <span
          style={{
            transform: open ? "translateY(6.5px) rotate(45deg)" : undefined,
            transition: "all .3s",
          }}
        />
        <span
          style={{
            opacity: open ? 0 : 1,
            transition: "all .3s",
          }}
        />
        <span
          style={{
            transform: open ? "translateY(-6.5px) rotate(-45deg)" : undefined,
            transition: "all .3s",
          }}
        />
      </button>

      {/* Mobile overlay nav */}
      <div id="mnav" className={open ? "open" : ""}>
        {NAV_LINKS.map((link) => (
          <a key={link.href} href={link.href} onClick={close}>
            {link.label}
          </a>
        ))}
        <a href={`mailto:${email}`} className="mn-hire" onClick={close}>
          HIRE ME →
        </a>
      </div>
    </>
  );
}
