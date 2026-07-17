<template>
  <div class="inner-page leaders-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>{{ leadersIntro.eyebrow }}</h6>
              <h2>{{ leadersIntro.pageTitle }}</h2>
              <p>{{ leadersIntro.pageLead }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1" v-for="member in leaderMembers" :key="member.id">
            <article class="leader-profile" :id="member.id">
              <div class="row align-items-center">
                <div class="col-lg-4">
                  <div class="leader-profile-photo">
                    <img :src="teamImage(member)" :alt="member.name" />
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="leader-profile-body">
                    <span class="leader-role">{{ member.role }}</span>
                    <h3>{{ member.name }}</h3>
                    <p>{{ member.shortBio }}</p>
                    <ul class="leader-focus">
                      <li v-for="item in member.focus || []" :key="item">{{ item }}</li>
                    </ul>
                    <RouterLink class="leader-readmore" :to="`/leaders/${member.slug}`">Read more</RouterLink>
                  </div>
                </div>
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
            <h2>Want to work with our leadership team?</h2>
            <p>
              Request a product demo, or reach out to discuss how Proxwebs can support your publishing goals.
            </p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Contact Us</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/team">Meet the Team</RouterLink>
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
import { teamImage } from '../images';
import { leaderMembers, leadersIntro } from '../content/leaders';

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
.leader-profile-body p,
.page-cta p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.page-section {
  margin-top: 0;
  padding: 60px 0;
}

.leader-profile {
  background: #fff;
  border-radius: 28px;
  padding: 40px;
  margin-bottom: 32px;
  box-shadow: 0 0 18px rgba(0, 0, 0, 0.06);
}

.leader-profile-photo {
  border-radius: 24px;
  overflow: hidden;
  aspect-ratio: 1 / 1;
  border: 1px solid #000;
}

.leader-profile-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.leader-role {
  display: inline-block;
  color: #03a4ed;
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin-bottom: 12px;
}

.leader-profile-body h3 {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 16px;
  color: #2a2a2a;
}

.leader-focus {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  list-style: none;
  margin: 24px 0 0;
  padding: 0;
}

.leader-focus li {
  background: #f3fff8;
  border: 1px solid #d6f5e4;
  color: #2a2a2a;
  border-radius: 999px;
  padding: 9px 16px;
  font-size: 13px;
  font-weight: 500;
}

.leader-readmore {
  display: inline-block;
  margin-top: 22px;
  color: #03a4ed;
  font-weight: 600;
  text-decoration: none;
}

.leader-readmore:hover {
  color: #0284c7;
  text-decoration: underline;
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

  .leader-profile {
    padding: 28px;
  }

  .leader-profile-photo {
    margin-bottom: 24px;
  }

  .leader-profile-body h3 {
    font-size: 26px;
  }
}
</style>
