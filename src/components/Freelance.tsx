import type { Freelance, Person } from "@/types";

export default function Freelance({ freelance, person }: { freelance: Freelance; person: Person }) {
  return (
    <section id="freelance" className="alt-bg">
      <div className="sec-eyebrow">Available for Hire</div>
      <h2 className="sec-h2">Freelance<br /><em>services.</em></h2>

      <div className="freelance-layout">
        <div>
          <p className="fl-intro" dangerouslySetInnerHTML={{ __html: freelance.intro }} />
          <div className="services-list">
            {freelance.services.map((s) => (
              <div className="service-row reveal" key={s.name}>
                <div className="sr-icon">{s.icon}</div>
                <div>
                  <div className="sr-name">{s.name}</div>
                  <div className="sr-desc">{s.desc}</div>
                </div>
                <div className="sr-rate">
                  {s.rate}<br />
                  <span style={{ fontSize: 9, color: "var(--dim)" }}>{s.unit}</span>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div>
          <div className="fl-why-title">Why hire me</div>
          <div className="fl-proof">
            {freelance.proof.map((p) => (
              <div className="proof-card" key={p.label}>
                <div className="proof-num">{p.num}</div>
                <div className="proof-label">
                  <strong>{p.label}</strong>{p.sub}
                </div>
              </div>
            ))}
          </div>
          <div className="fl-platforms">
            <div className="fl-plat-title">Platforms I&apos;m active on</div>
            <div className="platform-pills">
              {freelance.platforms.map((pl) => (
                <span className="plat-pill" key={pl}>{pl}</span>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
