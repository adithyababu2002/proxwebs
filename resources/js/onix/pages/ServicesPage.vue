<template>
  <div class="inner-page services-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>Services</h6>
              <h2>Everything you need to build, manage, and publish — without code</h2>
              <p>
                A no-code, AI-native content management system built for speed, quality, and control. From visual page
                building to AI-assisted copy and images, every capability below is designed to get your site live and
                keep it fresh.
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
              <h2>What <em>it is</em></h2>
              <p>
                One platform that replaces fragmented tools: page builders, copy drafts, image sourcing, template
                switching, and permissioned publishing — all in a single admin experience.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--muted">
      <div class="container">
        <div class="row">
          <div class="col-lg-6" v-for="(service, index) in services" :key="service.title">
            <article class="service-block">
              <div class="service-block-icon">
                <img :src="img(service.icon)" :alt="service.title" />
              </div>
              <div class="service-block-body">
                <span class="service-index">{{ String(index + 1).padStart(2, '0') }}</span>
                <h3>{{ service.title }}</h3>
                <p>{{ service.summary }}</p>
                <ul>
                  <li v-for="point in service.points" :key="point">{{ point }}</li>
                </ul>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="section-heading text-start">
              <h2>A publishing workflow that actually <span>moves</span></h2>
              <p>
                Most teams do not need more software — they need a clearer path from idea to live page. Our workflow is
                built around how content work really happens.
              </p>
              <ol class="workflow-list">
                <li v-for="step in workflow" :key="step.title">
                  <strong>{{ step.title }}</strong>
                  <span>{{ step.body }}</span>
                </li>
              </ol>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="workflow-panel">
              <h4>Built for real teams</h4>
              <p>
                Marketing owns messaging. Operations owns structure. Leadership stays informed. Developers are free for
                product work instead of routine content tickets.
              </p>
              <ul>
                <li>Pages, menus, sections &amp; templates in one place</li>
                <li>Reusable blocks you can reorder and reuse</li>
                <li>Import / export for backups and migrations</li>
                <li>Google Fonts and design templates for fast restyling</li>
                <li>SEO-ready titles, taglines &amp; descriptions</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-cta">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <h2>See the full platform on a live walkthrough</h2>
            <p>
              We will show you how AI content, image generation, templates, and role-based publishing fit together for
              your site.
            </p>
            <div class="page-cta-buttons">
              <div class="main-blue-button-hover">
                <RouterLink to="/contact">Request a Demo</RouterLink>
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
import { onMounted } from 'vue';
import { img } from '../images';

const services = [
  {
    title: 'No-Code Visual Management',
    icon: 'service-icon-01.png',
    summary:
      'Manage pages, menus, and design visually so non-technical staff can own the website day to day.',
    points: [
      'Create and reorder pages without developer help',
      'Edit menus and navigation from the dashboard',
      'Update section content in place with live preview context',
    ],
  },
  {
    title: 'AI-Native Content & Images',
    icon: 'service-icon-02.png',
    summary:
      'Generate marketing copy and visuals on demand, then refine until the message and look match your brand.',
    points: [
      'Prompt-to-content for headlines, body copy, and CTAs',
      'Enhance, rewrite, shorten, or expand existing text',
      'Generate images and auto-fit uploads to each layout slot',
    ],
  },
  {
    title: 'Real-Time Publishing',
    icon: 'service-icon-03.png',
    summary:
      'Ship updates the moment they are approved. No waiting on deploys for everyday content changes.',
    points: [
      'Edits go live instantly across the site',
      'Faster campaign and seasonal turnaround',
      'Fewer handoffs between content and engineering',
    ],
  },
  {
    title: 'Secure Role-Based Access',
    icon: 'service-icon-04.png',
    summary:
      'Delegate confidently with role and section-level permissions that keep sensitive areas protected.',
    points: [
      'Control who can edit which sections',
      'Keep publishing safe for non-tech contributors',
      'Reduce risk without slowing the team down',
    ],
  },
  {
    title: 'All-in-One Admin Dashboard',
    icon: 'service-icon-01.png',
    summary:
      'Pages, menus, sections, templates, and contacts live in one workspace instead of scattered tools.',
    points: [
      'Central place for site structure and content',
      'Contact and lead capture alongside page management',
      'Less context-switching for busy teams',
    ],
  },
  {
    title: 'Reusable Sections & Templates',
    icon: 'service-icon-02.png',
    summary:
      'Build pages from modular blocks and switch the entire look with ready-made design templates.',
    points: [
      'Reusable section library for consistent layouts',
      'Reorder blocks to reshape a page quickly',
      'Apply templates to restyle the site in minutes',
    ],
  },
  {
    title: 'Import / Export & Typography',
    icon: 'service-icon-03.png',
    summary:
      'Move data in and out for backups or workflows, and control typography with built-in Google Fonts support.',
    points: [
      'Export content for backup and migration',
      'Import structured data into your workflow',
      'Choose fonts that match your brand system',
    ],
  },
  {
    title: 'SEO-Ready Publishing Workflow',
    icon: 'service-icon-04.png',
    summary:
      'Describe → Generate → Refine → Publish — with AI-assisted titles, taglines, and descriptions along the way.',
    points: [
      'AI help for SEO-friendly titles and meta-style copy',
      'Smart image fit for consistent presentation',
      'A repeatable path from brief to published page',
    ],
  },
];

const workflow = [
  {
    title: 'Describe',
    body: 'Start with a brief, a prompt, or an existing draft. Tell the system what the page needs to achieve.',
  },
  {
    title: 'Generate',
    body: 'Use AI to produce copy and images tailored to the section you are working on.',
  },
  {
    title: 'Refine',
    body: 'Edit visually, swap templates, reorder sections, and polish tone until it feels right.',
  },
  {
    title: 'Publish',
    body: 'Go live instantly with the right permissions in place — then iterate without opening tickets.',
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
.service-block p,
.workflow-panel p,
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

.section-heading.text-start {
  text-align: left !important;
}

.section-heading h2 {
  margin-bottom: 20px;
}

.service-block {
  display: flex;
  gap: 20px;
  background: #fff;
  border-radius: 20px;
  padding: 28px 24px;
  margin-bottom: 24px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
  height: calc(100% - 24px);
}

.service-block-icon {
  flex-shrink: 0;
  width: 64px;
}

.service-block-icon img {
  width: 54px;
  height: auto;
}

.service-index {
  display: inline-block;
  color: #03a4ed;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.06em;
  margin-bottom: 8px;
}

.service-block h3 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 12px;
  color: #2a2a2a;
}

.service-block ul {
  margin: 16px 0 0;
  padding-left: 18px;
}

.service-block ul li {
  margin-bottom: 8px;
  color: #2a2a2a;
  line-height: 1.6;
  font-size: 15px;
}

.workflow-list {
  margin: 28px 0 0;
  padding: 0;
  list-style: none;
  counter-reset: step;
}

.workflow-list li {
  counter-increment: step;
  position: relative;
  padding: 0 0 24px 56px;
}

.workflow-list li::before {
  content: counter(step);
  position: absolute;
  left: 0;
  top: 0;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #03a4ed;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
}

.workflow-list strong {
  display: block;
  font-size: 18px;
  margin-bottom: 6px;
  color: #2a2a2a;
}

.workflow-list span {
  display: block;
  color: #7a7a7a;
  line-height: 1.7;
  font-size: 15px;
  font-weight: 400;
  text-transform: none;
  letter-spacing: normal;
  opacity: 1;
}

.workflow-panel {
  background: #fff6f7;
  border: 1px solid #ffe3e6;
  border-radius: 20px;
  padding: 36px 30px;
}

.workflow-panel h4 {
  font-size: 22px;
  font-weight: 700;
  color: #ff695f;
  margin-bottom: 14px;
}

.workflow-panel ul {
  margin: 20px 0 0;
  padding-left: 18px;
}

.workflow-panel ul li {
  margin-bottom: 10px;
  color: #2a2a2a;
  line-height: 1.6;
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

  .service-block {
    flex-direction: column;
  }

  .workflow-panel {
    margin-top: 28px;
  }
}
</style>
