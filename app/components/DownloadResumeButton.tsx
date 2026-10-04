"use client";

import { track } from "@vercel/analytics";

export default function DownloadResumeButton() {
  const handleDownload = () => {
    // Track with Vercel Analytics
    try {
      track("Resume Downloaded");
    } catch (error) {
      console.error("Vercel analytics tracking failed", error);
    }

    // Track with Google Analytics if available
    if (typeof window !== "undefined" && (window as any).gtag) {
      (window as any).gtag("event", "resume_download", {
        event_category: "engagement",
        event_label: "Resume Download Button",
      });
    }
  };

  return (
    <a
      href="/Mohamed_Idris_M.pdf"
      download="Mohamed_Idris_Resume.pdf"
      className="btn btn-ghost"
      onClick={handleDownload}
    >
      Download Resume <span className="arr">↓</span>
    </a>
  );
}
