<template>
  <div>
    <div class="toolbar">
      <input
        v-model.trim="search"
        class="admin-input"
        type="search"
        placeholder="Search name, role, or slug…"
        @keyup.enter="load(1)"
      />
      <button type="button" class="btn btn-cyan" :disabled="loading" @click="load(1)">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search
      </button>
      <button type="button" class="btn btn-primary" @click="openCreate">
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add member
      </button>
    </div>

    <section class="admin-card admin-card-pad">
      <div v-if="loading" class="loading-state">Loading team members…</div>
      <div v-else-if="error" class="error-state">{{ error }}</div>
      <div v-else-if="!items.length" class="empty-state">No team members yet. Add your first member.</div>
      <template v-else>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Member</th>
                <th>Role</th>
                <th>Order</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>
                  <div class="team-cell">
                    <img :src="item.image_url" :alt="item.name" class="team-thumb" />
                    <div>
                      <strong>{{ item.name }}</strong>
                      <div class="muted-line">{{ item.slug }}</div>
                    </div>
                  </div>
                </td>
                <td>{{ item.role }}</td>
                <td>{{ item.sort_order }}</td>
                <td>
                  <span class="badge" :class="{ 'badge-coral': !item.is_active }">
                    {{ item.is_active ? 'Active' : 'Hidden' }}
                  </span>
                </td>
                <td>
                  <div class="row-actions">
                    <button type="button" class="btn btn-ghost btn-sm" @click="openEdit(item)">Edit</button>
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

    <div v-if="modalOpen" class="admin-modal-backdrop" @click.self="closeModal">
      <div class="admin-modal admin-card admin-modal-wide">
        <div class="admin-modal-head">
          <h2>{{ editingId ? 'Edit team member' : 'Add team member' }}</h2>
          <button type="button" class="btn btn-ghost btn-sm" @click="closeModal">Close</button>
        </div>

        <p v-if="formError" class="login-error">{{ formError }}</p>

        <form @submit.prevent="save">
          <div class="form-grid">
            <div class="form-group">
              <label for="member-name">Name</label>
              <input id="member-name" v-model.trim="form.name" class="admin-input" type="text" required :disabled="saving" />
            </div>
            <div class="form-group">
              <label for="member-role">Role</label>
              <input id="member-role" v-model.trim="form.role" class="admin-input" type="text" required :disabled="saving" />
            </div>
            <div class="form-group">
              <label for="member-slug">Slug (optional)</label>
              <input id="member-slug" v-model.trim="form.slug" class="admin-input" type="text" :disabled="saving" />
            </div>
            <div class="form-group">
              <label for="member-order">Sort order</label>
              <input
                id="member-order"
                v-model.number="form.sort_order"
                class="admin-input"
                type="number"
                min="0"
                :disabled="saving"
              />
            </div>
            <div class="form-group full">
              <label for="member-short">Short bio</label>
              <textarea
                id="member-short"
                v-model.trim="form.short_bio"
                class="admin-textarea"
                rows="2"
                :disabled="saving"
              />
            </div>
            <div class="form-group full">
              <label for="member-bio">Full bio</label>
              <textarea id="member-bio" v-model.trim="form.bio" class="admin-textarea" rows="5" :disabled="saving" />
            </div>
            <div class="form-group full">
              <label for="member-focus">Focus areas (comma or new line separated)</label>
              <textarea
                id="member-focus"
                v-model="form.focus_text"
                class="admin-textarea"
                rows="3"
                placeholder="Full-stack development, CMS architecture"
                :disabled="saving"
              />
            </div>
            <div class="form-group">
              <label for="member-image-path">Image filename or path</label>
              <input
                id="member-image-path"
                v-model.trim="form.image_path"
                class="admin-input"
                type="text"
                placeholder="e.g. sanoof-khan.png or /storage/team/photo.jpg"
                :disabled="saving"
              />
              <p class="field-hint">Use an existing file in /onix/assets/images, or upload a new photo below.</p>
            </div>
            <div class="form-group">
              <label>Upload photo</label>
              <div
                class="file-upload"
                :class="{ 'has-file': !!fileLabel || !!previewUrl, disabled: saving }"
                @click="triggerFile"
              >
                <input
                  id="member-image"
                  ref="fileInput"
                  class="file-upload-input"
                  type="file"
                  accept="image/*"
                  :disabled="saving"
                  @change="onFile"
                  @click.stop
                />
                <div class="file-upload-preview">
                  <img v-if="previewUrl" :src="previewUrl" alt="Preview" />
                  <i v-else class="fa fa-image" aria-hidden="true"></i>
                </div>
                <div class="file-upload-body">
                  <strong>{{ fileLabel || 'Choose an image' }}</strong>
                  <span>{{ fileLabel ? 'Click to replace photo' : 'PNG, JPG up to 4MB' }}</span>
                </div>
                <span class="file-upload-action">
                  <i class="fa fa-upload" aria-hidden="true"></i>
                  Browse
                </span>
              </div>
              <button
                v-if="imageFile"
                type="button"
                class="btn btn-ghost btn-sm file-clear"
                :disabled="saving"
                @click="clearFile"
              >
                Clear selected file
              </button>
            </div>
            <div class="form-group full">
              <label class="checkbox-label">
                <input v-model="form.is_active" type="checkbox" :disabled="saving" />
                Show on website
              </label>
            </div>
          </div>

          <div class="admin-modal-actions">
            <button type="button" class="btn btn-ghost" :disabled="saving" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="saving">
              {{ saving ? 'Saving…' : editingId ? 'Update member' : 'Create member' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';
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
const imageFile = ref(null);
const fileInput = ref(null);
const fileLabel = ref('');
const objectPreview = ref('');
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
  role: '',
  slug: '',
  short_bio: '',
  bio: '',
  focus_text: '',
  image_path: '',
  sort_order: 0,
  is_active: true,
  current_image_url: '',
});

const previewUrl = computed(() => {
  if (objectPreview.value) return objectPreview.value;
  if (form.image_path) {
    if (form.image_path.startsWith('/') || form.image_path.startsWith('http')) {
      return form.image_path;
    }
    return `/onix/assets/images/${form.image_path}`;
  }
  return form.current_image_url || '';
});

function revokePreview() {
  if (objectPreview.value) {
    URL.revokeObjectURL(objectPreview.value);
    objectPreview.value = '';
  }
}

function resetForm() {
  form.name = '';
  form.role = '';
  form.slug = '';
  form.short_bio = '';
  form.bio = '';
  form.focus_text = '';
  form.image_path = '';
  form.sort_order = 0;
  form.is_active = true;
  form.current_image_url = '';
  imageFile.value = null;
  fileLabel.value = '';
  revokePreview();
  formError.value = '';
  if (fileInput.value) fileInput.value.value = '';
}

function openCreate() {
  editingId.value = null;
  resetForm();
  modalOpen.value = true;
}

function openEdit(item) {
  editingId.value = item.id;
  form.name = item.name;
  form.role = item.role;
  form.slug = item.slug;
  form.short_bio = item.short_bio || '';
  form.bio = item.bio || '';
  form.focus_text = (item.focus || []).join(', ');
  form.image_path = item.image || '';
  form.sort_order = item.sort_order ?? 0;
  form.is_active = !!item.is_active;
  form.current_image_url = item.image_url || '';
  imageFile.value = null;
  fileLabel.value = '';
  revokePreview();
  formError.value = '';
  if (fileInput.value) fileInput.value.value = '';
  modalOpen.value = true;
}

function closeModal() {
  modalOpen.value = false;
  editingId.value = null;
  resetForm();
}

function triggerFile() {
  fileInput.value?.click();
}

function onFile(event) {
  const file = event.target.files?.[0] || null;
  imageFile.value = file;
  fileLabel.value = file ? file.name : '';
  revokePreview();
  if (file) {
    objectPreview.value = URL.createObjectURL(file);
  }
}

function clearFile() {
  imageFile.value = null;
  fileLabel.value = '';
  revokePreview();
  if (fileInput.value) fileInput.value.value = '';
}

async function load(page = 1) {
  loading.value = true;
  error.value = '';

  try {
    const { data } = await axios.get('/webuser/api/team-members', {
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
    error.value = err.response?.data?.message || 'Failed to load team members.';
  } finally {
    loading.value = false;
  }
}

async function save() {
  saving.value = true;
  formError.value = '';

  const payload = new FormData();
  payload.append('name', form.name);
  payload.append('role', form.role);
  if (form.slug) payload.append('slug', form.slug);
  payload.append('short_bio', form.short_bio || '');
  payload.append('bio', form.bio || '');
  payload.append('focus', form.focus_text || '');
  payload.append('sort_order', String(form.sort_order || 0));
  payload.append('is_active', form.is_active ? '1' : '0');
  if (form.image_path) payload.append('image_path', form.image_path);
  if (imageFile.value) payload.append('image', imageFile.value);

  try {
    if (editingId.value) {
      payload.append('_method', 'PUT');
      await axios.post(`/webuser/api/team-members/${editingId.value}`, payload);
    } else {
      await axios.post('/webuser/api/team-members', payload);
    }
    closeModal();
    await load(meta.value.current || 1);
  } catch (err) {
    const errors = err.response?.data?.errors;
    formError.value =
      (errors && Object.values(errors).flat()[0]) ||
      err.response?.data?.message ||
      'Unable to save team member.';
  } finally {
    saving.value = false;
  }
}

async function remove(item) {
  const ok = await showConfirm({
    title: 'Delete team member',
    message: `Delete ${item.name} from the team? This cannot be undone.`,
    confirmLabel: 'Delete',
  });
  if (!ok) return;

  deletingId.value = item.id;
  try {
    await axios.delete(`/webuser/api/team-members/${item.id}`);
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
    title: 'Team',
    subtitle: 'Manage team members shown on the website',
  });
  load();
});
</script>
