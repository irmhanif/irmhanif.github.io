import { ABOUT } from "../content";
import { renderBullet } from "../lib/renderBullet";

export default function About() {
  return (
    <section id="about" aria-labelledby="about-h">
      <div className="wrap">
        <div className="grid-2 reveal">
          <div className="sec-label reveal reveal-d1">
            <span className="num">01</span>About
          </div>
          <div className="reveal reveal-d2">
            <h2 className="sr-only" id="about-h">About</h2>
            <div className="about-body">
              {ABOUT.paragraphs.map((p, i) => (
                <p key={i}>{renderBullet(p)}</p>
              ))}
            </div>
            <div className="about-quote">&ldquo;{ABOUT.quote}&rdquo;</div>
            <div className="badges">
              {ABOUT.badges.map(b => (
                <span key={b.text} className={`badge${b.variant ? ` ${b.variant}` : ""}`}>
                  {b.text}
                </span>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
