const STORAGE_KEY = 'proxwebs_visitor_uuid';
const HEARTBEAT_MS = 15000;

let visitorUuid = localStorage.getItem(STORAGE_KEY) || null;
let pageViewId = null;
let pageStartedAt = Date.now();
let currentPath = '';
let heartbeatTimer = null;
let routerInstalled = false;

function getAxios() {
    return window.axios;
}

function readableTitle(path) {
    if (document.title) return document.title;
    return path || '/';
}

async function post(url, payload, useBeacon = false) {
    const axios = getAxios();
    if (!axios) return null;

    try {
        if (useBeacon && navigator.sendBeacon) {
            const body = JSON.stringify({ ...payload, visitor_uuid: visitorUuid });
            const blob = new Blob([body], { type: 'application/json' });
            navigator.sendBeacon(url, blob);
            return null;
        }

        const { data } = await axios.post(url, {
            ...payload,
            visitor_uuid: visitorUuid,
        });

        if (data?.visitor_uuid && data.visitor_uuid !== visitorUuid) {
            visitorUuid = data.visitor_uuid;
            localStorage.setItem(STORAGE_KEY, visitorUuid);
        }

        return data;
    } catch {
        return null;
    }
}

function elapsedSeconds() {
    return Math.max(0, Math.round((Date.now() - pageStartedAt) / 1000));
}

async function sendHeartbeat({ isNewPage = false, useBeacon = false } = {}) {
    if (!currentPath || currentPath.startsWith('/webuser')) return;

    const data = await post(
        '/api/analytics/heartbeat',
        {
            path: currentPath,
            title: readableTitle(currentPath),
            referrer: document.referrer || null,
            duration_seconds: elapsedSeconds(),
            page_view_id: pageViewId,
            is_new_page: isNewPage,
        },
        useBeacon
    );

    if (data?.page_view_id) {
        pageViewId = data.page_view_id;
    }
}

export async function trackEvent(type, { path = currentPath, label = null, meta = null } = {}) {
    return post('/api/analytics/event', { type, path, label, meta });
}

export async function identifyVisitor({ email, name = null, source = 'form', path = currentPath } = {}) {
    if (!email) return null;
    return post('/api/analytics/identify', { email, name, source, path });
}

export function getVisitorUuid() {
    return visitorUuid;
}

async function openPage(path) {
    if (path.startsWith('/webuser')) return;

    if (currentPath && currentPath !== path) {
        await sendHeartbeat({ isNewPage: false });
    }

    currentPath = path || '/';
    pageStartedAt = Date.now();
    pageViewId = null;
    await sendHeartbeat({ isNewPage: true });
}

function startHeartbeat() {
    stopHeartbeat();
    heartbeatTimer = window.setInterval(() => {
        if (document.visibilityState === 'visible') {
            sendHeartbeat({ isNewPage: false });
        }
    }, HEARTBEAT_MS);
}

function stopHeartbeat() {
    if (heartbeatTimer) {
        clearInterval(heartbeatTimer);
        heartbeatTimer = null;
    }
}

export function installVisitorTracker(router) {
    if (routerInstalled) return;
    routerInstalled = true;

    router.afterEach((to) => {
        openPage(to.fullPath);
    });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            sendHeartbeat({ isNewPage: false, useBeacon: true });
        } else {
            sendHeartbeat({ isNewPage: false });
        }
    });

    window.addEventListener('pagehide', () => {
        sendHeartbeat({ isNewPage: false, useBeacon: true });
    });

    document.addEventListener(
        'click',
        (event) => {
            const link = event.target?.closest?.('a');
            if (!link) return;
            const href = link.getAttribute('href') || '';
            const label = (link.textContent || '').trim().slice(0, 120) || href;
            trackEvent('click', {
                label,
                meta: { href },
            });
        },
        true
    );

    startHeartbeat();

    if (router.currentRoute?.value) {
        openPage(router.currentRoute.value.fullPath);
    }
}
