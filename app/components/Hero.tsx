import DownloadResumeButton from "./DownloadResumeButton";
import { HERO } from "../content";

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
          <DownloadResumeButton />
        </div>

        {/* Inline engineering spec line - replaces the 4-box metric grid */}
        <p className="hero-spec-line" aria-label="At a glance">
          <span className="spec-seg"><strong>8 yrs</strong>&nbsp;enterprise&nbsp;</span>
          <span className="sep">·</span>
          <span className="spec-seg">Comcast&nbsp;<strong>FreeWheel</strong></span>
          <span className="sep">·</span>
          <span className="spec-seg"><strong>~90%</strong>&nbsp;Playwright&nbsp;coverage</span>
          <span className="sep">·</span>
          <span className="spec-seg">Walgreens&nbsp;<strong>100%&nbsp;CDC/WCAG</strong></span>
          <span className="sep">·</span>
          <span className="spec-seg"><strong>15+</strong>&nbsp;production&nbsp;apps</span>
        </p>
      </div>
    </div>
  );
}
