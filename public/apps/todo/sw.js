/* iTodoist service worker — offline app shell.
 * Navigations: network first, cached shell when offline.
 * Same-origin assets: stale-while-revalidate (Vite assets are content-hashed).
 * Google Fonts: cache first.
 * Task data never passes through here — it lives encrypted in IndexedDB. */
const VERSION = "itodoist-v2";
// The app can live under a sub-path (for example /apps/todo/), so derive paths from this file's location.
const BASE = new URL("./", self.location).pathname;
const SHELL = [BASE, BASE + "index.html", BASE + "manifest.webmanifest", BASE + "favicon.svg", BASE + "icons/icon-192.png", BASE + "icons/icon-512.png"];

self.addEventListener("install", (event) => {
  event.waitUntil(caches.open(VERSION).then((c) => c.addAll(SHELL)).then(() => self.skipWaiting()));
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(keys.filter((k) => k !== VERSION).map((k) => caches.delete(k))))
      .then(() => self.clients.claim()),
  );
});

self.addEventListener("fetch", (event) => {
  const req = event.request;
  if (req.method !== "GET") return;
  const url = new URL(req.url);

  if (req.mode === "navigate") {
    event.respondWith(
      fetch(req)
        .then((res) => {
          const copy = res.clone();
          caches.open(VERSION).then((c) => c.put(BASE + "index.html", copy));
          return res;
        })
        .catch(() => caches.match(BASE + "index.html")),
    );
    return;
  }

  if (url.origin === self.location.origin) {
    event.respondWith(
      caches.open(VERSION).then(async (cache) => {
        const cached = await cache.match(req);
        const network = fetch(req)
          .then((res) => { if (res.ok) cache.put(req, res.clone()); return res; })
          .catch(() => cached);
        return cached || network;
      }),
    );
    return;
  }

  if (url.hostname === "fonts.googleapis.com" || url.hostname === "fonts.gstatic.com") {
    event.respondWith(
      caches.open(VERSION).then(async (cache) => {
        const cached = await cache.match(req);
        if (cached) return cached;
        const res = await fetch(req);
        if (res.ok || res.type === "opaque") cache.put(req, res.clone());
        return res;
      }),
    );
  }
});
