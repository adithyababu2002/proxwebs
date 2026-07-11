import { createRouter, createWebHistory } from 'vue-router';
import { fetchMe, isAuthenticated } from './auth';

const LoginPage = () => import('./pages/LoginPage.vue');
const DashboardPage = () => import('./pages/DashboardPage.vue');
const UsersPage = () => import('./pages/UsersPage.vue');
const TeamsPage = () => import('./pages/TeamsPage.vue');
const LogsPage = () => import('./pages/LogsPage.vue');
const LogDetailPage = () => import('./pages/LogDetailPage.vue');
const ContactsPage = () => import('./pages/ContactsPage.vue');
const ContactDetailPage = () => import('./pages/ContactDetailPage.vue');
const SubscribersPage = () => import('./pages/SubscribersPage.vue');
const AdminLayout = () => import('./layouts/AdminLayout.vue');

export const router = createRouter({
    history: createWebHistory('/webuser'),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginPage,
            meta: { guest: true },
        },
        {
            path: '/',
            component: AdminLayout,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'dashboard',
                    component: DashboardPage,
                },
                {
                    path: 'users',
                    name: 'users',
                    component: UsersPage,
                },
                {
                    path: 'teams',
                    name: 'teams',
                    component: TeamsPage,
                },
                {
                    path: 'logs',
                    name: 'logs',
                    component: LogsPage,
                },
                {
                    path: 'logs/:id',
                    name: 'log-detail',
                    component: LogDetailPage,
                    props: true,
                },
                {
                    path: 'contacts',
                    name: 'contacts',
                    component: ContactsPage,
                },
                {
                    path: 'contacts/:id',
                    name: 'contact-detail',
                    component: ContactDetailPage,
                    props: true,
                },
                {
                    path: 'subscribers',
                    name: 'subscribers',
                    component: SubscribersPage,
                },
            ],
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: '/',
        },
    ],
    scrollBehavior() {
        return { top: 0 };
    },
});

let authChecked = false;

router.beforeEach(async (to) => {
    if (!authChecked) {
        await fetchMe();
        authChecked = true;
    }

    if (to.meta.requiresAuth && !isAuthenticated.value) {
        return { name: 'login', query: { redirect: to.fullPath } };
    }

    if (to.meta.guest && isAuthenticated.value) {
        return { name: 'dashboard' };
    }

    return true;
});
