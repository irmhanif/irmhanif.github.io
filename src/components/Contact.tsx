import type { Contact, Person } from "@/types";

export default function Contact({ contact, person }: { contact: Contact; person: Person }) {
  return (
    <section id="contact" className="alt-bg">
      <div className="contact-inner">
        <div className="sec-eyebrow" style={{ justifyContent: "center" }}>Let&apos;s work together</div>
        <div className="contact-big">
          {contact.headline[0]}<br /><em>{contact.headline[1]}</em>
        </div>
        <p className="contact-sub">{contact.sub}</p>
        <div className="contact-links">
          {contact.links.map((link) => (
            <a
              key={link.label}
              href={link.href}
              className="clink"
              {...(link.external ? { target: "_blank", rel: "noopener noreferrer" } : {})}
            >
              <span className="clink-icon">{link.icon}</span>
              {link.label}
            </a>
          ))}
        </div>
        <div className="open-tag">
          <span className="open-dot" />{person.availabilityTag}
        </div>
      </div>
    </section>
  );
}
