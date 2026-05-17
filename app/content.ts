// ═══════════════════════════════════════════════════════════════
//  PORTFOLIO CONTENT — edit this file to customise everything.
//  All text, links, projects, experience and stack live here.
// ═══════════════════════════════════════════════════════════════

// ─── Site-wide ──────────────────────────────────────────────────
export const SITE = {
  name:          "Mohamed Idris",
  roleTag:       "Senior React Dev",
  email:         "idrishan1996@gmail.com",
  phone:         "+91 70102 21314",
  linkedinUrl:   "https://linkedin.com/in/irmh",
  linkedinLabel: "linkedin.com/in/irmh",
  githubUrl:     "https://github.com/irmhanif",
  githubLabel:   "github.com/irmhanif",
  website:       "idrism.com",
  year:          "2026",
};

// ─── AI widget ──────────────────────────────────────────────────
export const AI_TOKEN_LIMIT = 6000; // tokens per device per 24 h

export const AI_CHIPS = [
  { label: "UAE roles?",    q: "Is he open to UAE roles?" },
  { label: "Playwright",   q: "Tell me about his Playwright testing experience." },
  { label: "Walgreens",    q: "What did he ship at Walgreens?" },
  { label: "Architecture", q: "How does he approach React component architecture?" },
  { label: "Why hire?",    q: "Why hire him for a senior frontend role?" },
];

// ─── Hero ───────────────────────────────────────────────────────
export const HERO = {
  available:         true,
  availableText:     "Available · Full-time / Contract",
  location:          "Chennai, India · open to relocation & remote",
  headline:          "Senior React engineer",
  headlineLine2:     "shipping",
  headlineHighlight: "enterprise software",
  headlineLine3:     "that ships.",
  ledeName:          "Mohamed Idris",
  ledeBody:          "- 7.5 years building high-traffic, well-tested production apps. Currently leading frontend on the FreeWheel ad platform at",
  ledeCompany:       "Comcast.",
  ledeTail:          "Previously Cognizant, Verizon, and the Walgreens vaccine booking app used by millions.",
  specs: [
    { k: "Experience",    value: 7.5, suffix: "yrs" },
    { k: "Test coverage", value: 90,  suffix: "%",  prefix: "~" },
    { k: "Perf uplift",   value: 60,  suffix: "%" },
    { k: "Apps shipped",  value: 15,  suffix: "+" },
  ],
};

// ─── About ──────────────────────────────────────────────────────
// Wrap text in **double asterisks** to make it bold.
export const ABOUT = {
  paragraphs: [
    "I build **scalable, production-grade web applications** that hold up under real enterprise load — architected for performance, tested for confidence, and designed to outlive their authors.",
    "At Comcast I lead React architecture for **FreeWheel MRM**, a mission-critical ad-management platform. Previously at Cognizant I drove a 60% performance uplift for Verizon and led the **Walgreens vaccination booking app** used by millions — with 100% CDC compliance and full WCAG accessibility.",
    "Beyond code, I mentor engineers, run knowledge-transfer sessions, and champion clean, well-tested code as a team culture.",
  ],
  quote:  "Recognised with the Spotlight Award at Comcast for technical excellence and delivery impact — Q2 2025.",
  badges: [
    { text: "Open to relocation",  variant: "ok"   },
    { text: "Spotlight Award 2025", variant: "gold" },
    { text: "~90% test coverage" },
    { text: "B.Sc Computer Science" },
  ],
};

// ─── Stack ──────────────────────────────────────────────────────
// Tokens listed in `highlighted` render with accent colour.
export const STACK_ROWS = [
  {
    category:    "Core",
    tokens:      ["React.js", "TypeScript", "Redux", "GraphQL", "React Hooks", "Context API"],
    highlighted: ["React.js", "TypeScript", "Redux", "GraphQL"],
  },
  {
    category:    "Frontend",
    tokens:      ["JavaScript ES6+", "HTML5 / CSS3", "Bootstrap", "Axios", "Next.js"],
    highlighted: [],
  },
  {
    category:    "Backend / data",
    tokens:      ["Node.js", "Go", "MongoDB", "MySQL", "REST APIs", "PHP"],
    highlighted: [],
  },
  {
    category:    "Testing / DevOps",
    tokens:      ["Playwright", "Jest", "Vitest", "React Testing Library", "CI/CD", "Git"],
    highlighted: ["Playwright"],
  },
];

// ─── Experience ─────────────────────────────────────────────────
// Use **double asterisks** for bold text in bullets.
export const EXPERIENCE = [
  {
    period:  "Sep 2024 — Present",
    current: true,
    role:    "Senior Frontend Developer",
    company: "Comcast",
    city:    "Chennai, India",
    bullets: [
      "Led development of scalable SPAs using **React, Hooks, Redux & TypeScript** for the FreeWheel MRM ad-tech platform.",
      "Mentored engineers on **component architecture and state management.**",
      "Introduced **Playwright-based automation** achieving ~90% test coverage with AI-assisted acceleration.",
    ],
    award: "Spotlight Award · Q2 2025 · Technical Excellence & Delivery Impact",
  },
  {
    period:  "Dec 2021 — Sep 2024",
    current: false,
    role:    "Software Developer",
    company: "Cognizant",
    city:    "Chennai, India",
    bullets: [
      "Built enterprise React SPAs driving a **30% lift in user engagement** through improved UI architecture.",
      "Integrated REST APIs — reduced **data retrieval time by 60%,** PageSpeed above 80.",
      "Led the Walgreens vaccine booking app — **100% CDC compliance, full WCAG accessibility,** +30% appointment bookings.",
    ],
  },
  {
    period:  "Jan 2021 — Dec 2021",
    current: false,
    role:    "Web Development Engineer",
    company: "CodeCraft Technologies",
    city:    "Bangalore, India",
    bullets: [
      "Engineered React + Redux UI components — **25% application speed increase.**",
      "Implemented GraphQL on IGoalZero for a **25% system performance boost.**",
    ],
  },
  {
    period:  "Aug 2018 — Dec 2020",
    current: false,
    role:    "Web Developer",
    company: "Zinavo Technologies",
    city:    "Bangalore, India",
    bullets: [
      "Built **15+ web applications** and 6 e-commerce platforms — 40% growth in online transactions.",
      "Managed projects end-to-end with **95% client approval** and 100% on-time delivery.",
    ],
  },
];

// ─── Projects ───────────────────────────────────────────────────
export const PROJECTS = [
  {
    id:     "fw",
    num:    "P01",
    name:   "FreeWheel MRM",
    client: "Comcast · Ad Tech",
    desc:   "Forecasting and inventory screens for a mission-critical ad-management platform. React + TypeScript + Go.",
    kpi:    "~90% test coverage · Playwright + AI",
    tags:   ["React", "TypeScript", "Go", "Playwright"],
    detail: "I lead frontend on FreeWheel MRM — Comcast's ad inventory & forecasting platform. Architected scalable SPAs with React + Hooks + Redux + TS; drove ~90% Playwright coverage via AI-assisted generation. Spotlight Award Q2 2025.",
  },
  {
    id:     "vz",
    num:    "P02",
    name:   "Verizon Platform",
    client: "Cognizant · Telecom",
    desc:   "Legacy enterprise revamp with React + Redux + Node. 15+ reusable components across the organisation.",
    kpi:    "60% system boost · 40% load-time cut",
    tags:   ["React", "Redux", "Node.js"],
    detail: "Cross-functional rebuild of Verizon's internal platform. 60% data-retrieval improvement through efficient REST endpoints; 40% load-time reduction via code-splitting and memoisation.",
  },
  {
    id:     "wg",
    num:    "P03",
    name:   "Walgreens Vaccine Booking",
    client: "Cognizant · Healthcare",
    desc:   "Vaccine booking app used by millions during COVID. CDC-compliant, WCAG accessible, cross-browser tested.",
    kpi:    "+30% bookings · 100% CDC compliance",
    tags:   ["React", "WCAG", "CDC", "A11y"],
    detail: "Led the React frontend for Walgreens COVID-19 vaccine booking. 100% CDC compliance, WCAG 2.1 AA, rolled out across IE11, Safari, Chrome, Edge, Firefox. Booking volumes lifted 30% post-launch.",
  },
  {
    id:     "ig",
    num:    "P04",
    name:   "IGoalZero",
    client: "CodeCraft Technologies",
    desc:   "GraphQL-driven goal tracker. 30% faster first-load; reusable component library across the dashboard.",
    kpi:    "30% faster loads · 25% perf boost",
    tags:   ["React", "GraphQL", "TypeScript"],
    detail: "Re-architected IGoalZero on GraphQL — 25% system performance gain and 30% faster initial load. Reusable component library still in use across newer CodeCraft products.",
  },
  {
    id:     "fb",
    num:    "P05",
    name:   "Facebook UI Clone",
    client: "Personal · Next.js",
    desc:   "Full-fidelity recreation of Facebook's newsfeed and profile UI in Next.js. Study in scroll perf and composition.",
    kpi:    "Personal · open source",
    tags:   ["React", "Next.js"],
    detail: "Personal exercise in scroll performance, component composition, and edge-case interactions. Open source on GitHub; deployed via Vercel.",
  },
  {
    id:     "fr",
    num:    "P06",
    name:   "France by French",
    client: "Zinavo · Travel",
    desc:   "Tourism platform with trip listings, admin booking panel, and split-payment support.",
    kpi:    "90 PageSpeed · split-pay UX",
    tags:   ["PHP", "MySQL", "Joomla"],
    detail: "Full-stack build for a France-based tour operator. Custom Joomla backend, MySQL inventory, bespoke split-payment flow tuned for international gateways.",
  },
];

// ─── Contact ────────────────────────────────────────────────────
export const CONTACT = {
  headline:     "Let's build something",
  headlineHi:   "good.",
  subtext:      "Senior frontend role, or a chat about React architecture - I respond within 24 hours.",
  availability: "Available · India · UAE · Canada · UK · EU · Remote",
};
