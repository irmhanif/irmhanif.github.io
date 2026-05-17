import { SITE } from "../content";

export default function Footer() {
  return (
    <footer>
      <div className="foot-inner">
        <div>
          <b>{SITE.name}</b> · Senior React Developer · India · {SITE.year}
        </div>
        <div className="foot-right">
          <a href={`https://${SITE.website}`}>{SITE.website}</a>
          <a href="#main">Top ↑</a>
        </div>
      </div>
    </footer>
  );
}
