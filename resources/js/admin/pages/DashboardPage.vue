<template>
  <div>
    <div v-if="loading" class="admin-card admin-card-pad loading-state">Loading dashboard…</div>
    <div v-else-if="error" class="admin-card admin-card-pad error-state">{{ error }}</div>
    <template v-else>
      <div class="stat-grid stat-grid-4">
        <div class="admin-card stat-card">
          <p class="stat-label">Contact messages</p>
          <p class="stat-value">{{ stats.contacts_total }}</p>
          <p class="stat-hint">{{ stats.contacts_today }} today · {{ stats.contacts_week }} this week</p>
        </div>
        <div class="admin-card stat-card coral">
          <p class="stat-label">Newsletter subscribers</p>
          <p class="stat-value">{{ stats.subscribers_total }}</p>
          <p class="stat-hint">{{ stats.subscribers_today }} today · {{ stats.subscribers_week }} this week</p>
        </div>
        <div class="admin-card stat-card">
          <p class="stat-label">Team members</p>
          <p class="stat-value">{{ stats.team_total }}</p>
          <p class="stat-hint">{{ stats.team_active }} active on website</p>
        </div>
        <div class="admin-card stat-card coral">
          <p class="stat-label">Admin users</p>
          <p class="stat-value">{{ stats.users_total }}</p>
          <p class="stat-hint">Accounts with panel access</p>
        </div>
      </div>

      <div class="split-grid">
        <section class="admin-card admin-card-pad">
          <div class="section-head">
            <h2>Recent contacts</h2>
            <RouterLink class="btn btn-ghost btn-sm" to="/contacts">View all</RouterLink>
          </div>
          <div v-if="!recentContacts.length" class="empty-state">No contact submissions yet.</div>
          <div v-else class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>When</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in recentContacts" :key="item.id">
                  <td>
                    <RouterLink :to="`/contacts/${item.id}`">{{ item.name }}</RouterLink>
                  </td>
                  <td>{{ item.email }}</td>
                  <td>{{ formatDate(item.created_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section class="admin-card admin-card-pad">
          <div class="section-head">
            <h2>Team snapshot</h2>
            <RouterLink class="btn btn-ghost btn-sm" to="/teams">Manage</RouterLink>
          </div>
          <div v-if="!recentTeam.length" class="empty-state">No team members yet.</div>
          <div v-else class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in recentTeam" :key="item.id">
                  <td>
                    <div class="team-cell">
                      <img :src="item.image_url" :alt="item.name" class="team-thumb" />
                      <strong>{{ item.name }}</strong>
                    </div>
                  </td>
                  <td>{{ item.role }}</td>
                  <td>
                    <span class="badge" :class="{ 'badge-coral': !item.is_active }">
                      {{ item.is_active ? 'Active' : 'Hidden' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </template>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update-meta']);
const loading = ref(true);
const error = ref('');
const stats = ref({
  contacts_total: 0,
  contacts_today: 0,
  contacts_week: 0,
  subscribers_total: 0,
  subscribers_today: 0,
  subscribers_week: 0,
  team_total: 0,
  team_active: 0,
  users_total: 0,
});
const recentContacts = ref([]);
const recentTeam = ref([]);

function formatDate(value) {
  if (!value) return '—';
  return new Date(value).toLocaleString();
}

onMounted(async () => {
  emit('update-meta', {
    title: 'Dashboard',
    subtitle: 'Overview of website activity',
  });

  try {
    const { data } = await axios.get('/webuser/api/dashboard');
    stats.value = data.stats;
    recentContacts.value = data.recent_contacts;
    recentTeam.value = data.recent_team || [];
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load dashboard.';
  } finally {
    loading.value = false;
  }
});
</script>
