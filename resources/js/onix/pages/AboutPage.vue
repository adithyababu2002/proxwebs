<template>
  <div class="inner-page about-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>About Us</h6>
              <h2>We built a CMS so teams can publish without waiting on developers</h2>
              <p>
                Traditional website updates are slow, expensive, and locked behind technical skills. Our AI-native CMS
                gives marketing and operations teams a visual workspace to write, design, and publish — with an AI
                assistant that handles the heavy lifting.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="page-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="page-image">
              <img :src="img('about-left-image.png')" alt="Team collaborating on website content" />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="section-heading text-start">
              <h2>Our <em>story</em></h2>
              <p>
                We started from a simple observation: every meaningful website change — a headline tweak, a new service
                page, a fresh hero image — still required a developer ticket. Content teams knew what they wanted to say,
                but the tools in front of them were either too rigid, too technical, or too slow.
              </p>
              <p>
                At the same time, AI made it possible to draft strong marketing copy and generate on-brand visuals in
                seconds. What was missing was a product that connected those capabilities to a real publishing workflow:
                pages, sections, menus, templates, permissions, and instant go-live.
              </p>
              <p>
                That is the product we built — a no-code, AI-native content management system designed for speed,
                quality, and control.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>The <em>challenge</em> we set out to solve</h2>
              <p>
                Website ownership should not mean endless handoffs. These are the friction points we hear from teams
                every week — and the reason our CMS exists.
              </p>
            </div>
          </div>
        </div>
        <div class="row challenge-grid g-4">
          <div class="col-lg-4 col-md-6" v-for="item in challenges" :key="item.title">
            <div class="info-card info-card--challenge">
              <h4>{{ item.title }}</h4>
              <p>{{ item.body }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>Our <span>solution</span></h2>
              <p>
                One admin dashboard. Visual editing. AI that writes and illustrates. Role-based access so the right
                people can publish safely — without opening a ticket.
              </p>
            </div>
          </div>
        </div>
        <div class="row solution-grid g-4">
          <div class="col-lg-6" v-for="item in solutions" :key="item.title">
            <div class="info-card info-card--solution">
              <h4>{{ item.title }}</h4>
              <p>{{ item.body }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-heading">
              <h2>What we <em>believe</em></h2>
            </div>
          </div>
        </div>
        <div class="row belief-grid">
          <div class="col-lg-4" v-for="item in beliefs" :key="item.title">
            <div class="belief-item">
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
            <h2>Ready to see it in action?</h2>
            <p>
              Whether you manage one brand site or a portfolio of properties, we can walk you through the workflow —
              from first prompt to published page.
            </p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Request a Demo</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/services">Explore Services</RouterLink>
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

const challenges = [
  {
    title: 'Developer bottleneck',
    body: 'Every text or image change waits in a queue. Marketing momentum dies while tickets sit open for days or weeks.',
  },
  {
    title: 'Copy that takes forever',
    body: 'Writing clear, on-brand marketing content requires time and skill most teams do not have spare capacity for.',
  },
  {
    title: 'Image busywork',
    body: 'Finding, cropping, and resizing assets for every section is tedious — and easy to get wrong across breakpoints.',
  },
  {
    title: 'Slow turnaround',
    body: 'Campaigns and seasonal updates miss their window because publishing still depends on engineering availability.',
  },
  {
    title: 'Rising maintenance cost',
    body: 'Ongoing development for routine content work drains budget that should go toward growth, not small edits.',
  },
  {
    title: 'Unsafe delegation',
    body: 'Without role-based controls, giving non-technical staff access feels risky — so ownership stays centralized.',
  },
];

const solutions = [
  {
    title: 'Visual editing for everyone',
    body: 'Staff manage pages, menus, sections, and design from a single clean dashboard. No code, no deploy pipeline for everyday updates.',
  },
  {
    title: 'AI that writes and polishes',
    body: 'Describe what you need and generate ready-to-use copy — or enhance what you already have with rewrite, shorten, and expand tools.',
  },
  {
    title: 'AI images that fit the layout',
    body: 'Generate visuals on demand and auto-fit uploads to each slot so pages look intentional without a design handoff.',
  },
  {
    title: 'Instant, secure publishing',
    body: 'Edits go live in real time. Role and section-level permissions keep content safe while teams move faster.',
  },
];

const beliefs = [
  {
    title: 'Speed without chaos',
    body: 'Publishing should be fast, but never reckless. Permissions and clear workflows keep quality high as more people contribute.',
  },
  {
    title: 'AI as a teammate',
    body: 'AI should remove blank-page friction and busywork — not replace your brand voice or your judgment.',
  },
  {
    title: 'One place to run the site',
    body: 'Pages, templates, menus, contacts, and content tools belong in one dashboard so teams stop juggling disconnected systems.',
  },
];

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
.info-card p,
.belief-item p,
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

.page-image img {
  width: 100%;
  height: auto;
}

.section-heading.text-start {
  text-align: left !important;
}

.section-heading h2 {
  margin-bottom: 20px;
}

.section-heading p + p {
  margin-top: 16px;
}

.challenge-grid,
.solution-grid,
.belief-grid {
  margin-top: 20px;
}

.challenge-grid {
  --bs-gutter-x: 1.5rem;
  --bs-gutter-y: 1.5rem;
}

.solution-grid {
  --bs-gutter-x: 1.5rem;
  --bs-gutter-y: 1.5rem;
}

.challenge-grid .info-card,
.solution-grid .info-card {
  margin-bottom: 0;
}

.info-card {
  border-radius: 20px;
  padding: 28px 24px;
  height: 100%;
  margin-bottom: 24px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
  background: #fff;
}

.info-card h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 12px;
}

.info-card--challenge {
  background: #fff6f7;
  border: 1px solid #ffe3e6;
}

.info-card--challenge h4 {
  color: #ff695f;
}

.info-card--solution {
  background: #f3fff8;
  border: 1px solid #d6f5e4;
}

.info-card--solution h4 {
  color: #03a4ed;
}

.belief-item {
  text-align: center;
  padding: 10px 12px 20px;
}

.belief-item h4 {
  font-size: 20px;
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

  .page-image {
    margin-bottom: 28px;
  }
}
</style>
