import type { Job } from "@/types";

export default function Experience({ experience }: { experience: Job[] }) {
  return (
    <section id="experience">
      <div className="sec-eyebrow">Career Timeline</div>
      <h2 className="sec-h2">Where I&apos;ve<br /><em>built things.</em></h2>

      <div className="exp-list">
        {experience.map((job) => (
          <div className="exp-item reveal" key={job.company + job.period}>
            <div className="exp-meta">
              <div className="exp-period">{job.period}</div>
              <div className="exp-co">{job.company}</div>
              <div className="exp-city">{job.city}</div>
              {job.isCurrent && (
                <div className="exp-badge-now">
                  <span className="exp-badge-now-dot" />Current Role
                </div>
              )}
            </div>
            <div className="exp-body">
              <div className="exp-title">{job.title}</div>
              <ul className="exp-bullets">
                {job.bullets.map((b, i) => (
                  <li key={i} dangerouslySetInnerHTML={{ __html: b }} />
                ))}
              </ul>
              {job.award && <div className="exp-award-tag">{job.award}</div>}
            </div>
          </div>
        ))}
      </div>
    </section>
  );
}
