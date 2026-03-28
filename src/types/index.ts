export interface Meta {
  title: string;
  description: string;
  siteUrl: string;
  githubPagesUrl: string;
}

export interface Person {
  name: string;
  nameFirst: string;
  nameLast: string;
  role: string;
  yearsExperience: string;
  location: string;
  email: string;
  phone: string;
  linkedin: string;
  github: string;
  website: string;
  resumePath: string;
  availabilityTag: string;
  award: string;
}

export interface HeroStat {
  value: number;
  suffix: string;
  isFloat: boolean;
  label: string;
}

export interface Hero {
  statusLabel: string;
  headline: string[];
  subHeadline: string;
  clients: string;
  subText: string;
  ctaPrimary: { label: string; href: string };
  ctaSecondary: { label: string; href: string };
  stats: HeroStat[];
}

export interface SkillGroup {
  group: string;
  star: boolean;
  items: string[];
}

export interface About {
  paragraphs: string[];
  pullQuote: string;
  chips: string[];
  skills: SkillGroup[];
}

export interface Job {
  period: string;
  company: string;
  city: string;
  isCurrent: boolean;
  title: string;
  bullets: string[];
  award: string | null;
}

export interface ProjectItem {
  id: string;
  name: string;
  client: string;
  desc: string | null;
  kpi: string | null;
  tags: string[];
  cats: string[];
  size: "sm" | "md" | "lg" | "wide" | "full";
  emoji: string;
  coverGradient: string;
  coverPattern: string | null;
  category: string;
  categoryType: string;
  link: string | null;
  isNDA: boolean;
  videoSrc: string | null;
  videoTitle?: string;
  videoDesc?: string;
}

export interface Projects {
  filters: string[];
  filterKeys: string[];
  items: ProjectItem[];
}

export interface FreelanceService {
  icon: string;
  name: string;
  desc: string;
  rate: string;
  unit: string;
}

export interface FreelanceProof {
  num: string;
  label: string;
  sub: string;
}

export interface Freelance {
  intro: string;
  services: FreelanceService[];
  proof: FreelanceProof[];
  platforms: string[];
}

export interface AbroadCard {
  icon: string;
  text: string;
  sub: string;
}

export interface AbroadRole {
  flag: string;
  country: string;
  type: string;
  positions: string[];
  tags: string[];
}

export interface BringItem {
  icon: string;
  title: string;
  desc: string;
}

export interface Abroad {
  statement: string;
  body: string;
  cards: AbroadCard[];
  roles: AbroadRole[];
  bring: BringItem[];
  recruiterCta: {
    eyebrow: string;
    title: string[];
    sub: string;
    skills: string;
  };
}

export interface ContactLink {
  icon: string;
  label: string;
  href: string;
  external?: boolean;
}

export interface Contact {
  headline: string[];
  sub: string;
  links: ContactLink[];
}

export interface Footer {
  copy: string;
  tech: string;
}

export interface PortfolioData {
  meta: Meta;
  person: Person;
  hero: Hero;
  about: About;
  experience: Job[];
  projects: Projects;
  freelance: Freelance;
  abroad: Abroad;
  contact: Contact;
  footer: Footer;
}
