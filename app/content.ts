// ═══════════════════════════════════════════════════════════════
//  PORTFOLIO CONTENT - edit this file to customise everything.
//  All text, links, projects, experience and stack live here.
// ═══════════════════════════════════════════════════════════════

// ─── Site-wide ──────────────────────────────────────────────────
export const SITE = {
  name: "Mohamed Idris",
  roleTag: "Senior React Dev",
  email: "idrishan1996@gmail.com",
  phone: "+91 70102 21314",
  linkedinUrl: "https://linkedin.com/in/irmh",
  linkedinLabel: "linkedin.com/in/irmh",
  githubUrl: "https://github.com/irmhanif",
  githubLabel: "github.com/irmhanif",
  website: "idrism.com",
  year: "2026",
};

// ─── AI widget ──────────────────────────────────────────────────
export const AI_TOKEN_LIMIT = 6000; // tokens per device per 24 h

export const AI_CHIPS = [
  { label: "UAE roles?", q: "Is he open to UAE roles?" },
  { label: "Playwright", q: "Tell me about his Playwright testing experience." },
  { label: "Walgreens", q: "What did he ship at Walgreens?" },
  { label: "Architecture", q: "How does he approach React component architecture?" },
  { label: "Why hire?", q: "Why hire him for a senior frontend role?" },
];

// ─── Hero ───────────────────────────────────────────────────────
export const HERO = {
  available: true,
  availableText: "Available · Full-time / Contract",
  location: "Chennai, India · open to relocation & remote",
  headline: "Senior React engineer",
  headlineLine2: "shipping",
  headlineHighlight: "enterprise software",
  headlineLine3: "that ships.",
  ledeName: "Mohamed Idris",
  ledeBody: "- 8+ years building high-traffic, well-tested production apps. Currently leading frontend on the FreeWheel ad platform at",
  ledeCompany: "Comcast.",
  ledeTail: "Previously Cognizant, Verizon, and the Walgreens vaccine booking app used by millions.",
  specs: [
    { k: "Experience", value: 8, suffix: "yrs" },
    { k: "Test coverage", value: 90, suffix: "%", prefix: "~" },
    { k: "Perf uplift", value: 60, suffix: "%" },
    { k: "Apps shipped", value: 15, suffix: "+" },
  ],
};

// ─── About ──────────────────────────────────────────────────────
// Wrap text in **double asterisks** to make it bold.
export const ABOUT = {
  paragraphs: [
    "I build **scalable, production-grade web applications** that hold up under real enterprise load - architected for performance, tested for confidence, and designed to outlive their authors.",
    "At Comcast I lead React architecture for **FreeWheel MRM**, a mission-critical ad-management platform. Previously at Cognizant I drove a 60% performance uplift for Verizon and led the **Walgreens vaccination booking app** used by millions - with 100% CDC compliance and full WCAG accessibility.",
    "Beyond code, I mentor engineers, run knowledge-transfer sessions, and champion clean, well-tested code as a team culture.",
  ],
  quote: "Recognised with the Spotlight Award at Comcast for technical excellence and delivery impact - Q2 2025.",
  badges: [
    { text: "Open to relocation", variant: "ok" },
    { text: "Spotlight Award 2025", variant: "gold" },
    { text: "~90% test coverage" },
    { text: "B.Sc Computer Science" },
  ],
};

// ─── Stack ──────────────────────────────────────────────────────
// Tokens listed in `highlighted` render with accent colour.
export const STACK_ROWS = [
  {
    category: "Core",
    tokens: ["React.js", "TypeScript", "Redux", "GraphQL", "React Hooks", "Context API"],
    highlighted: ["React.js", "TypeScript", "Redux", "GraphQL"],
  },
  {
    category: "Frontend",
    tokens: ["JavaScript ES6+", "HTML5 / CSS3", "Bootstrap", "Axios", "Next.js"],
    highlighted: [],
  },
  {
    category: "Backend / data",
    tokens: ["Node.js", "Go", "MongoDB", "MySQL", "REST APIs", "PHP"],
    highlighted: [],
  },
  {
    category: "Testing / DevOps",
    tokens: ["Playwright", "Jest", "Vitest", "React Testing Library", "CI/CD", "Git"],
    highlighted: ["Playwright"],
  },
];

// ─── Experience ─────────────────────────────────────────────────
// Use **double asterisks** for bold text in bullets.
export const EXPERIENCE = [
  {
    period: "Sep 2024 - Present",
    current: true,
    role: "Senior Frontend Developer",
    company: "Comcast",
    city: "Chennai, India",
    bullets: [
      "Architected 3 ad-forecasting & inventory modules using **React, TypeScript, Redux & Go microservices**.",
      "Led a **7-person frontend pod** end-to-end - sprint planning, backlog grooming, and Copilot-augmented PR review workflows.",
      "Drove unit, component, and E2E test coverage (**Jest, Vitest, Playwright**) from **0% to ~90%** across 40+ components.",
    ],
    award: "Spotlight Award (Q2 2025) & High Five Award (Q4 2025)",
  },
  {
    period: "Dec 2021 - Sep 2024",
    current: false,
    role: "Software Developer",
    company: "Cognizant",
    city: "Chennai, India",
    bullets: [
      "Built enterprise React SPAs driving a **30% lift in user engagement** through improved UI architecture.",
      "Integrated REST APIs - reduced **data retrieval time by 60%,** PageSpeed above 80.",
      "Led the Walgreens vaccine booking app - **100% CDC compliance, full WCAG accessibility,** +30% appointment bookings.",
    ],
  },
  {
    period: "Jan 2021 - Dec 2021",
    current: false,
    role: "Web Development Engineer",
    company: "CodeCraft Technologies",
    city: "Bangalore, India",
    bullets: [
      "Engineered React + Redux UI components - **25% application speed increase.**",
      "Implemented GraphQL on IGoalZero for a **25% system performance boost.**",
    ],
  },
  {
    period: "Aug 2018 - Dec 2020",
    current: false,
    role: "Web Developer",
    company: "Zinavo Technologies",
    city: "Bangalore, India",
    bullets: [
      "Built **15+ web applications** and 6 e-commerce platforms - 40% growth in online transactions.",
      "Managed projects end-to-end with **95% client approval** and 100% on-time delivery.",
    ],
  },
];

// ─── Projects ───────────────────────────────────────────────────
export const PROJECTS = [
  {
    id: "fw",
    num: "P01",
    name: "FreeWheel MRM",
    client: "Comcast · Ad Tech",
    desc: "Forecasting and inventory screens for a mission-critical ad-management platform. React + TypeScript + Go.",
    kpi: "~90% test coverage · Playwright + AI",
    tags: ["React", "TypeScript", "Go", "Playwright"],
    detail: `Team Leadership & Engineering Culture
Led a 7-person frontend pod end-to-end - sprint planning, backlog grooming, and 4–7 PR reviews per week. Introduced PR checklists and ESLint/pre-commit hooks that cut rework cycles by ~40%. Established a PR governance model where no code merged without passing automated lint, test coverage threshold (>85%), and a structured human review gate.

Forecasting & Ad Inventory Platform
Architected 3 enterprise ad-forecasting and inventory management modules in React, TypeScript, and Redux - shipped across 2 consecutive quarters on schedule for 200+ global stakeholders across sales, planning, and operations teams. The platform enables media planners to forecast ad inventory availability across broadcast and digital channels before committing to a deal. Core screens include demand forecasting, capacity visualisation, and availability breakdown by targeting dimensions.

Instant RFP - Real-Time Availability Preview
RFP (Request for Proposal) is the process where advertisers request ad inventory availability from a broadcaster before a deal is confirmed.
Built a new Instant RFP screen that surfaces real-time ad capacity and availability directly from the AF (Availability & Forecasting) server via a server-side caching strategy - delivering results in milliseconds, compared to the standard RFP flow which involves asynchronous processing.
Key engineering challenges:
• Seamless dual-mode UX: Designed a toggle within the existing RFP workflow so planners can switch between standard RFP results and instant results without losing context or re-entering data.
• Config-driven field resolution: The AF server only supports a subset of the full RFP payload. Built a configuration-based approach to dynamically determine which fields are compatible, forwarding only supported fields to the AF server and gracefully handling unsupported ones client-side.
• Complex nested payload handling: The RFP payload is deeply hierarchical - covering dates, CPM, budget model, advertiser details, display units, frequency caps, and multi-dimensional targeting (content type: video/series/channel/airing, standard targeting, custom targeting, geographic, audience segments, platform/device/OS, marketplace supply source, daypart, SSP equivalents). Critically, the data structure is inconsistent - some nodes are plain objects, others are arrays of objects at the same level of nesting. Wrote recursive resolution logic to correctly traverse and transform this mixed structure without data loss.

AI-Augmented PR Review Workflow
Integrated GitHub Copilot into the team's PR review process to handle scale - large PRs (500–1000+ line diffs) were bottlenecking review cycles. Structured the workflow in two stages:
• AI first pass: Copilot performs a full review of the diff, flagging issues with severity labels (critical / warning / suggestion) covering logic errors, naming consistency, and pattern violations.
• Human gate: Engineer reviews AI output, then validates code quality, business logic correctness, and enforces >85% test coverage before approving merge.
Result: Reduced review turnaround time on large PRs, freed senior engineer bandwidth from low-severity noise, and maintained consistent review quality across the pod.

Testing Culture - 0 → 90% Coverage
Inherited a codebase with near-zero test coverage. Introduced Jest (unit), Vitest (component), and Playwright (E2E) across 40+ components. Used AI-assisted test generation to reduce test authoring time by ~3x. Established coverage thresholds as a merge gate, making test coverage a team norm rather than an afterthought.

Design System - Spark UI
Owned the integration of Spark UI (Comcast's internal design system) across the pod. Defined adoption standards, enforced Figma-to-code token conventions across 40+ components, and eliminated visual drift across all FreeWheel MRM screens. Served as the pod's point of contact for DS-related decisions and component governance.

Performance Engineering
Applied React.memo, route-level code splitting, lazy loading, and virtualised data grids to the forecasting screens - reducing load times by ~35% for 200+ daily users and improving Core Web Vitals scores across the board.

Recognition
• Spotlight Award - Q2 2025: On-schedule delivery of forecasting modules under deadline pressure
• High Five Award - Q4 2025: Manager recognition for cross-team collaboration and sustaining BAU operations during high-load quarters`,
  },
  {
    id: "vz",
    num: "P02",
    name: "Verizon Platform",
    client: "Cognizant · Telecom",
    desc: "Legacy enterprise revamp with React + Redux + Node. 15+ reusable components across the organisation.",
    kpi: "60% system boost · 40% load-time cut",
    tags: ["React", "Redux", "Node.js"],
    detail: "Cross-functional rebuild of Verizon's internal platform. 60% data-retrieval improvement through efficient REST endpoints; 40% load-time reduction via code-splitting and memoisation.",
  },
  {
    id: "wg",
    num: "P03",
    name: "Walgreens Vaccine Booking",
    client: "Cognizant · Healthcare",
    desc: "Vaccine booking app used by millions during COVID. CDC-compliant, WCAG accessible, cross-browser tested.",
    kpi: "+30% bookings · 100% CDC compliance",
    tags: ["React", "WCAG", "CDC", "A11y"],
    detail: "Led the React frontend for Walgreens COVID-19 vaccine booking. 100% CDC compliance, WCAG 2.1 AA, rolled out across IE11, Safari, Chrome, Edge, Firefox. Booking volumes lifted 30% post-launch.",
  },
  {
    id: "ig",
    num: "P04",
    name: "IGoalZero",
    client: "CodeCraft Technologies",
    desc: "GraphQL-driven goal tracker. 30% faster first-load; reusable component library across the dashboard.",
    kpi: "30% faster loads · 25% perf boost",
    tags: ["React", "GraphQL", "TypeScript"],
    detail: "Re-architected IGoalZero on GraphQL - 25% system performance gain and 30% faster initial load. Reusable component library still in use across newer CodeCraft products.",
  },
  {
    id: "vh",
    num: "P05",
    name: "Production Web Applications",
    client: "Production · Integrations",
    desc: "Suite of custom-built web applications featuring advanced payment gateways, scheduling systems, and background check APIs.",
    kpi: "CCAvenue & Razorpay · Authbridge",
    tags: ["JavaScript", "CCAvenue", "Razorpay", "APIs"],
    detail: "Developed a variety of custom web applications for production, including VHomeShare (home-sharing portal), WedOnSet (events platform with CCAvenue payment gateway), VenuePlus (booking app with custom calendar scheduling and Razorpay), TravoTales (travel portal), and Bioresilience (course-selling platform). For VHomeShare, integrated the CC Avenue payment gateway and Authbridge third-party API for profile background verification using JS.",
    link: "https://www.vhomeshare.com/",
  },
  {
    id: "fr",
    num: "P06",
    name: "France by French",
    client: "Zinavo · Travel",
    desc: "Comprehensive tourism platform featuring custom group booking, PayuMoney split-payments, and document collection workflows.",
    kpi: "Joomla PHP Backend · Custom Booking Flow",
    tags: ["PHP", "MySQL", "Joomla", "PayuMoney"],
    detail: "Architected a massive tourism platform (FBF) using the Joomla PHP framework. Engineered trip creation, multi-package handling, group booking, blog systems, and PayuMoney integration supporting split-payments and link sharing. Developed a multi-step user dashboard covering booking, payment, offline logging, document organization, visa gift delivery, and feedback collection.",
  },
];

// ─── Contact ────────────────────────────────────────────────────
export const CONTACT = {
  headline: "Let's build something",
  headlineHi: "good.",
  subtext: "Senior frontend role, or a chat about React architecture - I respond within 24 hours.",
  availability: "Available · India · UAE · Canada · UK · EU · Remote",
};
