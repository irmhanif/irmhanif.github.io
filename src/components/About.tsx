import type { About } from "@/types";

export default function About({ about }: { about: About }) {
  return (
    <section id="skills" className="alt-bg">
      <div className="sec-eyebrow">About &amp; Skills</div>
      <h2 className="sec-h2">Engineered for<br /><em>performance.</em></h2>

      <div className="skills-wrap reveal">
        <div>
          <div className="about-body">
            {about.paragraphs.map((p, i) => (
              <p key={i} dangerouslySetInnerHTML={{ __html: p }} />
            ))}
            <div className="about-pull">{about.pullQuote}</div>
          </div>
          <div className="about-chips">
            {about.chips.map((chip) => (
              <div className="achip" key={chip}>{chip}</div>
            ))}
          </div>
        </div>

        <div className="skill-col">
          {about.skills.map((group) => (
            <div key={group.group}>
              <div className="sg-head">{group.group}</div>
              <div className="pills">
                {group.items.map((item) => (
                  <span className={`pill${group.star ? " star" : ""}`} key={item}>{item}</span>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
