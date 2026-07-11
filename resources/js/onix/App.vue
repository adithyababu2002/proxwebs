<template>
  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <RouterLink to="/" class="logo">
              <img :src="img('LOGO10.png')" alt="Onix Digital" />
            </RouterLink>
            <ul class="nav">
              <li class="scroll-to-section">
                <RouterLink to="/" class="nav-link" active-class="active" exact-active-class="active">Home</RouterLink>
              </li>
              <li class="scroll-to-section">
                <RouterLink to="/about" class="nav-link" active-class="active">About</RouterLink>
              </li>

              <li class="scroll-to-section">
                <RouterLink to="/services" class="nav-link" active-class="active">Services</RouterLink>
              </li>
              <li class="scroll-to-section">
                <RouterLink to="/features" class="nav-link" active-class="active">Features</RouterLink>
              </li>
              <li class="scroll-to-section">
                <RouterLink to="/team" class="nav-link" active-class="active">Team</RouterLink>
              </li>
              <li class="scroll-to-section">
                <RouterLink to="/zelo" class="nav-link" active-class="active">Meet Zelo</RouterLink>
              </li>
              <li class="scroll-to-section">
                <RouterLink to="/contact" class="nav-link" active-class="active">Contact</RouterLink>
              </li>
              <li class="scroll-to-section">
                <div class="main-red-button-hover">
                  <RouterLink to="/contact" class="nav-link" active-class="active">Get in Touch</RouterLink>
                </div>
              </li>
            </ul>
            <a class="menu-trigger" href="#" role="button" aria-label="Toggle menu" @click.prevent>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <RouterView />

  <ZeloChatbot />

  <div class="side-float-actions">
    <button
      type="button"
      class="theme-toggle"
      :aria-label="isDark ? 'Switch to light theme' : 'Switch to dark theme'"
      :title="isDark ? 'Light theme' : 'Dark theme'"
      @click="toggleTheme"
    >
      <i :class="isDark ? 'fa fa-sun-o' : 'fa fa-moon-o'" aria-hidden="true"></i>
    </button>

    <a
      class="whatsapp-float"
      href="https://wa.me/919072227737"
      target="_blank"
      rel="noopener noreferrer"
      aria-label="Chat on WhatsApp"
      title="Chat on WhatsApp"
    >
      <i class="fa fa-whatsapp" aria-hidden="true"></i>
    </a>
  </div>

  <div class="footer-dec">
    <img :src="img('footer-dec.png')" alt="" />
  </div>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="about footer-item">
            <div class="logo">
              <RouterLink to="/"><img :src="img('LOGO10.png')" alt="Proxwebs" /></RouterLink>
            </div>
            <ul class="footer-contact">
              <li>
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  HYZ VENTURES INTL PRIVATE LIMITED,<br />
                  Technopark Trivandrum, Padmanabham Building, Technopark Campus, Thiruvananthapuram, Kerala 695581
                </span>
              </li>
              <li>
                <i class="fa fa-phone" aria-hidden="true"></i>
                <a href="tel:+919072227737">9072227737</a>
              </li>
              <li>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <a href="mailto:info@hyzventures.com">info@hyzventures.com</a>
              </li>
            </ul>
            <ul class="footer-social">
              <li>
                <a
                  href="https://www.facebook.com/hyzventuresintlpvtltd/"
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label="Facebook"
                >
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li>
                <a
                  href="https://www.instagram.com/hyzventuresintlpvtltd_/"
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label="Instagram"
                >
                  <i class="fa fa-instagram"></i>
                </a>
              </li>
              <li>
                <a
                  href="https://www.linkedin.com/company/hyzventuresltd/"
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label="LinkedIn"
                >
                  <i class="fa fa-linkedin"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="services footer-item">
            <h4>Services</h4>
            <ul>
              <li><RouterLink to="/features/generative-ai">AI Content Generation</RouterLink></li>
              <li><RouterLink to="/features/visual-page-builder">Visual Page Builder</RouterLink></li>
              <li><RouterLink to="/features/website-templates">Design Templates</RouterLink></li>
              <li><RouterLink to="/features">All Features</RouterLink></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="community footer-item">
            <h4>Explore</h4>
            <ul>
              <li><RouterLink to="/about">About Us</RouterLink></li>
              <li><RouterLink to="/features">Features</RouterLink></li>
              <li><RouterLink to="/team">Our Team</RouterLink></li>
              <li><RouterLink to="/zelo">Meet Zelo</RouterLink></li>
              <li><RouterLink to="/contact">Contact</RouterLink></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="subscribe-newsletters footer-item">
            <h4>Subscribe Newsletters</h4>
            <p>Get our latest news and ideas to your inbox</p>
            <form @submit.prevent="subscribeNewsletter">
              <input
                id="email"
                v-model.trim="newsletterEmail"
                type="email"
                name="email"
                placeholder="Your Email"
                autocomplete="email"
                required
                :disabled="newsletterSending"
              />
              <button id="form-submit" type="submit" class="main-button" :disabled="newsletterSending">
                <i class="fa fa-paper-plane-o"></i>
              </button>
            </form>
            <p v-if="newsletterMessage" class="newsletter-status" :class="{ 'is-error': newsletterError }">
              {{ newsletterMessage }}
            </p>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="copyright">
            <p>
              Copyright © 2026 proxwebs. All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { loadScriptsInOrder, onixLegacyScripts } from './loadScripts';
import { img } from './images';
import ZeloChatbot from './components/ZeloChatbot.vue';

const router = useRouter();
const THEME_KEY = 'onix-theme';
const isDark = ref(false);
const newsletterEmail = ref('');
const newsletterSending = ref(false);
const newsletterMessage = ref('');
const newsletterError = ref(false);

function applyTheme(dark) {
  isDark.value = dark;
  document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
  try {
    localStorage.setItem(THEME_KEY, dark ? 'dark' : 'light');
  } catch (e) {}
}

function toggleTheme() {
  applyTheme(!isDark.value);
}

function closeMobileNav() {
  if (typeof window === 'undefined' || window.innerWidth >= 992) return;
  const trigger = document.querySelector('.menu-trigger');
  const nav = document.querySelector('.header-area .nav');
  trigger?.classList.remove('active');
  if (window.$ && nav) {
    window.$(nav).stop(true, true).slideUp(200);
  } else if (nav) {
    nav.style.display = 'none';
  }
}

router.afterEach(() => {
  closeMobileNav();
});

async function subscribeNewsletter() {
  newsletterMessage.value = '';
  newsletterError.value = false;
  newsletterSending.value = true;

  try {
    const email = newsletterEmail.value;
    const { data } = await axios.post('/newsletter', {
      email,
      source: 'footer',
      visitor_uuid: localStorage.getItem('proxwebs_visitor_uuid') || undefined,
    });

    try {
      const { identifyVisitor } = await import('./analytics');
      await identifyVisitor({ email, source: 'newsletter:footer' });
    } catch (e) {}

    newsletterMessage.value = data.message || 'Thanks for subscribing!';
    newsletterEmail.value = '';
  } catch (error) {
    newsletterError.value = true;
    const errors = error.response?.data?.errors;
    if (errors) {
      newsletterMessage.value = Object.values(errors).flat()[0] || 'Please enter a valid email.';
    } else {
      newsletterMessage.value = error.response?.data?.message || 'Something went wrong. Please try again.';
    }
  } finally {
    newsletterSending.value = false;
  }
}

onMounted(async () => {
  try {
    applyTheme(localStorage.getItem(THEME_KEY) === 'dark');
  } catch (e) {
    applyTheme(false);
  }
  await loadScriptsInOrder(onixLegacyScripts);
});
</script>

<style scoped>
.newsletter-status {
  margin: 10px 0 0;
  font-size: 13px;
  line-height: 1.5;
  color: #03a4ed;
}

.newsletter-status.is-error {
  color: #ff695f;
}

.footer-contact {
  list-style: none;
  margin: 0 0 18px;
  padding: 0;
}

.footer-contact li {
  display: flex !important;
  align-items: flex-start;
  gap: 10px;
  margin: 0 0 12px !important;
  font-size: 14px;
  line-height: 1.6;
  color: #555555;
}

.footer-contact li:last-child {
  margin-bottom: 0 !important;
}

.footer-contact i {
  flex: 0 0 16px;
  margin-top: 3px;
  color: #03a4ed;
  font-size: 15px;
  text-align: center;
}

.footer-contact a {
  color: #555555;
  text-decoration: none;
}

.footer-contact a:hover {
  color: #ff695f;
}

.footer-social {
  margin-top: 4px;
}
</style>
