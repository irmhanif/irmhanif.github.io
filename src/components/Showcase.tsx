import type { Projects, Person } from "@/types";
import ShowcaseClient from "./ShowcaseClient";

export default function Showcase({ projects, person }: { projects: Projects; person: Person }) {
  return (
    <section id="showcase">
      <div className="sec-eyebrow">Selected Work</div>
      <h2 className="sec-h2">Things I&apos;ve<br /><em>shipped.</em></h2>
      <ShowcaseClient projects={projects} person={person} />
    </section>
  );
}
