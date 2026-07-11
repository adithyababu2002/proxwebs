<template>
  <div class="inner-page features-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content wow fadeInUp" data-wow-duration="0.7s">
              <h6>{{ featuresIntro.eyebrow }}</h6>
              <h2>{{ featuresIntro.pageTitle }}</h2>
              <p>{{ featuresIntro.pageLead }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>Explore every <em>capability</em></h2>
              <p>
                Each card includes a feature illustration, five key highlights, and a Read more link to the full detail
                page.
              </p>
            </div>
          </div>
        </div>

        <div class="row feature-grid">
          <div
            class="col-lg-4 col-md-6"
            v-for="(feature, index) in features"
            :key="feature.id"
          >
            <article
              class="feature-card wow fadeInUp"
              :data-wow-delay="`${(index % 3) * 0.1}s`"
              data-wow-duration="0.65s"
            >
              <FeatureDemo
                :scene="feature.demo"
                :accent="feature.accent"
                :label="feature.title"
                :image="feature.image"
              />
              <div class="feature-card-body">
                <h3>{{ feature.title }}</h3>
                <p class="feature-summary">{{ feature.summary }}</p>
                <ul class="feature-points">
                  <li v-for="point in feature.points.slice(0, 5)" :key="point">{{ point }}</li>
                </ul>
                <RouterLink class="feature-readmore" :to="`/features/${feature.slug}`">
                  Read more
                  <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </RouterLink>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row align-items-center highlight-strip">
          <div class="col-lg-7">
            <div class="section-heading text-start">
              <h2>Design system + <span>AI</span> in one CMS</h2>
              <p>
                Select loaders, fonts, website templates, and login templates. Customize template colors. Then use
                generative AI to create content and images — all without leaving the admin.
              </p>
            </div>
          </div>
          <div class="col-lg-5">
            <ul class="feature-pillars">
              <li>Multiple loaders</li>
              <li>Font library</li>
              <li>Website templates</li>
              <li>Login templates</li>
              <li>Color customization</li>
              <li>Generative AI</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>Want a live walkthrough of these features?</h2>
            <p>We will show loaders, templates, color theming, and AI content generation on a real demo site.</p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Request a Demo</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/zelo">Meet Zelo</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, nextTick } from 'vue';
import FeatureDemo from '../components/FeatureDemo.vue';
import { featuresIntro, features } from '../content/features';

onMounted(async () => {
  window.scrollTo(0, 0);
  await nextTick();
  if (window.WOW) {
    new window.WOW({ animateClass: 'animated', offset: 40, mobile: true }).init();
  }
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

.page-banner-content p,
.section-heading p,
.page-cta p,
.feature-summary {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.features-page .section-heading {
  margin-bottom: 48px;
}

.features-page .section-heading h2 {
  margin-bottom: 18px;
}

.features-page .section-heading p {
  margin-top: 0;
  margin-bottom: 0;
}

.feature-grid {
  margin-top: 12px;
}

.feature-grid > [class*='col-'] {
  margin-bottom: 28px;
  display: flex;
}

.feature-card {
  width: 100%;
  background: #fff;
  border-radius: 22px;
  overflow: hidden;
  box-shadow: 0 10px 28px rgba(15, 40, 60, 0.08);
  border: 1px solid #eef5fa;
  display: flex;
  flex-direction: column;
  transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 40px rgba(15, 40, 60, 0.14);
}

.feature-card-body {
  padding: 22px 22px 24px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.feature-card h3 {
  font-size: 20px;
  font-weight: 700;
  color: #2a2a2a;
  margin: 0 0 8px;
}

.feature-summary {
  margin: 0 0 14px;
  font-size: 14px;
  line-height: 1.65;
}

.feature-points {
  list-style: none;
  margin: 0 0 18px;
  padding: 0;
  flex: 1;
}

.feature-points li {
  position: relative;
  padding: 0 0 10px 18px;
  font-size: 13.5px;
  line-height: 1.55;
  color: #555;
}

.feature-points li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 7px;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #03a4ed;
}

.feature-points li:nth-child(even)::before {
  background: #ff695f;
}

.feature-readmore {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 700;
  color: #03a4ed;
  text-decoration: none;
  margin-top: auto;
  transition: gap 0.25s ease, color 0.25s ease;
}

.feature-readmore:hover {
  color: #ff695f;
  gap: 12px;
}

.feature-pillars {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.feature-pillars li {
  background: #fff;
  border: 1px solid #e8f6fc;
  border-radius: 14px;
  padding: 14px 16px;
  font-size: 14px;
  font-weight: 600;
  color: #2a2a2a;
  box-shadow: 0 6px 16px rgba(3, 164, 237, 0.06);
  animation: pillarFloat 3.5s ease-in-out infinite;
}

.feature-pillars li:nth-child(2) {
  animation-delay: 0.2s;
}
.feature-pillars li:nth-child(3) {
  animation-delay: 0.4s;
}
.feature-pillars li:nth-child(4) {
  animation-delay: 0.1s;
}
.feature-pillars li:nth-child(5) {
  animation-delay: 0.3s;
}
.feature-pillars li:nth-child(6) {
  animation-delay: 0.5s;
}

.page-cta h2 {
  font-size: 34px;
  font-weight: 700;
  margin-bottom: 16px;
  color: #2a2a2a;
}

.page-cta-buttons {
  display: flex;
  gap: 14px;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 24px;
}

@keyframes pillarFloat {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-4px);
  }
}

@media (max-width: 991px) {
  .page-banner-content h2,
  .page-cta h2 {
    font-size: 32px;
  }

  .highlight-strip {
    gap: 24px 0;
  }
}
</style>
