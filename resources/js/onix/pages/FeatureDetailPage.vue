<template>
  <div class="inner-page feature-detail-page" v-if="feature">
    <div class="page-banner">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="page-banner-content wow fadeInLeft" data-wow-duration="0.7s">
              <h6>Feature detail</h6>
              <h2>{{ feature.title }}</h2>
              <p>{{ feature.body }}</p>
              <div class="banner-actions">
                <div class="main-blue-button-hover">
                  <RouterLink to="/contact">Request a Demo</RouterLink>
                </div>
                <RouterLink class="back-link" to="/features">
                  <i class="fa fa-arrow-left" aria-hidden="true"></i>
                  All features
                </RouterLink>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="detail-demo-wrap wow fadeInRight" data-wow-duration="0.7s">
              <FeatureDemo
                :scene="feature.demo"
                :accent="feature.accent"
                :label="feature.title"
                :image="feature.image"
              />
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
              <h2>What you <em>get</em></h2>
              <p>{{ feature.summary }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4" v-for="(item, index) in feature.highlights" :key="item.title">
            <article
              class="detail-highlight wow fadeInUp"
              :data-wow-delay="`${index * 0.1}s`"
              data-wow-duration="0.6s"
            >
              <span>{{ String(index + 1).padStart(2, '0') }}</span>
              <h3>{{ item.title }}</h3>
              <p>{{ item.text }}</p>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row align-items-start">
          <div class="col-lg-6">
            <div class="section-heading text-start">
              <h2>Full capability <span>list</span></h2>
              <p>Everything included in this feature — beyond the five highlights on the cards page.</p>
            </div>
            <ul class="detail-points">
              <li v-for="point in feature.points" :key="point">{{ point }}</li>
            </ul>
          </div>
          <div class="col-lg-5 offset-lg-1">
            <div class="detail-steps wow fadeInUp" data-wow-duration="0.65s">
              <h3>How it works</h3>
              <ol>
                <li v-for="(step, index) in feature.steps" :key="step.title">
                  <strong>{{ index + 1 }}. {{ step.title }}</strong>
                  <span>{{ step.text }}</span>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section" v-if="related.length">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>Related <em>features</em></h2>
              <p>Continue exploring the rest of the Proxwebs CMS toolkit.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4" v-for="item in related" :key="item.id">
            <RouterLink class="related-card" :to="`/features/${item.slug}`">
              <FeatureDemo
                :scene="item.demo"
                :accent="item.accent"
                :label="item.title"
                :image="item.image"
              />
              <h4>{{ item.title }}</h4>
              <p>{{ item.summary }}</p>
              <span>View details</span>
            </RouterLink>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>See {{ feature.title }} in a live demo</h2>
            <p>We will walk through this feature end to end and show how it fits your publishing workflow.</p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Get in Touch</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/features">Back to Features</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="inner-page feature-detail-page" v-else>
    <div class="page-banner">
      <div class="container">
        <div class="page-banner-content text-center">
          <h6>Not found</h6>
          <h2>This feature page does not exist</h2>
          <p>Choose another capability from the features list.</p>
          <div class="main-blue-button-hover" style="display: inline-block; margin-top: 10px">
            <RouterLink to="/features">Browse features</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, nextTick, watch } from 'vue';
import { useRoute } from 'vue-router';
import FeatureDemo from '../components/FeatureDemo.vue';
import { getFeatureBySlug, getRelatedFeatures } from '../content/features';

const route = useRoute();

const feature = computed(() => getFeatureBySlug(route.params.slug));
const related = computed(() => (feature.value ? getRelatedFeatures(feature.value.slug) : []));

function refreshAnimations() {
  window.scrollTo(0, 0);
  nextTick(() => {
    if (window.WOW) {
      new window.WOW({ animateClass: 'animated', offset: 40, mobile: true }).init();
    }
  });
}

onMounted(refreshAnimations);
watch(() => route.params.slug, refreshAnimations);
</script>

<style scoped>
.page-banner {
  padding: 130px 0 60px;
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
.detail-highlight p,
.detail-steps span,
.related-card p,
.page-cta p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.banner-actions {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-wrap: wrap;
  margin-top: 8px;
}

.back-link {
  color: #03a4ed;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.back-link:hover {
  color: #ff695f;
}

.detail-demo-wrap {
  border-radius: 22px;
  overflow: hidden;
  box-shadow: 0 16px 40px rgba(15, 40, 60, 0.14);
}

.detail-demo-wrap :deep(.feature-demo) {
  aspect-ratio: 16 / 11;
  border-radius: 22px;
}

.detail-highlight {
  background: #fff;
  border: 1px solid #eef5fa;
  border-radius: 20px;
  padding: 28px 24px;
  margin-bottom: 24px;
  box-shadow: 0 10px 24px rgba(15, 40, 60, 0.06);
  height: calc(100% - 24px);
  transition: transform 0.3s ease;
}

.detail-highlight:hover {
  transform: translateY(-6px);
}

.detail-highlight span {
  display: inline-block;
  color: #03a4ed;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.08em;
  margin-bottom: 12px;
}

.detail-highlight h3 {
  font-size: 20px;
  font-weight: 700;
  color: #2a2a2a;
  margin-bottom: 10px;
}

.detail-points {
  list-style: none;
  margin: 10px 0 0;
  padding: 0;
}

.detail-points li {
  position: relative;
  padding: 12px 0 12px 22px;
  border-bottom: 1px solid #eef2f6;
  color: #444;
  line-height: 1.6;
  font-size: 15px;
}

.detail-points li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 19px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #ff695f;
}

.detail-steps {
  background: #fff;
  border-radius: 22px;
  border: 1px solid #ffe3e6;
  padding: 30px 26px;
  box-shadow: 0 12px 28px rgba(255, 105, 95, 0.08);
}

.detail-steps h3 {
  font-size: 22px;
  font-weight: 700;
  color: #2a2a2a;
  margin-bottom: 18px;
}

.detail-steps ol {
  list-style: none;
  margin: 0;
  padding: 0;
  counter-reset: steps;
}

.detail-steps li {
  margin-bottom: 18px;
}

.detail-steps li:last-child {
  margin-bottom: 0;
}

.detail-steps strong {
  display: block;
  color: #2a2a2a;
  font-size: 16px;
  margin-bottom: 4px;
}

.detail-steps span {
  display: block;
  font-size: 14px;
  line-height: 1.65;
}

.related-card {
  display: block;
  text-decoration: none;
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  border: 1px solid #eef5fa;
  box-shadow: 0 10px 24px rgba(15, 40, 60, 0.06);
  margin-bottom: 24px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: calc(100% - 24px);
}

.related-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 34px rgba(15, 40, 60, 0.12);
}

.related-card h4 {
  font-size: 18px;
  font-weight: 700;
  color: #2a2a2a;
  margin: 16px 18px 8px;
}

.related-card p {
  margin: 0 18px 12px;
  font-size: 14px;
  line-height: 1.6;
}

.related-card span {
  display: inline-block;
  margin: 0 18px 18px;
  color: #03a4ed;
  font-weight: 700;
  font-size: 13px;
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

@media (max-width: 991px) {
  .page-banner-content h2,
  .page-cta h2 {
    font-size: 32px;
  }

  .detail-demo-wrap {
    margin-top: 28px;
  }
}
</style>
