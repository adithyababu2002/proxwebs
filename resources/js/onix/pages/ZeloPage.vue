<template>
  <div class="inner-page zelo-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>{{ zeloIntro.eyebrow }}</h6>
              <h2>{{ zeloIntro.pageTitle }}</h2>
              <p>{{ zeloIntro.pageLead }}</p>
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
              <h2>What <em>Zelo</em> can do</h2>
              <p>
                From first draft to polished publish, Zelo is built into the CMS workflow — not bolted on as a separate
                chat window you copy-paste from.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6" v-for="feature in zeloFeatures" :key="feature.id">
            <article class="zelo-card">
              <div class="zelo-card-image">
                <img :src="img(feature.image)" :alt="feature.title" />
              </div>
              <h3>{{ feature.title }}</h3>
              <span>{{ feature.summary }}</span>
              <p>{{ feature.body }}</p>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>See Zelo on a live demo</h2>
            <p>We will walk through prompt-to-publish, image generation, SEO assist, and role-safe editing.</p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Request a Demo</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/services">View Services</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { img } from '../images';
import { zeloIntro, zeloFeatures } from '../content/zelo';

onMounted(() => {
  window.scrollTo(0, 0);
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
.zelo-card p,
.page-cta p {
  color: #7a7a7a;
  line-height: 1.95;
  font-size: 16px;
}

.page-section {
  margin-top: 0;
  padding: 60px 0;
}

.section-heading h2 {
  margin-bottom: 20px;
}

.section-heading p {
  margin-bottom: 36px;
}

.zelo-card {
  background: #fff;
  border-radius: 20px;
  padding: 18px 18px 24px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
  height: calc(100% - 24px);
  margin-bottom: 24px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.zelo-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px rgba(3, 164, 237, 0.12);
}

.zelo-card-image {
  border-radius: 16px;
  overflow: hidden;
  margin-bottom: 16px;
  aspect-ratio: 4 / 3;
  background: linear-gradient(145deg, #f4fbff 0%, #fff6f7 100%);
}

.zelo-card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.35s ease;
}

.zelo-card:hover .zelo-card-image img {
  transform: scale(1.04);
}

.zelo-card h3 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 6px;
  color: #2a2a2a;
}

.zelo-card span {
  display: block;
  color: #03a4ed;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 10px;
}

.page-cta h2 {
  font-size: 34px;
  font-weight: 700;
  margin-bottom: 16px;
}

.page-cta-buttons {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 28px;
}

@media (max-width: 991px) {
  .page-banner {
    padding: 120px 0 40px;
  }

  .page-section {
    padding: 50px 0;
  }

  .page-banner-content h2 {
    font-size: 32px;
  }
}
</style>
