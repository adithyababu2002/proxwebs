<template>
  <Teleport to="body">
    <div v-if="dialogState.open" class="admin-dialog-backdrop" @click.self="onDismiss">
      <div class="admin-dialog admin-card" role="alertdialog" aria-modal="true" :aria-labelledby="titleId">
        <div class="admin-dialog-icon" :class="`tone-${dialogState.tone}`">
          <i :class="iconClass" aria-hidden="true"></i>
        </div>
        <h2 :id="titleId">{{ dialogState.title }}</h2>
        <p>{{ dialogState.message }}</p>
        <div class="admin-dialog-actions">
          <button
            v-if="dialogState.type === 'confirm'"
            type="button"
            class="btn btn-ghost"
            @click="dismissDialog"
          >
            {{ dialogState.cancelLabel }}
          </button>
          <button
            type="button"
            class="btn"
            :class="dialogState.tone === 'danger' ? 'btn-danger' : 'btn-primary'"
            @click="acceptDialog"
          >
            {{ dialogState.confirmLabel }}
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { computed } from 'vue';
import { acceptDialog, dialogState, dismissDialog } from '../dialog';

const titleId = 'admin-dialog-title';

const iconClass = computed(() => {
  if (dialogState.tone === 'danger') return 'fa fa-exclamation-triangle';
  if (dialogState.tone === 'success') return 'fa fa-check';
  return 'fa fa-info-circle';
});

function onDismiss() {
  if (dialogState.type === 'confirm') {
    dismissDialog();
  } else {
    acceptDialog();
  }
}
</script>
