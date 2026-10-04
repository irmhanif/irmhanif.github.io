import type { NextConfig } from "next";

// GitHub Pages build sets STATIC_EXPORT=true to emit a static site into out/.
// Vercel leaves it unset so the server (app/api) runs normally.
const nextConfig: NextConfig = {
  ...(process.env.STATIC_EXPORT === "true" ? { output: "export" as const } : {}),
};

// next.config.js
module.exports = {
  async rewrites() {
    return [
      { source: "/apps/todo", destination: "https://dyi0pkeohsgur.cloudfront.net/" },
      { source: "/apps/todo/", destination: "https://dyi0pkeohsgur.cloudfront.net/" },
      { source: "/apps/todo/:path*", destination: "https://dyi0pkeohsgur.cloudfront.net/:path*" },
    ];
  },
};

export default nextConfig;

