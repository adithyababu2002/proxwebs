<template>
  <div class="inner-page contact-page">
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="page-banner-content">
              <h6>Contact</h6>
              <h2>Ready to build with <em>CMS</em>? <span>Let’s talk</span></h2>
              <p>
                Request a demo, ask about onboarding, or tell us what your team needs from an AI-native publishing
                workflow. We usually respond within one business day.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="contact-us section contact-page-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="section-heading">
              <h2>Get in <em>touch</em></h2>
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
                <span>
                  <i class="fa fa-phone"></i>
                  <a href="tel:+919072227737">Sales &amp; Support<br />9072227737</a>
                </span>
                <span>
                  <i class="fa fa-envelope"></i>
                  <a href="mailto:info@hyzventures.com">info@hyzventures.com</a>
                </span>
              </div>
            </div>
          </div>
          <div class="col-lg-5 align-self-center">
            <ContactForm source="contact-page" />
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
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { img } from '../images';
import ContactForm from '../components/ContactForm.vue';

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

.page-banner-content p {
  color: #7a7a7a;
  line-height: 1.8;
  font-size: 16px;
}

.contact-page-section {
  padding-top: 40px;
  padding-bottom: 80px;
}

@media (max-width: 991px) {
  .page-banner {
    padding: 120px 0 40px;
  }


  .page-banner-content h2 {
    font-size: 32px;
  }
}
</style>
