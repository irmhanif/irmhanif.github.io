import type { Footer } from "@/types";

export default function Footer({ footer }: { footer: Footer }) {
  return (
    <footer>
      <div className="footer-logo">Mohamed <em>Idris</em></div>
      <div className="footer-copy">{footer.copy}</div>
      <div className="footer-tech">{footer.tech}</div>
    </footer>
  );
}
