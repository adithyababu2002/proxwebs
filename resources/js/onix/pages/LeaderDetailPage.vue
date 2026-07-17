<template>
  <div class="inner-page leader-detail-page" v-if="leader">
    <div class="page-banner">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <div class="leader-detail-photo">
              <img :src="teamImage(leader)" :alt="leader.name" />
            </div>
          </div>
          <div class="col-lg-7">
            <div class="page-banner-content">
              <h6>Leader profile</h6>
              <span class="leader-role">{{ leader.role }}</span>
              <h2>{{ leader.name }}</h2>
              <p>{{ leader.bio }}</p>
              <div class="banner-actions">
                <div class="main-blue-button-hover">
                  <RouterLink to="/contact">Get in Touch</RouterLink>
                </div>
                <RouterLink class="back-link" to="/leaders">
                  <i class="fa fa-arrow-left" aria-hidden="true"></i>
                  All leaders
                </RouterLink>
              </div>
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
              <h2>Focus <em>areas</em></h2>
              <p>{{ leader.shortBio }}</p>
            </div>
            <ul class="leader-focus">
              <li v-for="item in leader.focus || []" :key="item">{{ item }}</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted" v-if="relatedLeaders.length">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>Other <em>leaders</em></h2>
            </div>
          </div>
        </div>
        <div class="row related-grid">
          <div class="col-lg-6" v-for="member in relatedLeaders" :key="member.id">
            <article class="related-leader-card">
              <div class="related-leader-photo">
                <img :src="teamImage(member)" :alt="member.name" />
              </div>
              <div>
                <span>{{ member.role }}</span>
                <h4>{{ member.name }}</h4>
                <p>{{ member.shortBio }}</p>
                <RouterLink class="leader-readmore" :to="`/leaders/${member.slug}`">Read more</RouterLink>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { teamImage } from '../images';
import { getLeaderBySlug, getRelatedLeaders } from '../content/leaders';

const route = useRoute();
const router = useRouter();

const leader = computed(() => getLeaderBySlug(String(route.params.slug || '')));
const relatedLeaders = computed(() => getRelatedLeaders(String(route.params.slug || '')));

watch(
  () => route.params.slug,
  (slug) => {
    window.scrollTo(0, 0);
    if (!getLeaderBySlug(String(slug || ''))) {
      router.replace('/leaders');
    }
  },
  { immediate: true }
);
</script>

<style scoped>
.page-banner {
  padding: 130px 0 60px;
  background: linear-gradient(135deg, #f4fbff 0%, #fff6f7 55%, #ffffff 100%);
}

.leader-detail-photo {
  border-radius: 28px;
  overflow: hidden;
  aspect-ratio: 1 / 1;
  border: 1px solid #000;
  max-width: 420px;
  margin: 0 auto 30px;
}

.leader-detail-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.page-banner-content h6 {
  color: #03a4ed;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 14px;
}

.leader-role {
  display: inline-block;
  color: #ff695f;
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin-bottom: 12px;
}

.page-banner-content h2 {
  font-size: 40px;
  font-weight: 700;
  line-height: 1.25;
  margin-bottom: 18px;
  color: #2a2a2a;
}

.page-banner-content p,
.section-heading p,
.related-leader-card p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.banner-actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 18px;
  margin-top: 28px;
}

.back-link {
  color: #03a4ed;
  font-weight: 600;
  text-decoration: none;
}

.back-link i {
  margin-right: 8px;
}

.back-link:hover {
  color: #0284c7;
}

.page-section {
  margin-top: 0;
  padding: 60px 0;
}

.page-section--muted {
  background: #f8fbfd;
}

.section-heading h2 {
  margin-bottom: 18px;
}

.leader-focus {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  list-style: none;
  margin: 28px 0 0;
  padding: 0;
  justify-content: center;
}

.leader-focus li {
  background: #f3fff8;
  border: 1px solid #d6f5e4;
  color: #2a2a2a;
  border-radius: 999px;
  padding: 10px 18px;
  font-size: 14px;
  font-weight: 500;
}

.related-grid {
  margin-top: 10px;
  --bs-gutter-y: 1.5rem;
}

.related-leader-card {
  background: #fff;
  border-radius: 24px;
  padding: 24px;
  height: 100%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
  display: flex;
  gap: 18px;
  align-items: flex-start;
}

.related-leader-photo {
  width: 88px;
  height: 88px;
  border-radius: 50%;
  overflow: hidden;
  border: 1px solid #000;
  flex-shrink: 0;
}

.related-leader-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.related-leader-card span {
  display: block;
  color: #03a4ed;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  margin-bottom: 6px;
}

.related-leader-card h4 {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 8px;
  color: #2a2a2a;
}

.leader-readmore {
  display: inline-block;
  margin-top: 10px;
  color: #03a4ed;
  font-weight: 600;
  text-decoration: none;
}

.leader-readmore:hover {
  color: #0284c7;
  text-decoration: underline;
}

@media (max-width: 991px) {
  .page-banner {
    padding: 120px 0 40px;
  }

  .page-banner-content h2 {
    font-size: 32px;
  }

  .related-leader-card {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
}
</style>
