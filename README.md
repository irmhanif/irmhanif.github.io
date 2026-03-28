# Mohamed Idris — Portfolio (Next.js)

Static Next.js portfolio deployed to **GitHub Pages** at **idrism.com**.

## ✏️ Updating Content — No Build or Deploy Needed

> **Edit `public/data/portfolio.json` directly on GitHub.**
> Commit → GitHub Actions auto-rebuilds → live in ~2 mins. No `npm install` or local build required.

### File locations you'll actually touch:

```
public/
├── data/
│   └── portfolio.json    ← ✏️  ALL site content lives here
├── resume/
│   └── Mohamed-Idris-Resume.pdf    ← 📄 Drop/replace your resume here
└── videos/
    ├── fbf.mp4           ← 🎬 France by French demo
    └── wos.mp4           ← 🎬 Wed on Set demo
```

Everything in `public/` is served as-is at the root URL:
- `portfolio.json` → read by Next.js at build time
- `resume/Mohamed-Idris-Resume.pdf` → accessible at `https://idrism.com/resume/Mohamed-Idris-Resume.pdf`
- `videos/fbf.mp4` → accessible at `https://idrism.com/videos/fbf.mp4`

---

## 🗂 Project Structure

```
portfolio/
├── public/                         ← Static files — edit freely, no rebuild needed
│   ├── CNAME                       ← Custom domain (idrism.com) — DO NOT DELETE
│   ├── data/portfolio.json         ← ✏️  ALL content here
│   ├── resume/                     ← Drop PDF here
│   └── videos/                     ← Drop mp4 files here
├── src/
│   ├── app/
│   │   ├── layout.tsx              ← Root layout + Google Fonts
│   │   ├── page.tsx                ← Reads portfolio.json, passes props to sections
│   │   └── globals.css             ← All CSS / design tokens
│   ├── components/
│   │   ├── ClientScripts.tsx       ← "use client" — cursor, scroll, reveal, counters
│   │   ├── MobileNav.tsx           ← "use client" — hamburger menu state
│   │   ├── ShowcaseClient.tsx      ← "use client" — project filter + video modal
│   │   ├── Nav.tsx / Hero.tsx / About.tsx / Experience.tsx
│   │   ├── Showcase.tsx / Freelance.tsx / Abroad.tsx
│   │   ├── Contact.tsx / Footer.tsx
│   └── types/
│       └── index.ts                ← TypeScript types for portfolio.json
├── .github/workflows/deploy.yml   ← CI/CD — auto-deploys on push to main
└── next.config.js                 ← Static export config
```

---

## 🚀 Local Development

```bash
npm install
npm run dev
# → http://localhost:3000
```

---

## 🌐 Deployment (One-time GitHub Setup)

**1. Create repo & push**
```bash
git init
git remote add origin https://github.com/irmhanif/irmhanif.github.io.git
git add . && git commit -m "launch" && git push origin main
```

**2. Enable GitHub Pages**
- Settings → Pages → Source: **GitHub Actions**
- Custom domain: `idrism.com` → Enforce HTTPS ✓

**3. DNS at your registrar**

| Type | Name | Value |
|---|---|---|
| A | @ | 185.199.108.153 |
| A | @ | 185.199.109.153 |
| A | @ | 185.199.110.153 |
| A | @ | 185.199.111.153 |
| CNAME | www | irmhanif.github.io |

After DNS propagates → live at `https://idrism.com`

---

## 📝 Adding a New Project

In `public/data/portfolio.json`, add to `projects.items[]`:

```json
{
  "id": "my-project",
  "name": "Project Name",
  "client": "Client · Category",
  "desc": "Short description.",
  "kpi": "Key metric",
  "tags": ["React", "TypeScript"],
  "cats": ["react", "own"],
  "size": "sm",
  "emoji": "🚀",
  "coverGradient": "linear-gradient(135deg,#0d1220 0%,#131a30 100%)",
  "coverPattern": null,
  "category": "React",
  "categoryType": "react",
  "link": "https://your-project.com",
  "isNDA": false,
  "videoSrc": null
}
```

`size`: `"sm"` | `"md"` | `"lg"` | `"wide"` | `"full"`  
`cats`: `"react"` | `"enterprise"` | `"php"` | `"own"`
