import '../bootstrap';
import { createApp } from 'vue';
import { router } from './router';
import App from './App.vue';
import { installVisitorTracker } from './analytics';

// Prefer Laravel's XSRF-TOKEN cookie. The Blade meta CSRF token goes stale
// after analytics/session activity and would override the fresh cookie.
delete window.axios.defaults.headers.common['X-CSRF-TOKEN'];

installVisitorTracker(router);

createApp(App).use(router).mount('#onix-app');
