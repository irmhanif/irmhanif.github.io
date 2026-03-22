import type { Person } from "@/types";
import MobileNav from "./MobileNav";

export default function Nav({ person }: { person: Person }) {
  return (
    <>
      <nav id="nav">
        <a href="#hero" className="nav-logo">
          {person.nameFirst} <span>{person.nameLast}</span>
        </a>
        <div className="nav-center">
          <a href="#skills">About</a>
          <a href="#experience">Experience</a>
          <a href="#showcase">Projects</a>
          <a href="#freelance">Freelance</a>
          <a href="#abroad">Abroad</a>
          <a href="#contact">Contact</a>
        </div>
        <div className="nav-right">
          <span style={{ fontSize: 18, opacity: 0.6 }} title="Open to international roles">🌍</span>
          <a href={`mailto:${person.email}`} className="btn-hire">Hire Me →</a>
          <MobileNav email={person.email} />
        </div>
      </nav>
    </>
  );
}
