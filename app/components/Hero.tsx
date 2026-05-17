import AIWidget from "./AIWidget";
import StatCounter from "./StatCounter";
import { HERO, SITE } from "../content";

export default function Hero() {
  return (
    <div className="hero">
      <div className="hero-inner">
        <div className="hero-meta">
          {HERO.available && (
            <span className="pill-avail">
              <span className="blip" />
              {HERO.availableText}
            </span>
          )}
          <span className="pill-loc">{HERO.location}</span>
        </div>

        <h1 className="display" id="hero-h">
          {HERO.headline}
          <br />
          {HERO.headlineLine2} <span className="hi">{HERO.headlineHighlight}</span>
          <br />
          {HERO.headlineLine3}
        </h1>

        <p className="hero-lede">
          I&apos;m <strong>{HERO.ledeName}</strong> {HERO.ledeBody}{" "}
          <strong>{HERO.ledeCompany}</strong> {HERO.ledeTail}
        </p>

        <div className="hero-cta-row">
          <a href="#projects" className="btn btn-primary">
            See selected work <span className="arr">→</span>
          </a>
          <a href="#contact" className="btn btn-ghost">
            Hire me <span className="arr">→</span>
          </a>
        </div>

        <div className="hero-specs" aria-label="At a glance">
          {HERO.specs.map(s => (
            <div key={s.k} className="spec">
              <div className="k">{s.k}</div>
              <div className="v">
                <StatCounter value={s.value} suffix={s.suffix} prefix={s.prefix} />
              </div>
            </div>
          ))}
        </div>

        <AIWidget />
      </div>
    </div>
  );
}
