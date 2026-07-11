<template>
  <div class="scan-me-qr" role="img" :aria-label="ariaLabel">
    <div class="scan-me-qr__frame">
      <div class="scan-me-qr__glow" aria-hidden="true"></div>
      <img v-if="qrDataUrl" :src="qrDataUrl" alt="" class="scan-me-qr__code" width="112" height="112" />
      <div v-else class="scan-me-qr__placeholder" aria-hidden="true"></div>
    </div>
    <span class="scan-me-qr__hint">Project overview</span>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import QRCode from 'qrcode';

const props = defineProps({
  /** Absolute URL encoded in the QR. Defaults to current origin + /overview */
  url: {
    type: String,
    default: '',
  },
});

const router = useRouter();
const qrDataUrl = ref('');

const targetUrl = computed(() => {
  if (props.url) return props.url;
  if (typeof window === 'undefined') return '/overview';
  const path = router.resolve({ name: 'overview' }).href;
  return new URL(path, window.location.origin).href;
});

const ariaLabel = computed(() => `QR code for project overview`);

async function renderQr() {
  try {
    // Encode overview URL so phone scanners open it (typically in a new browser tab/session)
    qrDataUrl.value = await QRCode.toDataURL(targetUrl.value, {
      width: 224,
      margin: 1,
      errorCorrectionLevel: 'M',
      color: {
        dark: '#1a3a4a',
        light: '#ffffff',
      },
    });
  } catch (e) {
    qrDataUrl.value = '';
  }
}

onMounted(renderQr);
watch(targetUrl, renderQr);
</script>

<style scoped>
.scan-me-qr {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  width: fit-content;
  position: relative;
  z-index: 2;
  pointer-events: none;
  user-select: none;
}

.scan-me-qr__frame {
  position: relative;
  width: 120px;
  height: 120px;
  border-radius: 20px;
  padding: 9px;
  background:
    linear-gradient(#fff, #fff) padding-box,
    linear-gradient(135deg, #03a4ed 0%, #33c1ff 45%, #ff695f 100%) border-box;
  border: 2px solid transparent;
  box-shadow:
    0 12px 28px rgba(3, 164, 237, 0.18),
    0 4px 12px rgba(255, 105, 95, 0.12);
  overflow: hidden;
}

.scan-me-qr__glow {
  position: absolute;
  inset: -40%;
  background: conic-gradient(from 180deg, transparent 40%, rgba(3, 164, 237, 0.2), transparent 70%);
  animation: scan-me-spin 8s linear infinite;
  pointer-events: none;
}

.scan-me-qr__code,
.scan-me-qr__placeholder {
  position: relative;
  z-index: 1;
  width: 100%;
  height: 100%;
  display: block;
  border-radius: 12px;
  background: #fff;
}

.scan-me-qr__placeholder {
  background: linear-gradient(135deg, #f4fbff, #fff6f7);
}

.scan-me-qr__hint {
  font-size: 13px;
  font-weight: 600;
  color: #03a4ed;
  letter-spacing: 0.02em;
}

@keyframes scan-me-spin {
  to {
    transform: rotate(360deg);
  }
}

@media (prefers-reduced-motion: reduce) {
  .scan-me-qr__glow {
    animation: none;
  }
}

@media (max-width: 991px) {
  .scan-me-qr__frame {
    width: 100px;
    height: 100px;
  }
}
</style>
