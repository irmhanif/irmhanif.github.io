/** @type {import('next').NextConfig} */
const nextConfig = {
  output: 'export',       // static HTML export — required for GitHub Pages
  trailingSlash: true,    // /about → /about/index.html — needed for GH Pages routing
  images: {
    unoptimized: true,    // Next Image optimisation needs a server; disable for static
  },
  // basePath / assetPrefix: leave empty when using a custom domain (idrism.com)
  // GitHub Pages serves from root when CNAME is set — no subdirectory needed.
  // If you ever remove the custom domain and serve from irmhanif.github.io ONLY,
  // uncomment the two lines below:
  // basePath: '',
  // assetPrefix: '',
};

module.exports = nextConfig;
