<template>
  <div>
    <div class="toolbar">
      <input
        v-model.trim="search"
        class="admin-input"
        type="search"
        placeholder="Search email, IP, city, country…"
        @keyup.enter="load(1)"
      />
      <button type="button" class="btn btn-cyan" :disabled="loading" @click="load(1)">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search
      </button>
    </div>

    <section class="admin-card admin-card-pad">
      <div v-if="loading" class="loading-state">Loading visitor logs…</div>
      <div v-else-if="error" class="error-state">{{ error }}</div>
      <div v-else-if="!items.length" class="empty-state">
        No visitor logs yet. Browse the public website to generate activity.
      </div>
      <template v-else>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Visitor</th>
                <th>Location</th>
                <th>Device</th>
                <th>Time on site</th>
                <th>Pages</th>
                <th>Last seen</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>
                  <strong>{{ item.name || item.email || 'Anonymous visitor' }}</strong>
                  <div class="muted-line">{{ item.email || item.ip_address || '—' }}</div>
                </td>
                <td>
                  {{ item.location }}
                  <div class="muted-line">{{ item.ip_address || '—' }}</div>
                </td>
                <td>
                  {{ item.device || '—' }}
                  <div class="muted-line">{{ [item.browser, item.platform].filter(Boolean).join(' · ') || '—' }}</div>
                </td>
                <td>{{ formatDuration(item.total_duration_seconds) }}</td>
                <td>
                  <span class="badge">{{ item.page_views_count }}</span>
                </td>
                <td>{{ formatDate(item.last_seen_at) }}</td>
                <td>
                  <div class="row-actions">
                    <RouterLink class="btn btn-ghost btn-sm" :to="`/logs/${item.id}`">View</RouterLink>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      :disabled="deletingId === item.id"
                      @click="remove(item)"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="pagination">
          <div class="pagination-meta">
            Showing {{ meta.from || 0 }}–{{ meta.to || 0 }} of {{ meta.total || 0 }}
          </div>
          <div class="pagination-actions">
            <button type="button" class="btn btn-ghost btn-sm" :disabled="!meta.prev" @click="load(meta.current - 1)">
              Previous
            </button>
            <button type="button" class="btn btn-ghost btn-sm" :disabled="!meta.next" @click="load(meta.current + 1)">
              Next
            </button>
          </div>
        </div>
      </template>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { showAlert, showConfirm } from '../dialog';

const emit = defineEmits(['update-meta']);
const loading = ref(true);
const error = ref('');
const search = ref('');
const items = ref([]);
const deletingId = ref(null);
const meta = ref({
  current: 1,
  from: 0,
  to: 0,
  total: 0,
  prev: false,
  next: false,
});

function formatDate(value) {
  if (!value) return '—';
  return new Date(value).toLocaleString();
}

function formatDuration(seconds) {
  const total = Number(seconds) || 0;
  const mins = Math.floor(total / 60);
  const secs = total % 60;
  if (mins <= 0) return `${secs}s`;
  return `${mins}m ${secs}s`;
}

async function load(page = 1) {
  loading.value = true;
  error.value = '';

  try {
    const { data } = await axios.get('/webuser/api/logs', {
      params: { page, q: search.value || undefined },
    });
    items.value = data.data || [];
    meta.value = {
      current: data.current_page,
      from: data.from,
      to: data.to,
      total: data.total,
      prev: !!data.prev_page_url,
      next: !!data.next_page_url,
    };
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load visitor logs.';
  } finally {
    loading.value = false;
  }
}

async function remove(item) {
  const ok = await showConfirm({
    title: 'Delete visitor log',
    message: `Delete log for ${item.email || item.ip_address || 'this visitor'}?`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deletingId.value = item.id;
  try {
    await axios.delete(`/webuser/api/logs/${item.id}`);
    await load(meta.value.current);
  } catch (err) {
    await showAlert({
      title: 'Delete failed',
      message: err.response?.data?.message || 'Delete failed.',
      tone: 'danger',
    });
  } finally {
    deletingId.value = null;
  }
}

onMounted(() => {
  emit('update-meta', {
    title: 'Logs',
    subtitle: 'Visitor activity, page time, location, and emails',
  });
  load();
});
</script>
