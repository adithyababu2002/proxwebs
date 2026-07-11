<template>
  <div class="inner-page team-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>{{ teamIntro.eyebrow }}</h6>
              <h2>{{ teamIntro.pageTitle }}</h2>
              <p>{{ teamIntro.pageLead }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1" v-for="member in teamMembers" :key="member.id">
            <article class="team-profile" :id="member.id">
              <div class="row align-items-center">
                <div class="col-lg-4">
                  <div class="team-profile-photo">
                    <img :src="teamImage(member)" :alt="member.name" />
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="team-profile-body">
                    <span class="team-role">{{ member.role }}</span>
                    <h3>{{ member.name }}</h3>
                    <p>{{ member.bio }}</p>
                    <ul class="team-focus">
                      <li v-for="item in member.focus || []" :key="item">{{ item }}</li>
                    </ul>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>How we <em>work</em></h2>
              <p>
                We stay close to the people who publish every day — marketers, operators, and founders — and turn their
                bottlenecks into product improvements.
              </p>
            </div>
          </div>
        </div>
        <div class="row work-grid">
          <div class="col-lg-4" v-for="item in workPrinciples" :key="item.title">
            <div class="work-card">
              <h4>{{ item.title }}</h4>
              <p>{{ item.body }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>Want to work with us — or join us?</h2>
            <p>
              Request a product demo, or reach out if you care about AI, publishing tools, and thoughtful product craft.
            </p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Contact Us</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/about">About the Product</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { teamImage } from '../images';
import { fetchTeamMembers, teamIntro } from '../content/teamApi';

const teamMembers = ref([]);

const workPrinciples = [
  {
    title: 'Customer-led roadmap',
    body: 'We prioritize features that remove real publishing friction — not novelty for its own sake.',
  },
  {
    title: 'AI with guardrails',
    body: 'Generation should accelerate work while permissions, review, and brand judgment stay human-owned.',
  },
  {
    title: 'Ship, learn, refine',
    body: 'We release in focused cycles, watch how teams use the dashboard, and tighten the workflow continuously.',
  },
];

onMounted(async () => {
  window.scrollTo(0, 0);
  teamMembers.value = await fetchTeamMembers();
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
.team-profile-body p,
.work-card p,
.page-cta p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.page-section {
  margin-top: 0;
  padding: 60px 0;
}

.page-section--muted {
  background: #f8fbfd;
}

.section-heading h2 {
  margin-bottom: 20px;
}

.team-profile {
  background: #fff;
  border-radius: 24px;
  padding: 32px;
  margin-bottom: 28px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.team-profile-photo {
  border-radius: 20px;
  overflow: hidden;
  aspect-ratio: 1 / 1;
  border: 1px solid #000;
}

.team-profile-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.team-role {
  display: inline-block;
  color: #03a4ed;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin-bottom: 10px;
}

.team-profile-body h3 {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 14px;
  color: #2a2a2a;
}

.team-focus {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  list-style: none;
  margin: 22px 0 0;
  padding: 0;
}

.team-focus li {
  background: #f3fff8;
  border: 1px solid #d6f5e4;
  color: #2a2a2a;
  border-radius: 999px;
  padding: 8px 14px;
  font-size: 13px;
  font-weight: 500;
}

.work-grid {
  margin-top: 20px;
}

.work-card {
  background: #fff;
  border-radius: 20px;
  padding: 28px 24px;
  height: 100%;
  margin-bottom: 24px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.work-card h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 12px;
  color: #2a2a2a;
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

  .team-profile-photo {
    margin-bottom: 24px;
  }

  .team-profile-body h3 {
    font-size: 24px;
  }
}
</style>
