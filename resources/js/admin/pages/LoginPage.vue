<template>
  <div class="login-page">
    <div class="admin-card login-card">
      <div class="login-brand">
        <img src="/onix/assets/images/LOGO10.png" alt="Proxwebs" />
        <h1>Admin Access</h1>
        <p>Sign in with your email and password to manage the Proxwebs website.</p>
      </div>

      <p v-if="error" class="login-error">{{ error }}</p>

      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model.trim="form.email"
            class="admin-input"
            type="email"
            autocomplete="username"
            required
            :disabled="sending"
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password"
            v-model="form.password"
            class="admin-input"
            type="password"
            autocomplete="current-password"
            required
            :disabled="sending"
          />
        </div>

        <div class="form-row">
          <label>
            <input v-model="form.remember" type="checkbox" :disabled="sending" />
            Remember me
          </label>
        </div>

        <button type="submit" class="btn btn-primary login-submit" :disabled="sending">
          {{ sending ? 'Signing in…' : 'Sign in' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { login } from '../auth';

const router = useRouter();
const route = useRoute();
const sending = ref(false);
const error = ref('');
const form = reactive({
  email: '',
  password: '',
  remember: true,
});

async function submit() {
  sending.value = true;
  error.value = '';

  try {
    await login(form);
    const redirect = typeof route.query.redirect === 'string' ? route.query.redirect : '/';
    await router.replace(redirect);
  } catch (err) {
    const errors = err.response?.data?.errors;
    error.value =
      (errors && Object.values(errors).flat()[0]) ||
      err.response?.data?.message ||
      'Unable to sign in. Please try again.';
  } finally {
    sending.value = false;
  }
}
</script>
