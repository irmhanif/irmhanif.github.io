/* iTodoist service worker — offline app shell.
 * Navigations: network first, cached shell when offline.
 * Same-origin assets: stale-while-revalidate (Vite assets are content-hashed).
 * Google Fonts: cache first.
 * Task data never passes through here — it lives encrypted in IndexedDB. */
const VERSION = "itodoist-v5";
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

// ── Web Push ────────────────────────────────────────────────────────────────
// The server sends { c, id }: c is the alert text, encrypted on the device with a key derived from
// the vault key. That key lives in IndexedDB ("itodoist-push"), written by the app when push is
// turned on. Safari requires every push to show a notification, so there is always a fallback text.
function readSubKey() {
  return new Promise((resolve) => {
    try {
      const open = indexedDB.open("itodoist-push", 1);
      open.onupgradeneeded = () => open.result.createObjectStore("kv");
      open.onerror = () => resolve(null);
      open.onsuccess = () => {
        const db = open.result;
        try {
          const r = db.transaction("kv", "readonly").objectStore("kv").get("subkey");
          r.onsuccess = () => { db.close(); resolve(r.result || null); };
          r.onerror = () => { db.close(); resolve(null); };
        } catch { db.close(); resolve(null); }
      };
    } catch { resolve(null); }
  });
}

async function openAlert(c) {
  const key = await readSubKey();
  if (!key || !c) return null;
  const raw = Uint8Array.from(atob(c.replace(/-/g, "+").replace(/_/g, "/")), (ch) => ch.charCodeAt(0));
  const k = await crypto.subtle.importKey("raw", key, "AES-GCM", false, ["decrypt"]);
  const pt = await crypto.subtle.decrypt({ name: "AES-GCM", iv: raw.slice(0, 12) }, k, raw.slice(12));
  return JSON.parse(new TextDecoder().decode(pt));
}

self.addEventListener("push", (event) => {
  event.waitUntil((async () => {
    let title = "iTodoist";
    let body = "You have a task alert.";
    let tag;
    let taskId;
    try {
      const data = event.data ? event.data.json() : {};
      tag = data.id;
      const m = await openAlert(data.c);
      if (m) { title = m.t || title; body = m.b || body; taskId = m.i; }
    } catch { /* keep the generic text */ }
    await self.registration.showNotification(title, {
      body, tag,
      icon: BASE + "icons/icon-192.png",
      badge: BASE + "icons/icon-192.png",
      data: { taskId },
      // Shown on Android and desktop; iOS ignores action buttons and shows the sheet on tap instead
      actions: taskId ? [{ action: "1h", title: "In 1 hour" }, { action: "tomorrow", title: "Tomorrow" }] : [],
    });
  })());
});

// Tapping a notification brings the app forward (or opens it).
self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  const taskId = event.notification.data && event.notification.data.taskId;
  const act = event.action || "";
  event.waitUntil(
    self.clients.matchAll({ type: "window", includeUncontrolled: true }).then((list) => {
      for (const c of list) {
        if ("focus" in c) {
          if (taskId) c.postMessage({ type: "itodoist:notif", taskId, act });
          // A snooze button needs no screen; only bring the app forward for a plain tap
          return act ? undefined : c.focus();
        }
      }
      const q = taskId ? "?task=" + encodeURIComponent(taskId) + (act ? "&act=" + encodeURIComponent(act) : "") : "";
      return self.clients.openWindow(BASE + q);
    }),
  );
});
