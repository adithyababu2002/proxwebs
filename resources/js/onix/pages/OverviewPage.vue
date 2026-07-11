<template>
  <div class="inner-page overview-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>Project Overview</h6>
              <h2>Proxwebs — AI-native CMS for teams that need to publish fast</h2>
              <p>
                A no-code content management system with a built-in AI assistant. Write copy, generate images, assemble
                pages visually, and go live instantly — with role-based access so non-tech staff can update safely.
              </p>
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
              <h2>What <em>Proxwebs</em> is</h2>
              <p>
                One admin dashboard that replaces fragmented tools: page builders, copy drafts, image sourcing, template
                switching, and permissioned publishing — all in a single experience.
              </p>
            </div>
          </div>
        </div>
        <div class="row highlight-grid g-4">
          <div class="col-md-6 col-lg-3" v-for="item in highlights" :key="item.title">
            <div class="highlight-card">
              <span class="highlight-label">{{ item.label }}</span>
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
              <h2>Core <span>capabilities</span></h2>
              <p>Everything you need to build, manage, and publish — without waiting on a developer ticket.</p>
            </div>
          </div>
        </div>
        <div class="row capability-grid g-4">
          <div class="col-md-6" v-for="item in capabilities" :key="item.title">
            <div class="capability-card">
              <h4>{{ item.title }}</h4>
              <p>{{ item.body }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="section-heading text-start">
              <h2>How publishing <em>works</em></h2>
              <p>A clear path from idea to live page, built around how content teams actually work.</p>
              <ol class="workflow-list">
                <li v-for="step in workflow" :key="step.title">
                  <strong>{{ step.title }}</strong>
                  <span>{{ step.body }}</span>
                </li>
              </ol>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="overview-panel">
              <h4>Built for real teams</h4>
              <ul>
                <li>Marketing edits pages without code</li>
                <li>AI drafts SEO-ready copy in seconds</li>
                <li>Images generate and auto-fit to slots</li>
                <li>Templates restyle the whole site in one click</li>
                <li>RBAC keeps publishing safe and auditable</li>
              </ul>
              <div class="overview-panel-actions">
                <div class="main-blue-button-hover">
                  <RouterLink to="/services">Explore services</RouterLink>
                </div>
                <div class="main-red-button-hover">
                  <RouterLink to="/contact">Request a demo</RouterLink>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center page-cta">
            <h2>Ready to see it in action?</h2>
            <p>Talk to us about a demo, or meet Zelo — the AI assistant at the heart of Proxwebs.</p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/zelo">Meet Zelo</RouterLink>
              </div>
              <div class="main-red-button-hover">
                <RouterLink to="/contact">Get in touch</RouterLink>
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

const highlights = [
  {
    label: '01',
    title: 'No-Code',
    body: 'Manage pages, menus, and design visually from one dashboard.',
  },
  {
    label: '02',
    title: 'AI-Native',
    body: 'Generate marketing copy and on-brand images on demand.',
  },
  {
    label: '03',
    title: 'Real-Time',
    body: 'Edits go live instantly — no deploy wait for everyday updates.',
  },
  {
    label: '04',
    title: 'Secure',
    body: 'Role and section-level access so the right people publish safely.',
  },
];

const capabilities = [
  {
    title: 'Visual page builder',
    body: 'Assemble pages from reusable sections you can reorder, reuse, and refine without touching code.',
  },
  {
    title: 'AI content & images',
    body: 'Describe what you need — Zelo drafts copy, titles, and visuals, then auto-fits images to each slot.',
  },
  {
    title: 'Design templates',
    body: 'Switch the entire look — including navbar and footer styling — with ready-made templates.',
  },
  {
    title: 'Admin dashboard',
    body: 'Pages, menus, sections, templates, contacts, users, and roles live in one place.',
  },
];

const workflow = [
  {
    title: 'Describe',
    body: 'Tell the AI what the page or section should say and look like.',
  },
  {
    title: 'Generate',
    body: 'Get draft copy and images in seconds, ready to refine.',
  },
  {
    title: 'Refine',
    body: 'Edit visually, swap templates, and adjust layout blocks.',
  },
  {
    title: 'Publish',
    body: 'Go live instantly with the right permissions in place.',
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
.highlight-card p,
.capability-card p,
.overview-panel li,
.page-cta p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.page-section {
  padding: 60px 0;
}

.page-section--muted {
  background: #f8fbfd;
}

.section-heading.text-start {
  text-align: left !important;
}

.section-heading h2 {
  margin-bottom: 20px;
}

.highlight-grid,
.capability-grid {
  margin-top: 28px;
}

.highlight-card,
.capability-card {
  background: #fff;
  border-radius: 20px;
  padding: 26px 22px;
  height: 100%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.highlight-label {
  display: inline-block;
  color: #ff695f;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.08em;
  margin-bottom: 10px;
}

.highlight-card h4,
.capability-card h4,
.overview-panel h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 10px;
  color: #2a2a2a;
}

.capability-card {
  border: 1px solid #e8f6fc;
}

.workflow-list {
  list-style: none;
  margin: 28px 0 0;
  padding: 0;
  counter-reset: steps;
}

.workflow-list li {
  counter-increment: steps;
  position: relative;
  padding: 0 0 22px 52px;
}

.workflow-list li::before {
  content: counter(steps, decimal-leading-zero);
  position: absolute;
  left: 0;
  top: 0;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(105deg, #03a4ed 0%, #33c1ff 100%);
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
}

.workflow-list strong {
  display: block;
  color: #2a2a2a;
  font-size: 17px;
  margin-bottom: 4px;
}

.workflow-list span {
  display: block;
  color: #7a7a7a;
  font-size: 15px;
  font-weight: 400;
  line-height: 1.7;
  text-transform: none;
  letter-spacing: normal;
  opacity: 1;
}

.overview-panel {
  background: linear-gradient(160deg, #f4fbff 0%, #fff 55%, #fff6f7 100%);
  border-radius: 24px;
  padding: 36px 30px;
  border: 1px solid #e8f6fc;
}

.overview-panel ul {
  margin: 18px 0 28px;
  padding-left: 18px;
}

.overview-panel li {
  margin-bottom: 10px;
}

.overview-panel-actions,
.page-cta-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
}

.page-cta h2 {
  font-size: 34px;
  font-weight: 700;
  margin-bottom: 16px;
  color: #2a2a2a;
}

.page-cta-buttons {
  justify-content: center;
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

  .overview-panel {
    margin-top: 28px;
  }
}
</style>
