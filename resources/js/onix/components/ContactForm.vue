<template>
  <form id="contact" action="" method="post" @submit.prevent="submit">
    <div class="row">
      <div class="col-lg-12">
        <fieldset>
          <label class="contact-label" for="contact-name">Name <span class="req">*</span></label>
          <input
            id="contact-name"
            v-model.trim="form.name"
            type="text"
            name="name"
            placeholder="Your full name"
            autocomplete="name"
            required
          />
        </fieldset>
      </div>
      <div class="col-lg-12">
        <fieldset>
          <label class="contact-label" for="contact-email">Email <span class="req">*</span></label>
          <input
            id="contact-email"
            v-model.trim="form.email"
            type="email"
            name="email"
            placeholder="Your email address"
            autocomplete="email"
            required
          />
        </fieldset>
      </div>
      <div class="col-lg-12">
        <fieldset>
          <label class="contact-label" for="contact-phone">Phone</label>
          <input
            id="contact-phone"
            v-model.trim="form.phone"
            type="tel"
            name="phone"
            placeholder="Phone number (optional)"
            autocomplete="tel"
          />
        </fieldset>
      </div>
      <div class="col-lg-12">
        <fieldset>
          <label class="contact-label" for="contact-description">Description <span class="req">*</span></label>
          <textarea
            id="contact-description"
            v-model.trim="form.description"
            name="description"
            rows="4"
            placeholder="Tell us how we can help"
            required
          ></textarea>
        </fieldset>
      </div>
      <div class="col-lg-12">
        <fieldset>
          <button id="form-submit" type="submit" class="main-button" :disabled="sending">
            {{ buttonLabel }}
          </button>
        </fieldset>
      </div>
      <div v-if="statusMessage" class="col-lg-12">
        <p class="contact-status" :class="{ 'is-error': isError, 'is-success': !isError }">
          {{ statusMessage }}
        </p>
      </div>
    </div>
  </form>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  source: {
    type: String,
    default: 'website',
  },
});

const form = reactive({
  name: '',
  email: '',
  phone: '',
  description: '',
});

const sending = ref(false);
const statusMessage = ref('');
const isError = ref(false);
const submitted = ref(false);

const buttonLabel = computed(() => {
  if (sending.value) return 'Sending...';
  if (submitted.value) return 'Message Sent';
  return 'Request Demo';
});

async function submit() {
  statusMessage.value = '';
  isError.value = false;
  sending.value = true;

  try {
    const { data } = await axios.post('/contact', {
      name: form.name,
      email: form.email,
      phone: form.phone || null,
      description: form.description,
      source: props.source,
      visitor_uuid: localStorage.getItem('proxwebs_visitor_uuid') || undefined,
    });

    try {
      const { identifyVisitor } = await import('../analytics');
      await identifyVisitor({
        email: form.email,
        name: form.name,
        source: `contact:${props.source}`,
      });
    } catch (e) {}

    submitted.value = true;
    statusMessage.value = data.message || 'Thank you! Your message has been sent successfully.';
    form.name = '';
    form.email = '';
    form.phone = '';
    form.description = '';
  } catch (error) {
    isError.value = true;
    const errors = error.response?.data?.errors;
    if (errors) {
      statusMessage.value = Object.values(errors).flat()[0] || 'Please check the form and try again.';
    } else {
      statusMessage.value = error.response?.data?.message || 'Something went wrong. Please try again.';
    }
  } finally {
    sending.value = false;
  }
}
</script>

<style scoped>
.contact-label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: #2a2a2a;
  margin-bottom: 6px;
}

.contact-label .req {
  color: #ff695f;
}

form#contact textarea {
  width: 100%;
  min-height: 110px;
  border-radius: 0;
  background-color: transparent;
  border-bottom: 1px solid #9bdbf8;
  border-top: none;
  border-left: none;
  border-right: none;
  outline: none;
  font-size: 15px;
  font-weight: 300;
  color: #2a2a2a;
  padding: 8px 0;
  margin-bottom: 28px;
  resize: vertical;
  font-family: inherit;
}

form#contact textarea::placeholder {
  color: #afafaf;
}

form#contact button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.contact-status {
  margin: 0 0 10px;
  font-size: 14px;
  line-height: 1.6;
}

.contact-status.is-success {
  color: #03a4ed;
}

.contact-status.is-error {
  color: #ff695f;
}
</style>
