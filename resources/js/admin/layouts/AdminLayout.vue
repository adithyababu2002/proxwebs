<template>
  <div class="admin-shell">
    <div v-if="navOpen" class="admin-backdrop" @click="navOpen = false" />

    <aside class="admin-sidebar" :class="{ 'is-open': navOpen }">
      <RouterLink to="/" class="admin-brand" @click="navOpen = false">
        <img :src="logo" alt="Proxwebs" />
        <div class="admin-brand-copy">
          <strong>Proxwebs</strong>
          <span>Admin Panel</span>
        </div>
      </RouterLink>

      <nav class="admin-nav">
        <RouterLink to="/" @click="navOpen = false">
          <i class="fa fa-th-large" aria-hidden="true"></i>
          Dashboard
        </RouterLink>
        <RouterLink to="/users" @click="navOpen = false">
          <i class="fa fa-users" aria-hidden="true"></i>
          Users
        </RouterLink>
        <RouterLink to="/teams" @click="navOpen = false">
          <i class="fa fa-sitemap" aria-hidden="true"></i>
          Team
        </RouterLink>
        <RouterLink to="/logs" @click="navOpen = false">
          <i class="fa fa-history" aria-hidden="true"></i>
          Logs
        </RouterLink>
        <RouterLink to="/contacts" @click="navOpen = false">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
          Contacts
        </RouterLink>
        <RouterLink to="/subscribers" @click="navOpen = false">
          <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
          Subscribers
        </RouterLink>
      </nav>

      <div class="admin-sidebar-foot">
        <div v-if="currentUser" class="admin-user">
          <strong>{{ currentUser.name }}</strong>
          <span>{{ currentUser.email }}</span>
        </div>
        <button type="button" class="btn btn-ghost" @click="toggleTheme">
          <i :class="isDark ? 'fa fa-sun-o' : 'fa fa-moon-o'" aria-hidden="true"></i>
          {{ isDark ? 'Light mode' : 'Dark mode' }}
        </button>
        <a class="btn btn-ghost" href="/" target="_blank" rel="noopener">
          <i class="fa fa-external-link" aria-hidden="true"></i>
          View site
        </a>
        <button type="button" class="btn btn-danger" :disabled="signingOut" @click="signOut">
          <i class="fa fa-sign-out" aria-hidden="true"></i>
          {{ signingOut ? 'Signing out…' : 'Sign out' }}
        </button>
      </div>
    </aside>

    <main class="admin-main">
      <div class="admin-topbar">
        <div>
          <button type="button" class="btn btn-ghost btn-sm mobile-toggle" @click="navOpen = true">
            <i class="fa fa-bars" aria-hidden="true"></i>
            Menu
          </button>
          <h1>{{ title }}</h1>
          <p>{{ subtitle }}</p>
        </div>
        <div class="admin-topbar-actions">
          <slot name="actions" />
        </div>
      </div>

      <RouterView v-slot="{ Component }">
        <component :is="Component" @update-meta="onMeta" />
      </RouterView>
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { currentUser, logout } from '../auth';

const THEME_KEY = 'onix-theme';
const router = useRouter();
const navOpen = ref(false);
const signingOut = ref(false);
const isDark = ref(false);
const title = ref('Dashboard');
const subtitle = ref('Overview of website activity');
const logo = '/onix/assets/images/LOGO10.png';

function applyTheme(dark) {
  isDark.value = dark;
  document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
  try {
    localStorage.setItem(THEME_KEY, dark ? 'dark' : 'light');
  } catch (e) {}
}

function toggleTheme() {
  applyTheme(!isDark.value);
}

function onMeta(meta = {}) {
  if (meta.title) title.value = meta.title;
  if (meta.subtitle) subtitle.value = meta.subtitle;
}

async function signOut() {
  signingOut.value = true;
  try {
    await logout();
    await router.replace({ name: 'login' });
  } finally {
    signingOut.value = false;
  }
}

onMounted(() => {
  try {
    applyTheme(localStorage.getItem(THEME_KEY) === 'dark');
  } catch (e) {
    applyTheme(false);
  }
});
</script>
