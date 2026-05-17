import { EXPERIENCE } from "../content";
import { renderBullet } from "../lib/renderBullet";

export default function Experience() {
  return (
    <section id="experience" aria-labelledby="xp-h">
      <div className="wrap">
        <div className="grid-2 reveal">
          <div className="sec-label reveal reveal-d1">
            <span className="num">03</span>Experience
          </div>
          <div className="reveal reveal-d2">
            <h2 className="sr-only" id="xp-h">Career experience</h2>
            <div className="xp-list">
              {EXPERIENCE.map((job, i) => (
                <article
                  key={job.company + job.period}
                  className={`xp-item reveal reveal-d${Math.min(i + 1, 4)}`}
                >
                  <div className="xp-when">
                    {job.period}
                    {job.current && <div className="xp-now">Current role</div>}
                  </div>
                  <div>
                    <div className="xp-role">{job.role}</div>
                    <div className="xp-co">
                      {job.company}<span className="city">{job.city}</span>
                    </div>
                    <ul className="xp-bullets">
                      {job.bullets.map((b, j) => (
                        <li key={j}>{renderBullet(b)}</li>
                      ))}
                    </ul>
                    {job.award && (
                      <div className="xp-award">{job.award}</div>
                    )}
                  </div>
                </article>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
