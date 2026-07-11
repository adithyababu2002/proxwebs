function loadOneScript(src) {
    return new Promise((resolve, reject) => {
        const markReady = (el) => {
            el.dataset.ready = '1';
            resolve();
        };

        const existing = document.querySelector(`script[src="${src}"]`);
        if (existing) {
            if (existing.dataset.ready === '1') {
                resolve();
                return;
            }

            // Script tag exists and may already be fully loaded (no future load event).
            if (existing.complete || existing.readyState === 'complete' || existing.readyState === 'loaded') {
                markReady(existing);
                return;
            }

            existing.addEventListener('load', () => markReady(existing), { once: true });
            existing.addEventListener('error', () => reject(new Error(`Failed to load script: ${src}`)), {
                once: true,
            });

            // Fallback if the browser already finished loading before listeners attached.
            setTimeout(() => {
                if (existing.dataset.ready !== '1') {
                    markReady(existing);
                }
            }, 50);
            return;
        }

        const s = document.createElement('script');
        s.src = src;
        s.async = false;
        s.onload = () => markReady(s);
        s.onerror = () => reject(new Error(`Failed to load script: ${src}`));
        document.body.appendChild(s);
    });
}

export async function loadScriptsInOrder(srcs) {
    for (const src of srcs) {
        await loadOneScript(src);
    }
}

export const onixLegacyScripts = [
    '/vendor/jquery/jquery.min.js',
    '/vendor/bootstrap/js/bootstrap.bundle.min.js',
    '/onix/assets/js/owl-carousel.js',
    '/onix/assets/js/animation.js',
    '/onix/assets/js/imagesloaded.js',
    '/onix/assets/js/custom.js',
];
