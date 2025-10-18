
/**
 * Template Name: Website Development Landing Page
 * Description: Custom landing page for website development services, enhanced with Aura-Grid styles.
 *
 * @package Aura-Grid_Machina_Enhanced
 */

get_header(); ?>

<main id="main-content">
  <!-- ======================================================================== -->
  <!-- HERO SECTION (WITH VANTA.JS) -->
  <!-- ======================================================================== -->
  <section class="hero vanta-hero">
    <div class="hero-content container text-center">
      <p class="h4 anim-reveal" style="color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.1em; transition-delay: 0.1s;"><?php _e('Web Design & Development Services', 'auragrid'); ?></p>
      <h1 class="headline anim-reveal text-gradient"><?php _e('Where Taste Drives Growth.', 'auragrid'); ?></h1>
      <p class="hero-intro anim-reveal" style="transition-delay: 0.2s;"><?php _e('Strategic web design and digital presence for cannabis and lifestyle leaders. We build fast, beautiful, high-converting websites that turn clicks into customers.', 'auragrid'); ?></p>
      <div class="hero-cta-group mt-3 anim-reveal" style="transition-delay: 0.3s;">
        <a href="<?php echo esc_url(get_theme_mod('hero_primary_link', '/brand-clarity-quiz')); ?>" class="btn"><?php echo esc_html(get_theme_mod('hero_primary_text', 'Brand Clarity Quiz')); ?></a>
        <a href="<?php echo esc_url(get_theme_mod('hero_secondary_link', '/our-process')); ?>" class="btn btn-accent"><?php echo esc_html(get_theme_mod('hero_secondary_text', 'Our Process')); ?></a>
        <a href="<?php echo esc_url(get_theme_mod('hero_tertiary_link', '#faq')); ?>" class="btn btn-glass"><?php echo esc_html(get_theme_mod('hero_tertiary_text', 'Have Questions?')); ?></a>
      </div>
    </div>
  </section>


  <!-- ======================================================================== -->
  <!-- PACKAGES SECTION -->
  <!-- ======================================================================== -->
  <section id="packages" class="container">
    <h2 class="section-heading anim-reveal"><?php _e("Our Website Packages", "auragrid"); ?></h2>
    <p class="anim-reveal" style="color: var(--color-text-secondary); max-width: 60ch; margin-inline: auto; transition-delay: 0.1s; margin-bottom: 3rem;">
      <?php _e("Choose the package that fits your project scope and budget. All packages include our full process methodology.", "auragrid"); ?>
    </p>

    <div class="packages-grid">
      <!-- Sprint Package -->
      <div class="package-card glass-panel anim-reveal" style="--stagger-index: 1;">
        <div class="package-header">
          <h3>Sprint Package</h3>
          <div class="package-price">$8K–$12K</div>
          <p class="package-timeline">1–2 weeks</p>
        </div>
        <div class="package-content">
          <p class="package-description">Perfect for quick wins, testing concepts, or single-phase projects.</p>
          <h4>What's Included:</h4>
          <ul class="package-features">
            <li><strong>One phase only:</strong> Discovery OR Launch (Design sprint limited to 2 templates)</li>
            <li>Strategy consultation (2 hours)</li>
            <li>Basic project management</li>
            <li>1 round of revisions</li>
            <li>Source files delivery</li>
          </ul>
          <h4>What's NOT Included:</h4>
          <ul class="package-exclusions">
            <li>Full brand identity development</li>
            <li>Complete website build</li>
            <li>Content creation</li>
            <li>SEO optimization</li>
            <li>Analytics setup</li>
            <li>Training & handoff</li>
          </ul>
          <a href="<?php echo esc_url(csl_get_cta_link('sprint', 'websites_page', 'package_cta')); ?>" class="btn btn-primary">Start Sprint</a>
        </div>
      </div>

      <!-- Core Four Package -->
      <div class="package-card glass-panel anim-reveal featured" style="--stagger-index: 2;">
        <div class="package-header">
          <h3>Core Four Package</h3>
          <div class="package-price">$32K–$40K</div>
          <p class="package-timeline">6–8 weeks</p>
        </div>
        <div class="package-content">
          <p class="package-description">Most popular choice for growing brands needing a complete identity and website.</p>
          <h4>What's Included:</h4>
          <ul class="package-features">
            <li><strong>All four phases:</strong> Discovery, Brand, Design & Dev, Content</li>
            <li>Complete brand identity (logo, colors, typography)</li>
            <li>Custom website (up to 10 pages)</li>
            <li>Content strategy & copywriting (up to 5 pages)</li>
            <li>Basic SEO setup</li>
            <li>Analytics & tracking implementation</li>
            <li>Training & full handoff</li>
            <li>3 rounds of revisions</li>
            <li>60 days post-launch support</li>
          </ul>
          <h4>What's NOT Included:</h4>
          <ul class="package-exclusions">
            <li>E-commerce functionality</li>
            <li>Advanced integrations (CRM, ERP)</li>
            <li>Custom functionality development</li>
            <li>Photography/videography</li>
            <li>Paid advertising setup</li>
          </ul>
          <a href="<?php echo esc_url(csl_get_cta_link('core-four', 'websites_page', 'package_cta')); ?>" class="btn btn-accent">Choose Core Four</a>
        </div>
      </div>

      <!-- Enterprise Package -->
      <div class="package-card glass-panel anim-reveal" style="--stagger-index: 3;">
        <div class="package-header">
          <h3>Enterprise Package</h3>
          <div class="package-price">$75K+</div>
          <p class="package-timeline">12–16 weeks</p>
        </div>
        <div class="package-content">
          <p class="package-description">Full-service solution for established brands needing advanced features and scale.</p>
          <h4>What's Included:</h4>
          <ul class="package-features">
            <li><strong>All phases plus:</strong> Advanced development, integrations, scaling</li>
            <li>Everything in Core Four</li>
            <li>E-commerce platform setup</li>
            <li>Custom functionality development</li>
            <li>Advanced integrations (CRM, ERP, APIs)</li>
            <li>Performance optimization & security audit</li>
            <li>Advanced SEO & content marketing strategy</li>
            <li>Photography/videography (up to 20 assets)</li>
            <li>6 months post-launch support</li>
            <li>Conversion rate optimization</li>
          </ul>
          <h4>What's NOT Included:</h4>
          <ul class="package-exclusions">
            <li>Third-party software licenses</li>
            <li>Paid advertising campaigns</li>
            <li>Long-term content creation</li>
          </ul>
          <a href="<?php echo esc_url(csl_get_cta_link('enterprise', 'websites_page', 'package_cta')); ?>" class="btn btn-primary">Contact for Enterprise</a>
        </div>
      </div>
    </div>

    <div class="packages-note anim-reveal" style="margin-top: 3rem; padding: 2rem; background: rgba(255,255,255,0.05); border-radius: 8px; text-align: center;">
      <h4>All Packages Include:</h4>
      <ul style="display: inline-block; text-align: left; margin: 1rem 0;">
        <li>✓ Our proven 4-phase methodology</li>
        <li>✓ Regular progress updates & milestones</li>
        <li>✓ Source files & documentation</li>
        <li>✓ Mobile-responsive design</li>
        <li>✓ Fast, secure hosting setup</li>
        <li>✓ 30-day satisfaction guarantee</li>
      </ul>
      <p style="margin-top: 1rem; color: var(--color-text-secondary);">Need something custom? <a href="<?php echo esc_url(csl_get_cta_link('custom', 'websites_page', 'inquiry')); ?>">Let's talk about your specific needs.</a></p>
    </div>
  </section>
  <!-- ======================================================================== -->
  <!-- FAQ SECTION (REBUILT WITH GLASS CARDS) -->
  <!-- ======================================================================== -->
  <section id="faq" class="container">
    <h2 class="section-heading anim-reveal"><?php _e('Website Development FAQ', 'auragrid'); ?></h2>

    <div class="services-grid" style="margin-top: 4rem;">
        <div class="service-category anim-reveal" style="--stagger-index: 1;">
            <div class="service-header"><h3 class="service-title"><?php _e('How long does a typical website project take?', 'auragrid'); ?></h3></div>
            <p class="service-text"><?php _e('Most projects take 4–8 weeks depending on scope, complexity, and content readiness. We move fast without sacrificing polish.', 'auragrid'); ?></p>
        </div>
        <div class="service-category anim-reveal" style="--stagger-index: 2;">
            <div class="service-header"><h3 class="service-title"><?php _e('What platforms do you build on?', 'auragrid'); ?></h3></div>
            <p class="service-text"><?php _e('We specialize in WordPress but also build custom static sites, Shopify, and headless CMS setups depending on your needs.', 'auragrid'); ?></p>
        </div>
        <div class="service-category anim-reveal" style="--stagger-index: 3;">
            <div class="service-header"><h3 class="service-title"><?php _e('Do you offer hosting and maintenance?', 'auragrid'); ?></h3></div>
            <p class="service-text"><?php _e('Yes — we offer fast, secure hosting with ongoing support. Most clients stay with us for the long haul because it’s easy and reliable.', 'auragrid'); ?></p>
        </div>
        <div class="service-category anim-reveal" style="--stagger-index: 4;">
            <div class="service-header"><h3 class="service-title"><?php _e('Can you work with my brand’s existing assets?', 'auragrid'); ?></h3></div>
            <p class="service-text"><?php _e('Absolutely. We can start with your current logo, brand guide, or assets — or help you elevate and refine them.', 'auragrid'); ?></p>
        </div>
    </div>
  </section>

  <!-- ======================================================================== -->
  <!-- CONTACT FORM SECTION (IN GLASS PANEL) -->
  <!-- ======================================================================== -->
  <section id="custom-form" class="container-narrow text-center">
    <h2 class="section-heading anim-reveal"><?php _e('Start a Conversation', 'auragrid'); ?></h2>
    <p class="anim-reveal" style="color: var(--color-text-secondary); max-width: 60ch; margin-inline: auto; transition-delay: 0.1s; margin-bottom: 3rem;">
        <?php _e('Tell us about your brand, your goals, and how we can help you grow.', 'auragrid'); ?>
    </p>
    <div class="glass-panel anim-reveal" style="transition-delay: 0.2s;">
      <?php echo do_shortcode("[sureforms id='85']"); // Replace with your form shortcode ?>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.clouds.min.js"></script>
<script>
  // Initialize Vanta.js on page load
  document.addEventListener("DOMContentLoaded", function () {
    if (window.VANTA && document.querySelector('.vanta-hero')) {
      VANTA.CLOUDS({
        el: ".vanta-hero",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        // Match theme colors
        skyColor: 0x0A0F1E,
        cloudColor: 0x141A2C,
        sunColor: 0xb8ff00,
        sunlightColor: 0x00eeff
      });
    }
  });
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "How long does a typical website project take?", "acceptedAnswer": { "@type": "Answer", "text": "Most projects take 4–8 weeks depending on scope, complexity, and content readiness. We move fast without sacrificing polish." }},
    { "@type": "Question", "name": "What platforms do you build on?", "acceptedAnswer": { "@type": "Answer", "text": "We specialize in WordPress but also build custom static sites, Shopify, and headless CMS setups depending on your needs." }},
    { "@type": "Question", "name": "Do you offer hosting and maintenance?", "acceptedAnswer": { "@type": "Answer", "text": "Yes — we offer fast, secure hosting with ongoing support. Most clients stay with us for the long haul because it’s easy and reliable." }},
    { "@type": "Question", "name": "Can you work with my brand’s existing assets?", "acceptedAnswer": { "@type": "Answer", "text": "Absolutely. We can start with your current logo, brand guide, or assets — or help you elevate and refine them." }}
  ]
}
</script>

<!-- Minimal Page-Specific Styles (Only for Vanta integration) -->
<style>
  .vanta-hero {
    /* Ensure Vanta canvas is behind the content */
    z-index: 0;
  }
  .vanta-hero canvas {
    z-index: -1;
  }
  .vanta-hero .hero-content {
    /* Ensure content is on top */
    position: relative;
    z-index: 1;
    /* Override default hero text color for better contrast on Vanta bg */
    color: var(--color-text-primary); 
  }
  .text-gradient {
    /* Recreate gradient text using theme variables */
    background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
  }
</style>

<?php get_footer(); ?>
