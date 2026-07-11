<template>
  <div>
    <div class="toolbar">
      <RouterLink class="btn btn-ghost" to="/contacts">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Back to contacts
      </RouterLink>
      <button
        v-if="item"
        type="button"
        class="btn btn-danger"
        :disabled="deleting"
        @click="remove"
      >
        Delete message
      </button>
    </div>

    <section class="admin-card admin-card-pad">
      <div v-if="loading" class="loading-state">Loading message…</div>
      <div v-else-if="error" class="error-state">{{ error }}</div>
      <div v-else-if="item" class="detail-grid">
        <div class="detail-item">
          <label>Name</label>
          <p>{{ item.name }}</p>
        </div>
        <div class="detail-item">
          <label>Email</label>
          <p>
            <a :href="`mailto:${item.email}`">{{ item.email }}</a>
          </p>
        </div>
        <div class="detail-item">
          <label>Phone</label>
          <p>
            <a v-if="item.phone" :href="`tel:${item.phone}`">{{ item.phone }}</a>
            <span v-else>—</span>
          </p>
        </div>
        <div class="detail-item">
          <label>Source</label>
          <p><span class="badge">{{ item.source }}</span></p>
        </div>
        <div class="detail-item">
          <label>Received</label>
          <p>{{ formatDate(item.created_at) }}</p>
        </div>
        <div class="detail-item full">
          <label>Message</label>
          <p>{{ item.description }}</p>
        </div>
      </div>
    </section>
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

async function load() {
  loading.value = true;
  error.value = '';
  item.value = null;

  try {
    const { data } = await axios.get(`/webuser/api/contacts/${props.id}`);
    item.value = data.data;
    emit('update-meta', {
      title: item.value.name,
      subtitle: 'Contact submission details',
    });
  } catch (err) {
    error.value = err.response?.data?.message || 'Contact not found.';
  } finally {
    loading.value = false;
  }
}

async function remove() {
  if (!item.value) return;

  const ok = await showConfirm({
    title: 'Delete contact',
    message: `Delete message from ${item.value.name}? This cannot be undone.`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deleting.value = true;
  try {
    await axios.delete(`/webuser/api/contacts/${item.value.id}`);
    await router.push({ name: 'contacts' });
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
