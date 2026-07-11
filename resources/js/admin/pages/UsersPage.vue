<template>
  <div>
    <div class="toolbar">
      <input
        v-model.trim="search"
        class="admin-input"
        type="search"
        placeholder="Search name or email…"
        @keyup.enter="load(1)"
      />
      <button type="button" class="btn btn-cyan" :disabled="loading" @click="load(1)">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search
      </button>
      <button type="button" class="btn btn-primary" @click="openCreate">
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add user
      </button>
    </div>

    <section class="admin-card admin-card-pad">
      <div v-if="loading" class="loading-state">Loading users…</div>
      <div v-else-if="error" class="error-state">{{ error }}</div>
      <div v-else-if="!items.length" class="empty-state">No admin users found.</div>
      <template v-else>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>
                  <strong>{{ item.name }}</strong>
                  <span v-if="item.id === currentUser?.id" class="badge" style="margin-left: 8px">You</span>
                </td>
                <td>{{ item.email }}</td>
                <td>{{ formatDate(item.created_at) }}</td>
                <td>
                  <div class="row-actions">
                    <button type="button" class="btn btn-ghost btn-sm" @click="openEdit(item)">Edit</button>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      :disabled="deletingId === item.id || item.id === currentUser?.id"
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

    <div v-if="modalOpen" class="admin-modal-backdrop" @click.self="closeModal">
      <div class="admin-modal admin-card">
        <div class="admin-modal-head">
          <h2>{{ editingId ? 'Edit user' : 'Add user' }}</h2>
          <button type="button" class="btn btn-ghost btn-sm" @click="closeModal">Close</button>
        </div>

        <p v-if="formError" class="login-error">{{ formError }}</p>

        <form @submit.prevent="save">
          <div class="form-group">
            <label for="user-name">Name</label>
            <input id="user-name" v-model.trim="form.name" class="admin-input" type="text" required :disabled="saving" />
          </div>
          <div class="form-group">
            <label for="user-email">Email</label>
            <input id="user-email" v-model.trim="form.email" class="admin-input" type="email" required :disabled="saving" />
          </div>
          <div class="form-group">
            <label for="user-password">{{ editingId ? 'New password (optional)' : 'Password' }}</label>
            <input
              id="user-password"
              v-model="form.password"
              class="admin-input"
              type="password"
              :required="!editingId"
              autocomplete="new-password"
              :disabled="saving"
            />
          </div>
          <div class="form-group">
            <label for="user-password-confirm">Confirm password</label>
            <input
              id="user-password-confirm"
              v-model="form.password_confirmation"
              class="admin-input"
              type="password"
              :required="!editingId || !!form.password"
              autocomplete="new-password"
              :disabled="saving"
            />
          </div>

          <div class="admin-modal-actions">
            <button type="button" class="btn btn-ghost" :disabled="saving" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="saving">
              {{ saving ? 'Saving…' : editingId ? 'Update user' : 'Create user' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import { currentUser } from '../auth';
import { showAlert, showConfirm } from '../dialog';

const emit = defineEmits(['update-meta']);
const loading = ref(true);
const saving = ref(false);
const error = ref('');
const formError = ref('');
const search = ref('');
const items = ref([]);
const deletingId = ref(null);
const modalOpen = ref(false);
const editingId = ref(null);
const meta = ref({
  current: 1,
  from: 0,
  to: 0,
  total: 0,
  prev: false,
  next: false,
});
const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

function formatDate(value) {
  if (!value) return '—';
  return new Date(value).toLocaleString();
}

function resetForm() {
  form.name = '';
  form.email = '';
  form.password = '';
  form.password_confirmation = '';
  formError.value = '';
}

function openCreate() {
  editingId.value = null;
  resetForm();
  modalOpen.value = true;
}

function openEdit(item) {
  editingId.value = item.id;
  form.name = item.name;
  form.email = item.email;
  form.password = '';
  form.password_confirmation = '';
  formError.value = '';
  modalOpen.value = true;
}

function closeModal() {
  modalOpen.value = false;
  editingId.value = null;
  resetForm();
}

async function load(page = 1) {
  loading.value = true;
  error.value = '';

  try {
    const { data } = await axios.get('/webuser/api/users', {
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
    error.value = err.response?.data?.message || 'Failed to load users.';
  } finally {
    loading.value = false;
  }
}

async function save() {
  saving.value = true;
  formError.value = '';

  const payload = {
    name: form.name,
    email: form.email,
  };

  if (form.password) {
    payload.password = form.password;
    payload.password_confirmation = form.password_confirmation;
  } else if (!editingId.value) {
    payload.password = form.password;
    payload.password_confirmation = form.password_confirmation;
  }

  try {
    if (editingId.value) {
      await axios.put(`/webuser/api/users/${editingId.value}`, payload);
    } else {
      await axios.post('/webuser/api/users', payload);
    }
    closeModal();
    await load(meta.value.current || 1);
  } catch (err) {
    const errors = err.response?.data?.errors;
    formError.value =
      (errors && Object.values(errors).flat()[0]) ||
      err.response?.data?.message ||
      'Unable to save user.';
  } finally {
    saving.value = false;
  }
}

async function remove(item) {
  const ok = await showConfirm({
    title: 'Delete user',
    message: `Delete user ${item.name}? This cannot be undone.`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deletingId.value = item.id;
  try {
    await axios.delete(`/webuser/api/users/${item.id}`);
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
    title: 'Users',
    subtitle: 'Manage admin accounts that can access this panel',
  });
  load();
});
</script>
