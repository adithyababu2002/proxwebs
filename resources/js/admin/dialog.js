import { reactive } from 'vue';

export const dialogState = reactive({
  open: false,
  type: 'alert',
  title: '',
  message: '',
  confirmLabel: 'OK',
  cancelLabel: 'Cancel',
  tone: 'default',
  resolve: null,
});

function openDialog(options) {
  return new Promise((resolve) => {
    dialogState.open = true;
    dialogState.type = options.type || 'alert';
    dialogState.title = options.title || '';
    dialogState.message = options.message || '';
    dialogState.confirmLabel = options.confirmLabel || 'OK';
    dialogState.cancelLabel = options.cancelLabel || 'Cancel';
    dialogState.tone = options.tone || 'default';
    dialogState.resolve = resolve;
  });
}

function closeDialog(result) {
  const resolve = dialogState.resolve;
  dialogState.open = false;
  dialogState.resolve = null;
  if (resolve) resolve(result);
}

export function showAlert({ title = 'Notice', message, confirmLabel = 'OK', tone = 'default' } = {}) {
  return openDialog({
    type: 'alert',
    title,
    message,
    confirmLabel,
    tone,
  });
}

export function showConfirm({
  title = 'Please confirm',
  message,
  confirmLabel = 'Confirm',
  cancelLabel = 'Cancel',
  tone = 'danger',
} = {}) {
  return openDialog({
    type: 'confirm',
    title,
    message,
    confirmLabel,
    cancelLabel,
    tone,
  });
}

export function acceptDialog() {
  closeDialog(true);
}

export function dismissDialog() {
  closeDialog(false);
}
