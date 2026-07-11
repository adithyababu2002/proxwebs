<template>
  <div>
    <div class="toolbar">
      <RouterLink class="btn btn-ghost" to="/logs">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Back to logs
      </RouterLink>
      <button
        v-if="item"
        type="button"
        class="btn btn-danger"
        :disabled="deleting"
        @click="remove"
      >
        Delete log
      </button>
    </div>

    <div v-if="loading" class="admin-card admin-card-pad loading-state">Loading visitor details…</div>
    <div v-else-if="error" class="admin-card admin-card-pad error-state">{{ error }}</div>
    <template v-else-if="item">
      <section class="admin-card admin-card-pad" style="margin-bottom: 18px">
        <div class="detail-grid">
          <div class="detail-item">
            <label>Visitor</label>
            <p>{{ item.name || 'Anonymous visitor' }}</p>
          </div>
          <div class="detail-item">
            <label>Email</label>
            <p>
              <a v-if="item.email" :href="`mailto:${item.email}`">{{ item.email }}</a>
              <span v-else>Not captured yet</span>
            </p>
          </div>
          <div class="detail-item">
            <label>Location</label>
            <p>{{ item.location }}</p>
          </div>
          <div class="detail-item">
            <label>IP address</label>
            <p>{{ item.ip_address || '—' }}</p>
          </div>
          <div class="detail-item">
            <label>Device</label>
            <p>{{ [item.device, item.browser, item.platform].filter(Boolean).join(' · ') || '—' }}</p>
          </div>
          <div class="detail-item">
            <label>Total time</label>
            <p>{{ formatDuration(item.total_duration_seconds) }}</p>
          </div>
          <div class="detail-item">
            <label>Landing page</label>
            <p>{{ item.landing_page || '—' }}</p>
          </div>
          <div class="detail-item">
            <label>Referrer</label>
            <p>{{ item.referrer || 'Direct / unknown' }}</p>
          </div>
          <div class="detail-item">
            <label>First seen</label>
            <p>{{ formatDate(item.first_seen_at) }}</p>
          </div>
          <div class="detail-item">
            <label>Last seen</label>
            <p>{{ formatDate(item.last_seen_at) }}</p>
          </div>
        </div>
      </section>

      <div class="split-grid">
        <section class="admin-card admin-card-pad">
          <div class="section-head">
            <h2>Pages visited</h2>
            <span class="badge">{{ item.page_views?.length || 0 }}</span>
          </div>
          <div v-if="!item.page_views?.length" class="empty-state">No page views recorded.</div>
          <div v-else class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Page</th>
                  <th>Duration</th>
                  <th>When</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="view in item.page_views" :key="view.id">
                  <td>
                    <strong>{{ view.path }}</strong>
                    <div class="muted-line">{{ view.title || '—' }}</div>
                  </td>
                  <td>{{ formatDuration(view.duration_seconds) }}</td>
                  <td>{{ formatDate(view.started_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section class="admin-card admin-card-pad">
          <div class="section-head">
            <h2>Activity</h2>
            <span class="badge">{{ item.events?.length || 0 }}</span>
          </div>
          <div v-if="!item.events?.length" class="empty-state">No activity events yet.</div>
          <div v-else class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Event</th>
                  <th>Page</th>
                  <th>When</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="event in item.events" :key="event.id">
                  <td>
                    <span class="badge">{{ event.type }}</span>
                    <div class="muted-line">{{ event.label || '—' }}</div>
                  </td>
                  <td>{{ event.path || '—' }}</td>
                  <td>{{ formatDate(event.occurred_at) }}</td>
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
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { showAlert, showConfirm } from '../dialog';

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
});

const emit = defineEmits(['update-meta']);
const router = useRouter();
const loading = ref(true);
const deleting = ref(false);
const error = ref('');
const item = ref(null);

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

async function load() {
  loading.value = true;
  error.value = '';
  item.value = null;

  try {
    const { data } = await axios.get(`/webuser/api/logs/${props.id}`);
    item.value = data.data;
    emit('update-meta', {
      title: item.value.email || item.value.name || 'Visitor log',
      subtitle: item.value.location || 'Visitor activity details',
    });
  } catch (err) {
    error.value = err.response?.data?.message || 'Visitor log not found.';
  } finally {
    loading.value = false;
  }
}

async function remove() {
  if (!item.value) return;

  const ok = await showConfirm({
    title: 'Delete visitor log',
    message: `Delete this visitor log permanently?`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deleting.value = true;
  try {
    await axios.delete(`/webuser/api/logs/${item.value.id}`);
    await router.push({ name: 'logs' });
  } catch (err) {
    await showAlert({
      title: 'Delete failed',
      message: err.response?.data?.message || 'Delete failed.',
      tone: 'danger',
    });
  } finally {
    deleting.value = false;
  }
}

onMounted(load);
watch(() => props.id, load);
</script>
