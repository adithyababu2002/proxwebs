import '../bootstrap';
import { createApp } from 'vue';
import { router } from './router';
import App from './App.vue';
import './admin.css';

// Prefer Laravel's XSRF-TOKEN cookie over the Blade meta tag.
// Login regenerates the session, so a meta CSRF token quickly becomes stale
// and would take precedence over the fresh cookie if set as X-CSRF-TOKEN.
delete window.axios.defaults.headers.common['X-CSRF-TOKEN'];

createApp(App).use(router).mount('#admin-app');
