<template>
  <div class="feature-demo" :style="{ '--accent': accent }">
    <img class="feature-demo__image" :src="imageSrc" :alt="label" loading="lazy" />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { img } from '../images';

const props = defineProps({
  scene: { type: String, default: '' },
  accent: { type: String, default: '#03a4ed' },
  label: { type: String, default: 'Feature preview' },
  image: { type: String, default: '' },
});

const imageSrc = computed(() => {
  if (!props.image) {
    return img(`feature-${props.scene || 'loaders'}.jpg`);
  }
  if (props.image.startsWith('/') || props.image.startsWith('http')) {
    return props.image;
  }
  return img(props.image);
});
</script>

<style scoped>
.feature-demo {
  --accent: #03a4ed;
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  background: linear-gradient(145deg, #f4fbff 0%, #fff6f7 100%);
  aspect-ratio: 4 / 3;
}

.feature-demo__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.45s ease;
}

.feature-demo:hover .feature-demo__image {
  transform: scale(1.04);
}
</style>
