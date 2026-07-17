<template>
  <div id="top" class="main-banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="owl-carousel owl-banner">
                <div class="item header-text">
                  <h6>AI-POWERED WEBSITE BUILDER &amp; CMS</h6>
                  <h2>CUSTOMISABLE <em>MANAGEMENT</em> <span>SYSTEM</span></h2>
                  <p>
                    Build, manage, and publish a complete website in minutes — with a built-in AI assistant that writes
                    the content and creates the images for you.
                  </p>
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#contact">Request a Demo</a>
                    </div>
                    <div class="call-button">
                      <a href="#contact"><i class="fa fa-phone"></i> Talk to us</a>
                    </div>
                  </div>
                </div>
                <div class="item header-text">
                  <h6>NO-CODE, AI-NATIVE</h6>
                  <h2>Ship pages <em>faster</em> with <span>visual editing</span></h2>
                  <p>
                    Your whole website is managed from a single, clean admin dashboard — no coding required.
                  </p>
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#services">See Features</a>
                    </div>
                    <div class="call-button">
                      <a href="#contact"><i class="fa fa-phone"></i> Get in touch</a>
                    </div>
                  </div>
                </div>
                <div class="item header-text">
                  <h6>SECURE &amp; REAL-TIME</h6>
                  <h2>Publish <em>instantly</em> with <span>role-based access</span></h2>
                  <p>
                    Edits go live instantly, while RBAC keeps your content safe — even when non-tech staff manage
                    updates.
                  </p>
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#about">Why It Matters</a>
                    </div>
                    <div class="call-button">
                      <a href="#contact"><i class="fa fa-phone"></i> Contact</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="services" class="our-services section">
    <div class="services-right-dec">
      <img :src="img('services-right-dec.png')" alt="" />
    </div>
    <div class="container">
      <div class="services-left-dec">
        <img :src="img('services-left-dec.png')" alt="" />
      </div>
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading">
            <h2><em>The Concept</em></h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <p class="text-center what-it-is-subtitle">
            A no-code, AI-native content management system built for speed, quality, and control.
          </p>
        </div>
        <div class="col-lg-12">
          <div class="owl-carousel owl-services">
            <div class="item">
              <h4>No-Code</h4>
              <div class="icon"><img :src="img('service-icon-01.png')" alt="" /></div>
              <p>Manage pages, menus &amp; design visually.</p>
            </div>
            <div class="item">
              <h4>AI-Native</h4>
              <div class="icon"><img :src="img('service-icon-02.png')" alt="" /></div>
              <p>Generate content &amp; images on demand.</p>
            </div>
            <div class="item">
              <h4>Real-Time</h4>
              <div class="icon"><img :src="img('service-icon-03.png')" alt="" /></div>
              <p>Edits go live instantly.</p>
            </div>
            <div class="item">
              <h4>Secure</h4>
              <div class="icon"><img :src="img('service-icon-04.png')" alt="" /></div>
              <p>Role &amp; section-level access control.</p>
            </div>
            <div class="item">
              <h4>All-in-One Dashboard</h4>
              <div class="icon"><img :src="img('service-icon-01.png')" alt="" /></div>
              <p>Pages, menus, sections, templates &amp; contacts in one place.</p>
            </div>
            <div class="item">
              <h4>Reusable Sections</h4>
              <div class="icon"><img :src="img('service-icon-02.png')" alt="" /></div>
              <p>Build pages from modular blocks that can be reordered and reused.</p>
            </div>
            <div class="item">
              <h4>Design Templates</h4>
              <div class="icon"><img :src="img('service-icon-03.png')" alt="" /></div>
              <p>Switch the entire look instantly with ready-made templates.</p>
            </div>
            <div class="item">
              <h4>Import / Export</h4>
              <div class="icon"><img :src="img('service-icon-04.png')" alt="" /></div>
              <p>Move data in and out easily for backups and workflows.</p>
            </div>
            <div class="item">
              <h4>Google Fonts</h4>
              <div class="icon"><img :src="img('service-icon-01.png')" alt="" /></div>
              <p>Typography control built-in.</p>
            </div>
            <div class="item">
              <h4>Publishing Workflow</h4>
              <div class="icon"><img :src="img('service-icon-02.png')" alt="" /></div>
              <p>Describe → Generate → Refine → Publish.</p>
            </div>
            <div class="item">
              <h4>SEO-ready Copy</h4>
              <div class="icon"><img :src="img('service-icon-03.png')" alt="" /></div>
              <p>AI-assisted titles, taglines &amp; descriptions.</p>
            </div>
            <div class="item">
              <h4>Smart Image Fit</h4>
              <div class="icon"><img :src="img('service-icon-04.png')" alt="" /></div>
              <p>Auto-resize &amp; crop uploads to fit each slot.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="about" class="about-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="left-image">
            <img :src="img('about-left-image.png')" alt="Two Girls working together" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="section-heading">
            <h2>The <em>Challenge</em> &amp; The <span>Solution</span></h2>
            <p>
              Why traditional website management is hard — and how we fix it.
            </p>
            <div class="row challenge-solution">
              <div class="col-lg-6">
                <div class="cs-box cs-box--challenge">
                  <h4>The Challenge</h4>
                  <ul>
                    <li>Every text or image change needs a developer</li>
                    <li>Writing good marketing copy takes time &amp; skill</li>
                    <li>Sourcing &amp; resizing images is tedious</li>
                    <li>Slow turnaround — days or weeks per update</li>
                    <li>High ongoing development cost</li>
                    <li>No safe way to delegate to non-tech staff</li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="cs-box cs-box--solution">
                  <h4>Our Solution — CMS</h4>
                  <ul>
                    <li>Staff edit everything from a visual dashboard</li>
                    <li>AI writes &amp; polishes copy in seconds</li>
                    <li>AI generates and auto-fits images</li>
                    <li>Changes publish instantly</li>
                    <li>Near-zero developer dependency</li>
                    <li>Role-based permissions keep it safe</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="leaders" class="our-leaders section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2 v-html="leadersIntro.homeTitle"></h2>
            <span>{{ leadersIntro.eyebrow }}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <p class="text-center leaders-subtitle">{{ leadersIntro.homeSubtitle }}</p>
        </div>
      </div>
      <div class="row leaders-grid">
        <div class="col-lg-4 col-md-6" v-for="member in leaderMembers" :key="member.id">
          <div class="leader-card">
            <div class="leader-card-photo">
              <img :src="teamImage(member)" :alt="member.name" />
            </div>
            <h4>{{ member.name }}</h4>
            <span>{{ member.role }}</span>
            <p>{{ member.shortBio }}</p>
            <RouterLink class="leader-readmore" :to="`/leaders/${member.slug}`">Read more</RouterLink>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="main-blue-button-hover leaders-more-btn">
            <RouterLink to="/leaders">Meet Our Leaders</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="team" class="our-team section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2 v-html="teamIntro.homeTitle"></h2>
            <span>{{ teamIntro.eyebrow }}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <p class="text-center team-subtitle">{{ teamIntro.homeSubtitle }}</p>
        </div>
        <div class="col-lg-12">
          <div class="owl-carousel owl-team">
            <div class="item" v-for="member in teamMembers" :key="member.id">
              <div class="team-card">
                <div class="team-card-photo">
                  <img :src="teamImage(member)" :alt="member.name" />
                </div>
                <h4>{{ member.name }}</h4>
                <span>{{ member.role }}</span>
                <p>{{ member.shortBio }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="main-blue-button-hover team-more-btn">
            <RouterLink to="/team">Meet the Full Team</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="portfolio" class="our-portfolio section">
    <div class="portfolio-left-dec">
      <img :src="img('portfolio-left-dec.png')" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading">
            <h2>AI at the Core — Meet <em>“Zelo”</em></h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="main-blue-button-hover" style="display: inline-block; margin-bottom: 30px">
            <RouterLink to="/zelo">Explore Meet Zelo</RouterLink>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-portfolio">
            <div class="item" v-for="feature in zeloFeatures" :key="feature.id">
              <div class="thumb">
                <img :src="img(feature.image)" :alt="feature.title" />
                <div class="hover-effect">
                  <div class="inner-content">
                    <RouterLink to="/zelo"><h4>{{ feature.title }}</h4></RouterLink>
                    <span>{{ feature.summary }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="subscribe" class="subscribe">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="inner-content">
            <div class="row">
              <div class="col-lg-10 offset-lg-1">
                <h2>Page Building &amp; Templates</h2>
                <p class="subscribe-subtitle">
                  Assemble pages from reusable blocks, then restyle in one click.
                </p>
                <div class="template-pills" role="group" aria-label="Templates">
                  <RouterLink
                    v-for="design in designs"
                    :key="design.id"
                    class="pill"
                    :to="{ name: 'designs', query: { preview: design.id } }"
                  >
                    {{ design.name }}
                  </RouterLink>
                  <span class="template-and-so-on">…and so on</span>
                </div>
                <div class="template-custom-cta">
                  <span>For your custom designs</span>
                  <RouterLink to="/contact" class="template-contact-btn">Contact Us</RouterLink>
                </div>
                <p class="subscribe-footnote">
                  Each template includes its own navbar &amp; footer styling.
                  <RouterLink to="/designs">Live preview</RouterLink> lets you see a template before applying it.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="video" class="our-videos section">
    <div class="videos-left-dec">
      <img :src="img('videos-left-dec.png')" alt="" />
    </div>
    <div class="videos-right-dec">
      <img :src="img('videos-right-dec.png')" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading text-center mb-5">
            <h2>All-in-One <em>Admin</em> <span>Dashboard</span></h2>
          </div>
          <div class="row admin-grid">
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Dashboard</h4>
                <p>At-a-glance overview</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Pages</h4>
                <p>Create, edit &amp; organize pages</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Menus</h4>
                <p>Multi-level navigation builder</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Sections</h4>
                <p>Reusable content blocks</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Templates</h4>
                <p>Switch site-wide design</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Contacts</h4>
                <p>View &amp; manage form leads</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>YouTube Videos</h4>
                <p>Curated video galleries</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Users</h4>
                <p>Manage team accounts</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="admin-card">
                <h4>Roles &amp; Privileges</h4>
                <p>Define access levels</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="contact" class="contact-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="section-heading">
            <h2>Ready to build with <em>CMS</em>? <span>Contact us</span></h2>
            <div id="map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.3908795157795!2d76.87470077582462!3d8.558359796176793!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bf74e061d2d9%3A0x466c362cb16ce198!2sHYZ%20VENTURES%20INTL%20PRIVATE%20LIMITED!5e0!3m2!1sen!2sin!4v1775622815344!5m2!1sen!2sin"
                width="100%"
                height="360px"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="HYZ Ventures Intl Private Limited"
              ></iframe>
            </div>
            <div class="info">
              <span
                ><i class="fa fa-phone"></i>
                <a href="tel:+919072227737">Sales &amp; Support<br />9072227737</a></span
              >
              <span
                ><i class="fa fa-envelope"></i>
                <a href="mailto:info@hyzventures.com">info@hyzventures.com</a></span
              >
            </div>
          </div>
        </div>
        <div class="col-lg-5 align-self-center">
          <ContactForm source="home" />
        </div>
      </div>
    </div>
    <div class="contact-dec">
      <img :src="img('contact-dec.png')" alt="" />
    </div>
    <div class="contact-left-dec">
      <img :src="img('contact-left-dec.png')" alt="" />
    </div>
  </div>

</template>

<script setup>
import { onMounted, nextTick, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { loadScriptsInOrder, onixLegacyScripts } from '../loadScripts';
import { img, teamImage } from '../images';
import { fetchTeamMembers, teamIntro } from '../content/teamApi';
import { leaderMembers, leadersIntro } from '../content/leaders';
import { designs } from '../content/designs';
import { zeloFeatures } from '../content/zelo';
import ContactForm from '../components/ContactForm.vue';

const route = useRoute();
const teamMembers = ref([]);

async function scrollToSection(sectionId) {
  if (!sectionId) {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    return;
  }

  await nextTick();

  const headerOffset = 80;
  const el = document.getElementById(sectionId);
  if (!el) return;

  const y = el.getBoundingClientRect().top + window.scrollY - headerOffset;
  window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
}

function initHomeCarousels() {
  if (!window.$ || !window.$.fn?.owlCarousel) return;
  const $ = window.$;

  const banner = $('.owl-banner');
  if (banner.length) {
    if (banner.hasClass('owl-loaded')) banner.trigger('destroy.owl.carousel');
    banner.owlCarousel({
      items: 1,
      loop: true,
      dots: true,
      nav: false,
      autoplay: true,
      margin: 0,
      responsive: { 0: { items: 1 }, 600: { items: 1 }, 1000: { items: 1 }, 1600: { items: 1 } },
    });
  }

  const services = $('.owl-services');
  if (services.length) {
    if (services.hasClass('owl-loaded')) services.trigger('destroy.owl.carousel');
    services.owlCarousel({
      items: 4,
      loop: true,
      dots: true,
      nav: false,
      autoplay: true,
      margin: 5,
      responsive: { 0: { items: 1 }, 600: { items: 2 }, 1000: { items: 3 }, 1600: { items: 4 } },
    });
  }

  const team = $('.owl-team');
  if (team.length) {
    if (team.hasClass('owl-loaded')) team.trigger('destroy.owl.carousel');
    team.owlCarousel({
      items: 4,
      loop: true,
      dots: true,
      nav: false,
      autoplay: true,
      margin: 20,
      responsive: { 0: { items: 1 }, 600: { items: 2 }, 1000: { items: 3 }, 1600: { items: 4 } },
    });
  }

  const portfolio = $('.owl-portfolio');
  if (portfolio.length) {
    if (portfolio.hasClass('owl-loaded')) portfolio.trigger('destroy.owl.carousel');
    portfolio.owlCarousel({
      items: 4,
      loop: true,
      dots: true,
      nav: true,
      autoplay: true,
      margin: 30,
      responsive: { 0: { items: 1 }, 700: { items: 2 }, 1000: { items: 3 }, 1600: { items: 4 } },
    });
  }
}

onMounted(async () => {
  await loadScriptsInOrder(onixLegacyScripts);
  teamMembers.value = await fetchTeamMembers();
  await nextTick();
  initHomeCarousels();

  if (window.$) {
    window.$(document).off('click.onixNacc');
    window.$(document).on('click.onixNacc', '.naccs .menu div', function () {
      var numberIndex = window.$(this).index();

      if (!window.$(this).is('active')) {
        window.$('.naccs .menu div').removeClass('active');
        window.$('.naccs ul li').removeClass('active');

        window.$(this).addClass('active');
        window.$('.naccs ul').find('li:eq(' + numberIndex + ')').addClass('active');

        var listItemHeight = window.$('.naccs ul').find('li:eq(' + numberIndex + ')').innerHeight();
        window.$('.naccs ul').height(listItemHeight + 'px');
      }
    });
  }

  await scrollToSection(route.meta?.sectionId);
});

watch(
  () => route.fullPath,
  async () => {
    await scrollToSection(route.meta?.sectionId);
  }
);
</script>

<style scoped>
.what-it-is-subtitle {
  margin-top: -10px;
  margin-bottom: 30px;
  color: #7a7a7a;
}

.our-leaders {
  padding: 90px 0 40px;
  background: #fff;
}

.our-leaders .section-heading {
  text-align: center;
}

.our-leaders .section-heading h2 {
  margin: 0 auto;
}

.our-leaders .section-heading > span {
  display: block;
  opacity: 1;
  color: #ff695f;
  font-size: 22px;
  letter-spacing: 0.06em;
  margin-top: 18px;
  margin-bottom: 12px;
  line-height: 1.6;
}

.leaders-subtitle {
  margin-top: 8px;
  margin-bottom: 40px;
  color: #7a7a7a;
  line-height: 1.8;
}

.leaders-grid {
  --bs-gutter-x: 1.75rem;
  --bs-gutter-y: 1.75rem;
  margin-bottom: 10px;
}

.leader-card {
  background: #fff;
  border-radius: 24px;
  padding: 32px 26px 34px;
  text-align: center;
  box-shadow: 0 0 18px rgba(0, 0, 0, 0.06);
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
  margin-bottom: 10px;
  border: 1px solid rgba(3, 164, 237, 0.08);
}

.leader-card-photo {
  width: 160px;
  height: 160px;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 22px;
  border: 1px solid #000;
  flex-shrink: 0;
}

.leader-card-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.leader-card h4 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 8px;
  color: #2a2a2a;
}

.leader-card span {
  display: block;
  color: #03a4ed;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 14px;
}

.leader-card p {
  margin: 0;
  color: #7a7a7a;
  font-size: 15px;
  line-height: 1.75;
  flex: 1;
}

.leader-readmore {
  display: inline-block;
  margin-top: 16px;
  color: #03a4ed;
  font-weight: 600;
  text-decoration: none;
}

.leader-readmore:hover {
  color: #0284c7;
  text-decoration: underline;
}

.leaders-more-btn {
  display: inline-block;
  margin-top: 18px;
  margin-bottom: 20px;
}

.our-team {
  padding: 90px 0 70px;
  background: #f8fbfd;
}

.our-team .section-heading {
  text-align: center;
}

.our-team .section-heading h2 {
  margin: 0 auto;
}

.our-team .section-heading > span {
  display: block;
  opacity: 1;
  color: #ff695f;
  font-size: 22px;
  letter-spacing: 0.06em;
  margin-top: 18px;
  margin-bottom: 12px;
  line-height: 1.6;
}

.team-subtitle {
  margin-top: 8px;
  margin-bottom: 40px;
  color: #7a7a7a;
  line-height: 1.8;
}

.owl-team {
  margin-bottom: 20px;
}

:deep(.owl-team .owl-stage) {
  display: flex;
  align-items: stretch;
}

:deep(.owl-team .owl-item) {
  display: flex;
  height: auto;
}

:deep(.owl-team .item) {
  display: flex;
  width: 100%;
  height: 100%;
}

.team-card {
  background: #fff;
  border-radius: 20px;
  padding: 22px 18px 26px;
  text-align: center;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
  margin-bottom: 10px;
}

.team-card-photo {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 18px;
  border: 1px solid #000;
  flex-shrink: 0;
}

.team-card-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.team-card h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 6px;
  color: #2a2a2a;
}

.team-card span {
  display: block;
  color: #03a4ed;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 12px;
}

.team-card p {
  margin: 0;
  color: #7a7a7a;
  font-size: 14px;
  line-height: 1.7;
  flex: 1;
}

:deep(.owl-team .owl-dots) {
  text-align: center;
  margin-top: 24px;
}

:deep(.owl-team .owl-dots .owl-dot) {
  width: 6px;
  height: 6px;
  background-color: #ff695f;
  border-radius: 50%;
  opacity: 0.3;
  display: inline-block;
  margin: 0 5px;
  transition: all 0.25s ease;
}

:deep(.owl-team .owl-dots .owl-dot.active) {
  opacity: 1;
  width: 10px;
  height: 10px;
}

.team-more-btn {
  display: inline-block;
  margin-top: 10px;
}

.challenge-solution {
  margin-top: 35px;
}

.cs-box {
  border-radius: 20px;
  padding: 26px 22px;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.05);
  background: #fff;
  height: 100%;
}

.cs-box h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 14px;
}

.cs-box ul {
  margin: 0;
  padding-left: 18px;
}

.cs-box ul li {
  margin-bottom: 10px;
  color: #2a2a2a;
  line-height: 28px;
  font-size: 15px;
}

.cs-box--challenge {
  background: #fff6f7;
  border: 1px solid #ffe3e6;
}

.cs-box--challenge h4 {
  color: #ff695f;
}

.cs-box--solution {
  background: #f3fff8;
  border: 1px solid #d6f5e4;
}

.cs-box--solution h4 {
  color: #03a4ed;
}

.subscribe-subtitle {
  color: rgba(255, 255, 255, 0.9);
  text-align: center;
  margin-top: -5px;
  margin-bottom: 25px;
}

.template-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  justify-content: center;
  margin-top: 10px;
}

.template-pills .pill {
  border: 1px solid rgba(255, 255, 255, 0.7);
  background: rgba(255, 255, 255, 0.12);
  color: #fff !important;
  padding: 10px 18px;
  border-radius: 999px;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none !important;
  transition: all 0.2s ease;
  cursor: pointer;
}

.template-pills .pill:hover {
  background: rgba(255, 255, 255, 0.22);
  transform: translateY(-1px);
  color: #fff !important;
}

.template-and-so-on {
  display: inline-flex;
  align-items: center;
  color: rgba(255, 255, 255, 0.95);
  font-size: 14px;
  font-weight: 500;
  padding: 10px 4px;
}

.template-custom-cta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 18px;
  color: rgba(255, 255, 255, 0.95);
  font-size: 15px;
  font-weight: 500;
}

.template-contact-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 22px;
  border-radius: 999px;
  background: #fff;
  color: #03a4f1 !important;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none !important;
  transition: all 0.2s ease;
}

.template-contact-btn:hover {
  background: rgba(255, 255, 255, 0.92);
  transform: translateY(-1px);
  color: #0284c7 !important;
}

.subscribe-footnote {
  margin-top: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.9);
}

.subscribe-footnote a {
  color: #fff;
  text-decoration: underline !important;
}

.admin-grid {
  margin-top: 10px;
  --bs-gutter-x: 2rem;
  --bs-gutter-y: 2rem;
}

.admin-card {
  border-radius: 20px;
  background: #fff;
  padding: 26px 22px;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.05);
  margin-bottom: 0;
  height: 100%;
}

.admin-card h4 {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 8px;
}

.admin-card p {
  margin: 0;
  color: #7a7a7a;
}

@media (max-width: 991px) {
  .cs-box {
    margin-bottom: 22px;
  }

  .leader-card {
    margin-bottom: 22px;
  }

  .template-pills {
    gap: 8px;
    justify-content: center;
  }
}

@media (max-width: 767px) {
  :deep(.main-banner .item .down-buttons) {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 18px;
  }

  :deep(.main-banner .item .down-buttons .main-blue-button-hover),
  :deep(.main-banner .item .down-buttons .main-blue-button) {
    margin: 0;
  }

  :deep(.main-banner .item .down-buttons .call-button a) {
    margin-left: 0;
  }

  .cs-box {
    margin-bottom: 18px;
  }
}
</style>

