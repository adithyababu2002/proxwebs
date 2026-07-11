import { createRouter, createWebHistory } from 'vue-router';
import HomePage from './pages/HomePage.vue';
import AboutPage from './pages/AboutPage.vue';
import ServicesPage from './pages/ServicesPage.vue';
import TeamPage from './pages/TeamPage.vue';
import ZeloPage from './pages/ZeloPage.vue';
import ContactPage from './pages/ContactPage.vue';
import OverviewPage from './pages/OverviewPage.vue';
import FeaturesPage from './pages/FeaturesPage.vue';
import FeatureDetailPage from './pages/FeatureDetailPage.vue';

const routes = [
    { path: '/', name: 'home', component: HomePage, meta: { sectionId: 'top' } },
    { path: '/services', name: 'services', component: ServicesPage },
    { path: '/features', name: 'features', component: FeaturesPage },
    { path: '/features/:slug', name: 'feature-detail', component: FeatureDetailPage },
    { path: '/about', name: 'about', component: AboutPage },
    { path: '/team', name: 'team', component: TeamPage },
    { path: '/zelo', name: 'zelo', component: ZeloPage },
    { path: '/overview', name: 'overview', component: OverviewPage },
    { path: '/portfolio', redirect: '/zelo' },
    { path: '/videos', name: 'videos', component: HomePage, meta: { sectionId: 'video' } },
    { path: '/contact', name: 'contact', component: ContactPage },
    { path: '/:pathMatch(.*)*', redirect: '/' },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to) {
        if (['about', 'services', 'features', 'feature-detail', 'team', 'zelo', 'contact', 'overview'].includes(to.name)) {
            return { top: 0 };
        }

        const sectionId = to.meta?.sectionId;
        if (!sectionId) return { top: 0 };

        // Manual scroll is handled in HomePage after the DOM is ready.
        return false;
    },
});
