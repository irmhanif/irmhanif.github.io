import type { Abroad, Person } from "@/types";

export default function Abroad({ abroad, person }: { abroad: Abroad; person: Person }) {
  return (
    <section id="abroad">
      <div className="sec-eyebrow">Remote &amp; International</div>
      <h2 className="sec-h2">Open for<br /><em>abroad roles.</em></h2>

      <div className="abroad-pitch">
        <div>
          <div className="ap-statement">
            Ready to join your <em>global team</em> from day one.
          </div>
          <p className="ap-body" dangerouslySetInnerHTML={{ __html: abroad.body }} />
          <div className="ap-ctas">
            <a href={`mailto:${person.email}`} className="ap-btn">📩 Send Me a Role</a>
            <a href={person.linkedin} target="_blank" rel="noopener noreferrer" className="ap-btn-ghost">💼 LinkedIn</a>
          </div>
        </div>
        <div className="ap-cards">
          {abroad.cards.map((c) => (
            <div className="ap-card" key={c.text}>
              <div className="ap-card-icon">{c.icon}</div>
              <div>
                <div className="ap-card-text">{c.text}</div>
                <div className="ap-card-sub">{c.sub}</div>
              </div>
            </div>
          ))}
        </div>
      </div>

      <div className="looking-for-title">Roles I&apos;m targeting</div>
      <div className="role-cards">
        {abroad.roles.map((r) => (
          <div className="role-card reveal" key={r.country}>
            <div className="rc-top">
              <div className="rc-flag">{r.flag}</div>
              <div className="rc-open"><span className="rc-open-dot" />Open</div>
            </div>
            <div className="rc-country">{r.country}</div>
            <div className="rc-type">{r.type}</div>
            <div className="rc-roles">
              {r.positions.map((pos) => (
                <div className="rc-role-item" key={pos}>{pos}</div>
              ))}
            </div>
            <div className="rc-tags">
              {r.tags.map((t) => <span className="rc-tag" key={t}>{t}</span>)}
            </div>
          </div>
        ))}
      </div>

      <div className="bring-strip reveal">
        <div className="bring-left">
          <div className="bring-tagline">What I bring<br />to your <em>team.</em></div>
          <div className="bring-sub">Day one ready · No ramp-up</div>
        </div>
        <div className="bring-right">
          <div className="bring-grid">
            {abroad.bring.map((b) => (
              <div className="bring-item" key={b.title}>
                <div className="bi-icon">{b.icon}</div>
                <div className="bi-text">
                  <strong>{b.title}</strong>{b.desc}
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div className="recruiter-cta reveal">
        <div className="rcta-eyebrow">{abroad.recruiterCta.eyebrow}</div>
        <div className="rcta-title">
          {abroad.recruiterCta.title[0]}<br /><em>{abroad.recruiterCta.title[1]}</em>
        </div>
        <p className="rcta-sub">{abroad.recruiterCta.sub}</p>
        <div className="rcta-actions">
          <a href={`mailto:${person.email}`} className="rcta-btn">📩 Send Me a Role</a>
          <a href={person.linkedin} target="_blank" rel="noopener noreferrer" className="rcta-btn-ghost">💼 View LinkedIn</a>
        </div>
        <div className="rcta-note">{abroad.recruiterCta.skills}</div>
      </div>
    </section>
  );
}
