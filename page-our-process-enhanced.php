<?php
/**
 * Template Name: Our Process (Enhanced)
 * Description: Enhanced process page with animations, social proof, interactive timeline, and improved UX
 * @package CSL_Agency
 */

if (!defined('ABSPATH')) { exit; }

get_header(); ?>

<main id="main-content" class="csl-process-enhanced">
<?php
  // Customizer content
  $kicker   = get_theme_mod('csl_process_kicker', __('Strategic Brand Consulting','auragrid'));
  $title    = get_theme_mod('csl_process_title', __('Our Proven Process','auragrid'));
  $body     = get_theme_mod('csl_process_body', __("A systematic approach to brand elevation. From discovery to domination, we've refined this process through 100+ successful projects. Here's exactly how we'll transform your brand.", 'auragrid'));

  $cta_primary_text = get_theme_mod('csl_process_cta_primary_text', __('Start Your Project','auragrid'));
  $cta_primary_url  = get_theme_mod('csl_process_cta_primary_url', home_url('/contact/'));
  $cta_secondary_text = get_theme_mod('csl_process_cta_secondary_text', __('View Pricing','auragrid'));
  $cta_secondary_url  = get_theme_mod('csl_process_cta_secondary_url', home_url('/services/'));

  // Default steps with icons
  $default_steps = [
    ['title'=>'Discovery & Strategy','desc'=>'We start with deep-dive research into your market, competitors, and target audience. Define goals, constraints, and success metrics.','out'=>'Strategy Brief & Competitive Analysis','slug'=>'discovery','icon'=>'ph-compass','color'=>'#3498db'],
    ['title'=>'Brand Foundation','desc'=>'Positioning, messaging, visual identity system. We build the foundation that everything else stands on.','out'=>'Brand Guidelines & Asset Library','slug'=>'brand-foundation','icon'=>'ph-cube','color'=>'#9b59b6'],
    ['title'=>'Design & Development','desc'=>'Bring your brand to life across all touchpoints. Website, collateral, packaging, social templates.','out'=>'Production-Ready Assets','slug'=>'design-dev','icon'=>'ph-palette','color'=>'#e74c3c'],
    ['title'=>'Content & Campaigns','desc'=>'Launch campaigns that convert. Content strategy, ad creative, landing pages, email sequences.','out'=>'Campaign Assets & Copy Deck','slug'=>'content-campaigns','icon'=>'ph-megaphone','color'=>'#f39c12'],
    ['title'=>'Launch & Optimize','desc'=>'Go live with analytics tracking. Monitor, test, and optimize based on real performance data.','out'=>'Launch Plan & Analytics Setup','slug'=>'launch','icon'=>'ph-rocket-launch','color'=>'#2ecc71'],
    ['title'=>'Growth & Scale','desc'=>'Continuous improvement. Expand successful campaigns, test new channels, and scale what works.','out'=>'Growth Roadmap & Reporting','slug'=>'growth','icon'=>'ph-trend-up','color'=>'#16a085'],
  ];

  $steps_json = get_theme_mod('csl_process_steps_json', '');
  $steps = json_decode($steps_json, true);
  if (!is_array($steps) || empty($steps)) { $steps = $default_steps; }

  // FAQ
  $default_faq = [
    ['q'=>'How long does the full process take?','a'=>'Typically 8-12 weeks for a complete brand transformation, but we can work in sprints for specific deliverables. Rush projects available.'],
    ['q'=>'What is the investment range?','a'=>'Projects start at $10k for focused initiatives (brand refresh, campaign) and scale to $50k+ for comprehensive rebrands. We offer flexible payment plans and sprint-based pricing.'],
    ['q'=>'Do you work with our in-house team?','a'=>'Absolutely. We integrate seamlessly with your team or act as your complete marketing department. Your choice.'],
    ['q'=>'What industries do you specialize in?','a'=>'Cannabis, lifestyle brands, food & beverage, and B2B services. If you are ready to elevate, we are ready to help.'],
    ['q'=>'Can we start with just one phase?','a'=>'Yes! Each phase can be a standalone project. Most clients start with Discovery & Strategy, then expand from there.'],
  ];
  $faq_json = get_theme_mod('csl_process_faq_json', '');
  $faq = json_decode($faq_json, true);
  if (!is_array($faq) || empty($faq)) { $faq = $default_faq; }
?>

  <!-- Sticky CTA Bar (Mobile & Desktop) -->
  <div class="sticky-cta-bar" id="stickyCTA">
    <div class="container">
      <div class="sticky-cta-content">
        <span class="sticky-cta-text">Ready to get started?</span>
        <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-accent btn-sm">
          <?php echo esc_html($cta_primary_text); ?>
        </a>
      </div>
    </div>
  </div>

  <!-- Hero Section -->
  <header class="process-hero">
    <div class="container-narrow text-center">
      <div class="hero-badge anim-reveal">
        <i class="ph ph-path"></i>
        <span><?php echo esc_html($kicker); ?></span>
      </div>
      <h1 class="hero-title anim-reveal"><?php echo esc_html($title); ?></h1>
      <p class="hero-description anim-reveal">
        <?php echo wp_kses_post($body); ?>
      </p>
      <div class="hero-cta-group anim-reveal">
        <a class="btn btn-accent btn-large" href="<?php echo esc_url($cta_primary_url); ?>">
          <i class="ph ph-paper-plane-tilt"></i>
          <?php echo esc_html($cta_primary_text); ?>
        </a>
        <a class="btn btn-outline btn-large" href="<?php echo esc_url($cta_secondary_url); ?>">
          <i class="ph ph-currency-dollar"></i>
          <?php echo esc_html($cta_secondary_text); ?>
        </a>
      </div>

      <!-- Stats Banner -->
      <div class="hero-stats anim-reveal">
        <div class="stat-item">
          <div class="stat-number">100+</div>
          <div class="stat-label">Projects Delivered</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">8-12</div>
          <div class="stat-label">Week Timeline</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">95%</div>
          <div class="stat-label">Client Satisfaction</div>
        </div>
      </div>
    </div>
  </header>

  <!-- What You Get Section -->
  <section class="what-you-get-section">
    <div class="container">
      <div class="section-header anim-reveal">
        <h2 class="section-title">What You Actually Get</h2>
        <p class="section-subtitle">Tangible deliverables, not vague promises</p>
      </div>

      <div class="benefits-grid">
        <div class="benefit-card anim-reveal">
          <div class="benefit-icon">
            <i class="ph ph-shield-check"></i>
          </div>
          <h3 class="benefit-title">Strategic Foundation</h3>
          <p class="benefit-desc">Brand positioning, messaging framework, competitive analysis, and market research that actually drives decisions.</p>
        </div>

        <div class="benefit-card anim-reveal">
          <div class="benefit-icon">
            <i class="ph ph-paint-brush"></i>
          </div>
          <h3 class="benefit-title">Complete Brand Identity</h3>
          <p class="benefit-desc">Logo system, color palette, typography, brand guidelines, and a library of production-ready assets.</p>
        </div>

        <div class="benefit-card anim-reveal">
          <div class="benefit-icon">
            <i class="ph ph-devices"></i>
          </div>
          <h3 class="benefit-title">Digital Presence</h3>
          <p class="benefit-desc">Custom website, social templates, email designs, and landing pages that convert visitors into customers.</p>
        </div>

        <div class="benefit-card anim-reveal">
          <div class="benefit-icon">
            <i class="ph ph-chart-line-up"></i>
          </div>
          <h3 class="benefit-title">Growth Systems</h3>
          <p class="benefit-desc">Campaign strategy, content calendar, analytics setup, and a 90-day execution roadmap tied to revenue.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Interactive Timeline Process -->
  <section class="process-timeline-section">
    <div class="container">
      <div class="section-header anim-reveal">
        <h2 class="section-title">The Process, Step by Step</h2>
        <p class="section-subtitle">Click each phase to see what happens</p>
      </div>

      <div class="timeline-wrapper">
        <div class="timeline-line"></div>

        <?php foreach ($steps as $i => $s):
          $icon = isset($s['icon']) ? $s['icon'] : 'ph-circle';
          $color = isset($s['color']) ? $s['color'] : '#ff4500';
          $slug = isset($s['slug']) ? sanitize_title($s['slug']) : 'step-'.($i+1);
        ?>
        <div class="timeline-step anim-reveal" data-step="<?php echo $i+1; ?>" style="--step-color: <?php echo esc_attr($color); ?>">
          <div class="step-marker">
            <div class="step-number"><?php echo $i+1; ?></div>
            <div class="step-icon">
              <i class="ph <?php echo esc_attr($icon); ?>"></i>
            </div>
          </div>

          <div class="step-content">
            <div class="step-header">
              <h3 class="step-title"><?php echo esc_html($s['title']); ?></h3>
              <button class="step-toggle" aria-expanded="false">
                <i class="ph ph-caret-down"></i>
              </button>
            </div>

            <div class="step-body">
              <p class="step-description"><?php echo esc_html($s['desc']); ?></p>

              <?php if (!empty($s['out'])): ?>
              <div class="step-deliverable">
                <strong><i class="ph ph-package"></i> Deliverable:</strong>
                <span><?php echo esc_html($s['out']); ?></span>
              </div>
              <?php endif; ?>

              <div class="step-meta">
                <div class="step-duration">
                  <i class="ph ph-clock"></i>
                  <span><?php echo (($i % 3) + 1) . '-' . (($i % 3) + 2); ?> weeks</span>
                </div>
                <div class="step-investment">
                  <i class="ph ph-currency-dollar"></i>
                  <span>$<?php echo number_format(5000 + ($i * 3000), 0); ?>+</span>
                </div>
              </div>

              <div class="step-cta">
                <a href="<?php echo home_url('/process-step-' . $slug); ?>" class="btn btn-step">
                  View Details & Pricing <i class="ph ph-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="process-cta anim-reveal">
        <p class="process-cta-text">Want a custom timeline and quote for your project?</p>
        <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-accent btn-large">
          Get Your Custom Proposal
        </a>
      </div>
    </div>
  </section>

  <!-- Social Proof Section -->
  <section class="social-proof-section">
    <div class="container">
      <div class="section-header anim-reveal">
        <h2 class="section-title">Proven Results</h2>
        <p class="section-subtitle">Real outcomes from real clients</p>
      </div>

      <div class="results-grid">
        <div class="result-card anim-reveal">
          <div class="result-icon"><i class="ph ph-trend-up"></i></div>
          <div class="result-number">6x</div>
          <div class="result-label">Revenue Growth</div>
          <div class="result-desc">$5K to $30K+ in 90 days</div>
        </div>

        <a href="https://therealjohndough.com/chief-strategist-hawk-fade-barbershop-gtm-strategy/" target="_blank" rel="noopener" class="result-card anim-reveal result-card-link">
          <div class="result-icon"><i class="ph ph-scissors"></i></div>
          <div class="result-number">40%</div>
          <div class="result-label">Repeat Booking Rate</div>
          <div class="result-desc">Within 60 days</div>
        </a>

        <div class="result-card anim-reveal">
          <div class="result-icon"><i class="ph ph-package"></i></div>
          <div class="result-number">350+</div>
          <div class="result-label">Compliant SKUs</div>
          <div class="result-desc">Brought to market across NY, CA, CO</div>
        </div>
      </div>

      <!-- Testimonials Grid -->
      <div class="testimonials-wrapper anim-reveal">
        <div class="testimonial-card">
          <div class="testimonial-quote">
            "Case Study Labs delivers quality creative work fast and turns concepts into tangible products seamlessly. Dough just gets it."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Madeline Hall</div>
              <div class="author-title">VP at Gameday Hospitality | Creative Director</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-quote">
            "Exceptional brand strategists who build visually compelling, revenue-ready identities. Their rare ability to align design, messaging, and market positioning is exactly what growing brands need. They stay ahead of trends, tell compelling stories, and get results."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Courtney Lynn</div>
              <div class="author-title">Cannabis Industry Specialist | Commercial Insurance Agent</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-quote">
            "Worked with Case Study Labs on multiple projects. Their attention to detail and marketing/branding expertise are exceptional. John combines legacy business knowledge with a professional approach to cannabis marketing. Highly recommended as a creative, collaborative partner."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Josh Alper</div>
              <div class="author-title">Blue Diamond Ventures Inc.</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-quote">
            "Few people have John's follow-through and work ethic. His strategic thinking, creative problem-solving, and communication skills make him invaluable for strategic planning, pitch decks, and fundraising."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Steven McMorrow</div>
              <div class="author-title">Cannabis Industry | Sales & Business Development</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-quote">
            "Solid professional agency with a strong portfolio. John brings wealth of ideas to creative campaigns and packaging design, helping brands present themselves memorably and appealingly."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Alex Fernandez</div>
              <div class="author-title">Founder, Engineer, Educator</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-quote">
            "John brings exceptional design expertise and proven track record in consumer product sales. Collaborative, professional, deadline-driven—he consistently delivers outstanding creative solutions that drive engagement and sales."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="ph ph-user-circle"></i>
            </div>
            <div class="author-info">
              <div class="author-name">Zachary Schneider</div>
              <div class="author-title">Founder at Agency 15</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Client Logos -->
      <div class="client-logos anim-reveal">
        <p class="logos-label">Trusted by industry leaders</p>
        <div class="logos-grid">
          <div class="logo-item">
            <img src="https://staging19.casestudy-labs.com/wp-content/uploads/2025/07/Asset-3@4x-scaled.png" alt="Client Logo" />
          </div>
          <div class="logo-item">
            <img src="https://staging19.casestudy-labs.com/wp-content/uploads/2025/06/cannabuffa-logo-scaled.png" alt="Cannabuff Logo" />
          </div>
          <div class="logo-item">
            <img src="https://staging19.casestudy-labs.com/wp-content/uploads/2025/06/SKYWORLD-LOGO-BLK-TRANSPARENT.png" alt="Skyworld Logo" />
          </div>
          <div class="logo-item">
            <img src="https://staging19.casestudy-labs.com/wp-content/uploads/2025/06/atc-logoAsset-5@3x.png" alt="ATC Logo" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Transparency -->
  <section class="pricing-section">
    <div class="container">
      <div class="section-header anim-reveal">
        <h2 class="section-title">Transparent Pricing</h2>
        <p class="section-subtitle">No hidden fees. No surprise costs. Just honest pricing.</p>
      </div>

      <div class="pricing-grid">
        <div class="pricing-card anim-reveal">
          <div class="pricing-label">Sprint</div>
          <div class="pricing-price">
            <span class="price-currency">$</span>
            <span class="price-amount">10k</span>
            <span class="price-period">/ project</span>
          </div>
          <div class="pricing-desc">Single phase or focused initiative</div>
          <ul class="pricing-features">
            <li><i class="ph ph-check"></i> 1-2 week delivery</li>
            <li><i class="ph ph-check"></i> One deliverable phase</li>
            <li><i class="ph ph-check"></i> Perfect for testing</li>
          </ul>
          <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-outline">Start Sprint</a>
        </div>

        <div class="pricing-card featured anim-reveal">
          <div class="pricing-badge">Most Popular</div>
          <div class="pricing-label">Full Process</div>
          <div class="pricing-price">
            <span class="price-currency">$</span>
            <span class="price-amount">39K–49K</span>
            <span class="price-period">/ project</span>
          </div>
          <div class="pricing-desc">Complete brand transformation</div>
          <ul class="pricing-features">
            <li><i class="ph ph-check"></i> 8-12 week delivery</li>
            <li><i class="ph ph-check"></i> All 6 phases included</li>
            <li><i class="ph ph-check"></i> Launch support</li>
          </ul>
          <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-accent">Get Started</a>
        </div>

        <div class="pricing-card anim-reveal">
          <div class="pricing-label">Enterprise</div>
          <div class="pricing-price">
            <span class="price-currency">$</span>
            <span class="price-amount">50k</span>
            <span class="price-period">+</span>
          </div>
          <div class="pricing-desc">Multi-market, multi-product brands</div>
          <ul class="pricing-features">
            <li><i class="ph ph-check"></i> Custom timeline</li>
            <li><i class="ph ph-check"></i> Dedicated team</li>
            <li><i class="ph ph-check"></i> Ongoing support</li>
          </ul>
          <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-outline">Contact Us</a>
        </div>
      </div>

      <div class="pricing-note anim-reveal">
        <i class="ph ph-info"></i>
        <p>All projects include revision rounds, project management, and 30 days post-launch support. Payment plans available.</p>
      </div>
    </div>
  </section>

  <!-- Case Study Integration -->
  <section class="case-studies-section">
    <div class="container">
      <div class="section-header anim-reveal">
        <h2 class="section-title">See The Process In Action</h2>
        <p class="section-subtitle">Real projects, real results</p>
      </div>

      <div class="case-studies-grid">
        <?php
        // Get selected case studies from customizer
        $selected_case_studies = array();
        for ($i = 1; $i <= 3; $i++) {
          $case_study_id = get_theme_mod('csl_process_case_study_' . $i, '');
          if (!empty($case_study_id)) {
            $selected_case_studies[] = $case_study_id;
          }
        }

        // If no case studies selected in customizer, fallback to 3 most recent
        if (empty($selected_case_studies)) {
          $case_studies = new WP_Query([
            'post_type' => 'casestudy',
            'posts_per_page' => 3,
            'post_status' => 'publish',
          ]);
        } else {
          $case_studies = new WP_Query([
            'post_type' => 'casestudy',
            'post__in' => $selected_case_studies,
            'orderby' => 'post__in',
            'post_status' => 'publish',
          ]);
        }

        if ($case_studies->have_posts()):
          while ($case_studies->have_posts()): $case_studies->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="case-study-card anim-reveal">
              <?php if (has_post_thumbnail()): ?>
                <div class="case-study-image">
                  <?php the_post_thumbnail('large'); ?>
                  <div class="case-study-overlay">
                    <span class="view-case-study">View Case Study <i class="ph ph-arrow-right"></i></span>
                  </div>
                </div>
              <?php endif; ?>
              <div class="case-study-content">
                <h3 class="case-study-title"><?php the_title(); ?></h3>
                <?php if (has_excerpt()): ?>
                  <p class="case-study-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                <?php endif; ?>
              </div>
            </a>
          <?php endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>

      <div class="case-studies-cta anim-reveal">
        <a href="<?php echo home_url('/case-studies'); ?>" class="btn btn-outline btn-large">
          View All Case Studies
        </a>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container-narrow">
      <div class="section-header anim-reveal">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">Everything you need to know</p>
      </div>

      <div class="faq-accordion">
        <?php foreach ($faq as $i => $qa): ?>
        <div class="faq-item anim-reveal">
          <button class="faq-question" aria-expanded="false">
            <span class="faq-q-text"><?php echo esc_html($qa['q']); ?></span>
            <i class="ph ph-caret-down faq-icon"></i>
          </button>
          <div class="faq-answer">
            <p><?php echo esc_html($qa['a']); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="faq-cta anim-reveal">
        <p>Still have questions?</p>
        <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-accent btn-large">
          Schedule a Call
        </a>
      </div>
    </div>
  </section>

  <!-- Final CTA Section -->
  <section class="final-cta-section">
    <div class="container-narrow text-center">
      <div class="final-cta-content anim-reveal">
        <h2 class="final-cta-title">Ready to Elevate Your Brand?</h2>
        <p class="final-cta-desc">Let's build something iconic together. Book a free discovery call to discuss your project.</p>
        <div class="final-cta-buttons">
          <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-accent btn-xl">
            <i class="ph ph-paper-plane-tilt"></i>
            Start Your Project
          </a>
          <a href="<?php echo esc_url($cta_secondary_url); ?>" class="btn btn-outline btn-xl">
            <i class="ph ph-info"></i>
            Learn More
          </a>
        </div>
        <div class="final-cta-trust">
          <i class="ph ph-shield-check"></i>
          <span>No obligation. Free consultation. Real results.</span>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Enhanced Styles -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/process-enhanced.css">

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Sticky CTA Bar
  const stickyCTA = document.getElementById('stickyCTA');
  let lastScroll = 0;

  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 800) {
      stickyCTA.classList.add('visible');
    } else {
      stickyCTA.classList.remove('visible');
    }

    lastScroll = currentScroll;
  });

  // Timeline Step Toggles
  const stepToggles = document.querySelectorAll('.step-toggle');
  stepToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
      const step = this.closest('.timeline-step');
      const body = step.querySelector('.step-body');
      const isExpanded = this.getAttribute('aria-expanded') === 'true';

      // Close all other steps
      document.querySelectorAll('.timeline-step').forEach(s => {
        if (s !== step) {
          s.classList.remove('expanded');
          s.querySelector('.step-toggle').setAttribute('aria-expanded', 'false');
        }
      });

      // Toggle current step
      step.classList.toggle('expanded');
      this.setAttribute('aria-expanded', !isExpanded);
    });
  });

  // FAQ Accordion
  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(question => {
    question.addEventListener('click', function() {
      const item = this.closest('.faq-item');
      const isExpanded = this.getAttribute('aria-expanded') === 'true';

      // Close all other items
      document.querySelectorAll('.faq-item').forEach(i => {
        if (i !== item) {
          i.classList.remove('active');
          i.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
        }
      });

      // Toggle current item
      item.classList.toggle('active');
      this.setAttribute('aria-expanded', !isExpanded);
    });
  });

  // Scroll Reveal Animation
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, observerOptions);

  document.querySelectorAll('.anim-reveal').forEach(el => {
    observer.observe(el);
  });
});
</script>

<?php get_footer(); ?>
