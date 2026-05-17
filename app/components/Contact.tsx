import { CONTACT, SITE } from "../content";

export default function Contact() {
  return (
    <section id="contact" aria-labelledby="contact-h">
      <div className="wrap">
        <div className="contact-center reveal">
          <h2 id="contact-h" className="contact-h">
            {CONTACT.headline} <span className="hi">{CONTACT.headlineHi}</span>
          </h2>
          <p className="contact-sub">{CONTACT.subtext}</p>
          <div className="contact-grid">
            <a className="contact-card" href={`mailto:${SITE.email}`}>
              <div><div className="k">Email</div><div className="v">{SITE.email}</div></div>
              <span className="arr">→</span>
            </a>
            <a className="contact-card" href={`tel:${SITE.phone.replace(/\s/g, "")}`}>
              <div><div className="k">Phone</div><div className="v">{SITE.phone}</div></div>
              <span className="arr">→</span>
            </a>
            <a className="contact-card" href={SITE.linkedinUrl} target="_blank" rel="noopener noreferrer">
              <div><div className="k">LinkedIn</div><div className="v">{SITE.linkedinLabel}</div></div>
              <span className="arr">→</span>
            </a>
            <a className="contact-card" href={SITE.githubUrl} target="_blank" rel="noopener noreferrer">
              <div><div className="k">GitHub</div><div className="v">{SITE.githubLabel}</div></div>
              <span className="arr">→</span>
            </a>
          </div>
          <div className="avail-pill">{CONTACT.availability}</div>
        </div>
      </div>
    </section>
  );
}
