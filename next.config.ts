import type { NextConfig } from "next";

// GitHub Pages build sets STATIC_EXPORT=true to emit a static site into out/.
// Vercel leaves it unset so the server (app/api) runs normally.
const nextConfig: NextConfig = {
  ...(process.env.STATIC_EXPORT === "true" ? { output: "export" as const } : {}),
};

export default nextConfig;
