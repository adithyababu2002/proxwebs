<template>
  <div>
    <div class="toolbar">
      <input
        v-model.trim="search"
        class="admin-input"
        type="search"
        placeholder="Search name, email, phone…"
        @keyup.enter="load(1)"
      />
      <button type="button" class="btn btn-cyan" :disabled="loading" @click="load(1)">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search
      </button>
    </div>

    <section class="admin-card admin-card-pad">
      <div v-if="loading" class="loading-state">Loading contacts…</div>
      <div v-else-if="error" class="error-state">{{ error }}</div>
      <div v-else-if="!items.length" class="empty-state">No contact submissions found.</div>
      <template v-else>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Source</th>
                <th>Received</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>
                  <RouterLink :to="`/contacts/${item.id}`">{{ item.name }}</RouterLink>
                </td>
                <td>{{ item.email }}</td>
                <td>{{ item.phone || '—' }}</td>
                <td><span class="badge">{{ item.source }}</span></td>
                <td>{{ formatDate(item.created_at) }}</td>
                <td>
                  <div style="display: flex; gap: 8px; justify-content: flex-end">
                    <RouterLink class="btn btn-ghost btn-sm" :to="`/contacts/${item.id}`">View</RouterLink>
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

async function load(page = 1) {
  loading.value = true;
  error.value = '';

  try {
    const { data } = await axios.get('/webuser/api/contacts', {
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
    error.value = err.response?.data?.message || 'Failed to load contacts.';
  } finally {
    loading.value = false;
  }
}

async function remove(item) {
  const ok = await showConfirm({
    title: 'Delete contact',
    message: `Delete message from ${item.name}? This cannot be undone.`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deletingId.value = item.id;
  try {
    await axios.delete(`/webuser/api/contacts/${item.id}`);
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
    title: 'Contacts',
    subtitle: 'Messages submitted through the contact form',
  });
  load();
});
</script>
