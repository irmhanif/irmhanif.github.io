import type { Hero, Person } from "@/types";

export default function Hero({ hero, person }: { hero: Hero; person: Person }) {
  return (
    <section id="hero">
      <div className="hero-noise" />
      <div className="hero-glow hg1" />
      <div className="hero-glow hg2" />
      <div className="hero-grid-lines" />
      <div className="hero-inner">
        <div className="hero-top-row">
          <div className="hero-status">
            <span className="status-dot" />{hero.statusLabel}
          </div>
          <div className="hero-award">{person.award}</div>
        </div>

        <h1 className="hero-h1">
          {hero.headline[0]}<br />
          <em>{hero.headline[1]}</em>
        </h1>

        <p className="hero-sub">
          <strong>{hero.subHeadline}</strong> — {person.yearsExperience} years building enterprise web apps at{" "}
          <span className="hi">{hero.clients}</span><br />
          {hero.subText}
        </p>

        <div className="hero-stats">
          {hero.stats.map((s) => (
            <div className="hstat" key={s.label}>
              <div
                className="hstat-n"
                data-val={s.value}
                data-suffix={s.suffix}
                data-float={s.isFloat ? "1" : "0"}
              >
                {s.isFloat ? s.value.toFixed(1) : s.value}{s.suffix}
              </div>
              <div className="hstat-l">{s.label}</div>
            </div>
          ))}
        </div>

        <div className="hero-cta">
          <a href={hero.ctaPrimary.href} className="cta-primary">{hero.ctaPrimary.label}</a>
          <a href={hero.ctaSecondary.href} className="cta-ghost">{hero.ctaSecondary.label}</a>
        </div>
      </div>
      <div className="hero-scroll-hint">
        <div className="scroll-track" />Scroll to explore
      </div>
    </section>
  );
}
