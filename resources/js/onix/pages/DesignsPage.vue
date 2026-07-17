<template>
  <div class="inner-page designs-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content wow fadeInUp" data-wow-duration="0.7s">
              <h6>{{ designsIntro.eyebrow }}</h6>
              <h2>{{ designsIntro.pageTitle }}</h2>
              <p>{{ designsIntro.pageLead }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="page-section designs-hero-strip">
      <div class="container">
        <div class="designs-selector-shell">
          <span class="selector-label">Quick preview</span>
          <div class="designs-name-pills" role="group" aria-label="Template names">
            <button
              v-for="design in designs"
              :key="`pill-${design.id}`"
              type="button"
              class="design-name-pill"
              :class="{ active: previewDesign?.id === design.id }"
              :style="{ '--design-accent': design.accent }"
              @click="openPreview(design)"
            >
              {{ design.name }}
            </button>
          </div>
          <p class="designs-pill-hint">Click a name to preview that design.</p>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>Choose a <em>look</em>, preview it live</h2>
              <p>
                Eight ready-made website templates, each with its own color system, navbar, section styling, and footer.
                Open any design to see the full-page preview.
              </p>
            </div>
          </div>
        </div>

        <div class="row designs-grid">
          <div
            class="col-lg-3 col-md-6"
            v-for="(design, index) in designs"
            :key="design.id"
          >
            <article
              class="design-card wow fadeInUp"
              :data-wow-delay="`${(index % 4) * 0.08}s`"
              data-wow-duration="0.65s"
              :style="{ '--design-accent': design.accent }"
            >
              <button
                type="button"
                class="design-card-media"
                :aria-label="`Preview ${design.name}`"
                @click="openPreview(design)"
              >
                <img :src="img(design.image)" :alt="`${design.name} template preview`" loading="lazy" />
                <span class="design-card-overlay">
                  <span class="design-preview-btn">Preview</span>
                </span>
              </button>
              <div class="design-card-body">
                <button type="button" class="design-card-name" @click="openPreview(design)">
                  {{ design.name }}
                </button>
                <span class="design-card-tagline">{{ design.tagline }}</span>
                <p>{{ design.description }}</p>
                <button type="button" class="design-card-link" @click="openPreview(design)">
                  Preview design
                  <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </button>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>Need a custom design for your brand?</h2>
            <p>Tell us about your preferred look and feel. We can restyle these templates or build something unique.</p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Contact Us</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/features">Explore Features</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Teleport to="body">
      <div
        v-if="previewDesign"
        class="design-preview-modal"
        role="dialog"
        aria-modal="true"
        :aria-label="`${previewDesign.name} design preview`"
        @keydown.esc="closePreview"
      >
        <div class="design-preview-backdrop" @click="closePreview"></div>
        <div class="design-preview-panel" :style="{ '--design-accent': previewDesign.accent }">
          <header class="design-preview-header">
            <div class="design-preview-titles">
              <h3>{{ previewDesign.name }}</h3>
              <span>{{ previewDesign.tagline }}</span>
            </div>
            <div class="design-preview-actions">
              <button
                type="button"
                class="design-nav-btn"
                :disabled="previewIndex <= 0"
                aria-label="Previous design"
                @click="showAdjacent(-1)"
              >
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
              </button>
              <button
                type="button"
                class="design-nav-btn"
                :disabled="previewIndex >= designs.length - 1"
                aria-label="Next design"
                @click="showAdjacent(1)"
              >
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
              </button>
              <button type="button" class="design-close-btn" aria-label="Close preview" @click="closePreview">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
            </div>
          </header>
          <div class="design-preview-body">
            <img
              :src="img(previewDesign.image)"
              :alt="`${previewDesign.name} full page preview`"
            />
          </div>
          <footer class="design-preview-footer">
            <p>{{ previewDesign.description }}</p>
            <div class="design-preview-pills">
              <button
                v-for="design in designs"
                :key="`modal-pill-${design.id}`"
                type="button"
                class="design-name-pill compact"
                :class="{ active: previewDesign.id === design.id }"
                :style="{ '--design-accent': design.accent }"
                @click="openPreview(design)"
              >
                {{ design.name }}
              </button>
            </div>
          </footer>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { img } from '../images';
import { designs, designsIntro, getDesignById } from '../content/designs';

const route = useRoute();
const router = useRouter();
const previewDesign = ref(null);

const previewIndex = computed(() =>
  previewDesign.value ? designs.findIndex((d) => d.id === previewDesign.value.id) : -1
);

function openPreview(design) {
  previewDesign.value = design;
  document.body.style.overflow = 'hidden';
  if (route.query.preview !== design.id) {
    router.replace({ query: { ...route.query, preview: design.id } });
  }
}

function closePreview() {
  previewDesign.value = null;
  document.body.style.overflow = '';
  if (route.query.preview) {
    const query = { ...route.query };
    delete query.preview;
    router.replace({ query });
  }
}

function showAdjacent(step) {
  const next = designs[previewIndex.value + step];
  if (next) openPreview(next);
}

function syncPreviewFromRoute() {
  const id = route.query.preview;
  if (typeof id === 'string') {
    const found = getDesignById(id);
    if (found) {
      previewDesign.value = found;
      document.body.style.overflow = 'hidden';
      return;
    }
  }
  if (previewDesign.value) {
    previewDesign.value = null;
    document.body.style.overflow = '';
  }
}

watch(() => route.query.preview, syncPreviewFromRoute);

onMounted(async () => {
  window.scrollTo(0, 0);
  syncPreviewFromRoute();
  await nextTick();
  if (window.WOW) {
    new window.WOW({ live: false }).init();
  }
});

onUnmounted(() => {
  document.body.style.overflow = '';
});
</script>

<style scoped>
.page-banner {
  padding: 130px 0 50px;
  background: linear-gradient(135deg, #f4fbff 0%, #fff6f7 55%, #ffffff 100%);
}

.page-banner-content h6 {
  color: #03a4ed;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 18px;
}

.page-banner-content h2 {
  font-size: 42px;
  font-weight: 700;
  line-height: 1.25;
  margin-bottom: 22px;
  color: #2a2a2a;
}

.page-banner-content p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.designs-hero-strip {
  padding-top: 24px;
  padding-bottom: 8px;
}

.designs-selector-shell {
  position: relative;
  padding: 26px 28px 22px;
  border-radius: 8px;
  background:
    linear-gradient(135deg, rgba(3, 164, 237, 0.12), rgba(255, 105, 95, 0.08)),
    #fff;
  border: 1px solid rgba(3, 164, 237, 0.12);
  box-shadow: 0 14px 34px rgba(3, 40, 70, 0.08);
}

.selector-label {
  display: block;
  margin-bottom: 14px;
  text-align: center;
  color: #03a4ed;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.designs-name-pills {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
}

.design-name-pill {
  appearance: none;
  border: 1px solid rgba(3, 164, 237, 0.35);
  background: #fff;
  color: #2a2a2a;
  font-size: 14px;
  font-weight: 600;
  min-height: 42px;
  padding: 9px 18px;
  border-radius: 999px;
  cursor: pointer;
  transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.design-name-pill:hover,
.design-name-pill.active {
  background: var(--design-accent, #03a4ed);
  border-color: var(--design-accent, #03a4ed);
  color: #fff;
  transform: translateY(-1px);
}

.design-name-pill.compact {
  padding: 7px 14px;
  font-size: 12px;
}

.designs-pill-hint {
  text-align: center;
  margin: 14px 0 0;
  color: #7a7a7a;
  font-size: 14px;
}

.designs-grid {
  --bs-gutter-x: 1.5rem;
  --bs-gutter-y: 1.75rem;
  margin-top: 10px;
}

.design-card {
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid rgba(3, 164, 237, 0.1);
  box-shadow: 0 10px 26px rgba(3, 40, 70, 0.08);
  height: 100%;
  display: flex;
  flex-direction: column;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.design-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 18px 42px rgba(3, 40, 70, 0.15);
}

.design-card-media {
  position: relative;
  display: block;
  width: 100%;
  padding: 0;
  border: 0;
  background: linear-gradient(145deg, #e8f4fb, #f9fbff);
  cursor: pointer;
  overflow: hidden;
  aspect-ratio: 4 / 5;
}

.design-card-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
  display: block;
  transition: transform 0.35s ease;
}

.design-card:hover .design-card-media img {
  transform: scale(1.04);
}

.design-card-overlay {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(180deg, rgba(3, 40, 70, 0.05) 0%, rgba(3, 40, 70, 0.68) 100%);
  opacity: 0;
  transition: opacity 0.25s ease;
}

.design-card:hover .design-card-overlay {
  opacity: 1;
}

.design-preview-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 22px;
  border-radius: 999px;
  background: var(--design-accent, #ff695f);
  color: #fff;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.02em;
}

.design-card-body {
  padding: 20px 20px 22px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.design-card-name {
  appearance: none;
  border: 0;
  background: transparent;
  padding: 0;
  margin: 0 0 6px;
  text-align: left;
  font-size: 21px;
  font-weight: 700;
  color: #2a2a2a;
  cursor: pointer;
  transition: color 0.2s ease;
}

.design-card-name:hover {
  color: var(--design-accent, #03a4ed);
}

.design-card-tagline {
  display: block;
  color: var(--design-accent, #03a4ed);
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 10px;
}

.design-card-body p {
  margin: 0;
  color: #7a7a7a;
  font-size: 14px;
  line-height: 1.7;
  flex: 1;
}

.design-card-link {
  appearance: none;
  border: 0;
  background: transparent;
  padding: 0;
  margin-top: 16px;
  text-align: left;
  color: var(--design-accent, #03a4ed);
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
}

.design-card-link:hover {
  color: #0284c7;
  text-decoration: underline;
}

.design-card-link i {
  margin-left: 6px;
  font-size: 12px;
}

.design-preview-modal {
  position: fixed;
  inset: 0;
  z-index: 10050;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
}

.design-preview-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(8, 18, 32, 0.72);
  backdrop-filter: blur(4px);
}

.design-preview-panel {
  position: relative;
  z-index: 1;
  width: min(1180px, 100%);
  max-height: calc(100vh - 48px);
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35);
  border-top: 4px solid var(--design-accent, #03a4ed);
  animation: designPreviewIn 0.28s ease;
}

@keyframes designPreviewIn {
  from {
    opacity: 0;
    transform: translateY(16px) scale(0.98);
  }
  to {
    opacity: 1;
    transform: none;
  }
}

.design-preview-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 18px 22px;
  border-bottom: 1px solid rgba(3, 164, 237, 0.12);
  flex-shrink: 0;
}

.design-preview-titles h3 {
  margin: 0;
  font-size: 24px;
  font-weight: 700;
  color: #2a2a2a;
}

.design-preview-titles span {
  color: var(--design-accent, #03a4ed);
  font-size: 13px;
  font-weight: 600;
}

.design-preview-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}

.design-nav-btn,
.design-close-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1px solid rgba(3, 164, 237, 0.2);
  background: #f4fbff;
  color: #2a2a2a;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.design-nav-btn:hover:not(:disabled),
.design-close-btn:hover {
  background: #03a4ed;
  border-color: #03a4ed;
  color: #fff;
}

.design-nav-btn:disabled {
  opacity: 0.35;
  cursor: not-allowed;
}

.design-close-btn {
  background: #ff695f;
  border-color: #ff695f;
  color: #fff;
}

.design-close-btn:hover {
  background: #e85a51;
  border-color: #e85a51;
}

.design-preview-body {
  overflow: auto;
  flex: 1;
  background: #0f172a;
  min-height: 0;
}

.design-preview-body img {
  width: min(100%, 1120px);
  margin: 0 auto;
  display: block;
}

.design-preview-footer {
  padding: 16px 22px 20px;
  border-top: 1px solid rgba(3, 164, 237, 0.12);
  flex-shrink: 0;
  background: #fff;
}

.design-preview-footer p {
  margin: 0 0 14px;
  color: #7a7a7a;
  font-size: 14px;
  line-height: 1.6;
}

.design-preview-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.designs-page .page-cta h2 {
  font-size: 34px;
  font-weight: 700;
  margin-bottom: 14px;
  line-height: 1.25;
}

.designs-page .page-cta p {
  max-width: 820px;
  margin: 0 auto;
  line-height: 1.75;
}

.designs-page .page-cta-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 16px;
  margin-top: 28px;
}

.designs-page .page-cta-buttons > div {
  margin: 0;
}

@media (max-width: 767px) {
  .page-banner {
    padding: 120px 0 40px;
  }

  .page-banner-content h2 {
    font-size: 32px;
  }

  .design-preview-modal {
    padding: 12px;
  }

  .design-preview-panel {
    max-height: calc(100vh - 24px);
    border-radius: 18px;
  }

  .design-preview-header {
    padding: 14px 16px;
  }

  .design-preview-titles h3 {
    font-size: 20px;
  }

  .design-preview-footer {
    padding: 14px 16px 16px;
  }

  .design-card-media {
    aspect-ratio: 4 / 5;
  }

  .designs-page .page-cta h2 {
    line-height: 1.32;
  }

  .designs-page .page-cta p {
    line-height: 1.7;
  }

  .designs-page .page-cta-buttons {
    flex-direction: column;
    align-items: center;
    gap: 16px;
    margin-top: 24px;
  }
}
</style>
