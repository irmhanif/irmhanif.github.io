import Nav from "@/components/Nav";
import Hero from "@/components/Hero";
import About from "@/components/About";
import Experience from "@/components/Experience";
import Showcase from "@/components/Showcase";
import Freelance from "@/components/Freelance";
import Abroad from "@/components/Abroad";
import Contact from "@/components/Contact";
import Footer from "@/components/Footer";
import ClientScripts from "@/components/ClientScripts";
import type { PortfolioData } from "@/types";

// Reads public/data/portfolio.json at BUILD time (static generation).
// For content-only updates: edit public/data/portfolio.json, commit & push.
// GitHub Actions rebuilds automatically — no local `npm run build` needed.
async function getData(): Promise<PortfolioData> {
  const fs = await import("fs/promises");
  const path = await import("path");
  const file = path.join(process.cwd(), "public", "data", "portfolio.json");
  const raw = await fs.readFile(file, "utf-8");
  return JSON.parse(raw);
}

export default async function Home() {
  const data = await getData();

  return (
    <>
      <ClientScripts />
      <div id="cur" />
      <div id="cur-ring" />
      <div id="prog" />

      <Nav person={data.person} />

      <main>
        <Hero hero={data.hero} person={data.person} />
        <About about={data.about} />
        <Experience experience={data.experience} />
        <Showcase projects={data.projects} person={data.person} />
        {/* <Freelance freelance={data.freelance} person={data.person} /> */}
        {/* <Abroad abroad={data.abroad} person={data.person} /> */}
        <Contact contact={data.contact} person={data.person} />
      </main>

      <Footer footer={data.footer} />
    </>
  );
}
