const CACHE_NAME = 'alif-pharma-v4';
const OFFLINE_URL = './offline.html';

self.addEventListener('install', (event) => {
    // Force the waiting service worker to become the active service worker
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll([
                './',
                './alif-logo.png',
                './alif-logo-192.png',
                './alif-logo-512.png',
                OFFLINE_URL
            ]);
        })
    );
});

self.addEventListener('activate', (event) => {
    // Delete older offline caches
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    // If it's a request to a webpage (navigation), try the network
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                // Network failed, user is offline. Return the offline fallback page
                return caches.match(OFFLINE_URL);
            })
        );
    } else {
        // For other requests (assets), try cache first, then network
        event.respondWith(
            caches.match(event.request).then((response) => {
                return response || fetch(event.request);
            })
        );
    }
});
