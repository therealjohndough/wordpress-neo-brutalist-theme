<?php
/**
 * Template Name: Service Landing Page
 * Description: A reusable landing page for individual services.
 *
 * @package Aura-Grid_Machina_Enhanced
 */

get_header(); ?>

<main id="main-content">
    <?php
    // Pull ACF fields with fallbacks
    $hero_title      = get_field('service_hero_title') ?: get_the_title();
    $hero_subtitle   = get_field('service_hero_subtitle');
    $hero_intro      = get_field('service_hero_intro');

    $offerings_heading = get_field('offerings_heading') ?: 'What We Offer';
    $detailed_process  = get_field('service_detailed_process');

    $cta_heading     = get_field('cta_heading') ?: 'Ready to Elevate Your Brand?';
    $cta_subheading  = get_field('cta_subheading') ?: "Let's discuss how our expertise can drive your success.";
    $cta_button_text = get_field('cta_button_text') ?: 'Start a Project';
    $cta_button_link = get_field('cta_button_link') ?: home_url('/contact');
    ?>

    <!-- ========================= HERO SECTION =============================== -->
    <section class="hero">
        <div class="hero-content container text-center">
            <?php if ($hero_subtitle) : ?>
                <p class="h4 anim-reveal" style="color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.1em; transition-delay: 0.1s;">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            <?php endif; ?>
            <h1 class="headline anim-reveal text-gradient" data-text="<?php echo esc_attr($hero_title); ?>">
                <?php echo esc_html($hero_title); ?>
            </h1>
            <?php if ($hero_intro) : ?>
                <p class="hero-intro anim-reveal" style="transition-delay: 0.2s;">
                    <?php echo esc_html($hero_intro); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ========================= WHAT WE OFFER ============================= -->
    <section class="container">
        <h2 class="section-heading anim-reveal">
            <?php echo esc_html($offerings_heading); ?>
        </h2>

        <?php if (have_rows('service_offerings')) : ?>
            <div class="services-grid service-offerings-enhanced" style="margin-top: 4rem;">
                <?php
                $stagger_index = 0;
                while (have_rows('service_offerings')) : the_row();
                    $stagger_index++;
                    $offering_title       = get_sub_field('offering_title');
                    $offering_description = get_sub_field('offering_description');
                    $offering_icon        = get_sub_field('offering_icon') ?: 'ph-sparkle';
                    ?>
                    <div class="service-offering-card glass-medium anim-reveal hover-lift" style="--stagger-index: <?php echo esc_attr($stagger_index); ?>;">
                        <div class="offering-icon-wrapper">
                            <i class="ph <?php echo esc_attr($offering_icon); ?>" aria-hidden="true"></i>
                        </div>
                        <div class="offering-content">
                            <h3 class="offering-title"><?php echo esc_html($offering_title); ?></h3>
                            <p class="offering-description"><?php echo esc_html($offering_description); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- ========================= DETAILED PROCESS ========================== -->
    <?php if ($detailed_process) : ?>
        <section class="container-narrow">
            <div class="glass-panel anim-reveal">
                <div class="content-wrapper">
                    <?php echo wp_kses_post($detailed_process); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ========================= FAQ ACCORDION ============================= -->
    <?php if (have_rows('service_faqs')) : ?>
        <section class="container-narrow">
            <h2 class="section-heading anim-reveal">
                <?php _e('Frequently Asked Questions', 'auragrid'); ?>
            </h2>
            <div class="faq-accordion-enhanced anim-reveal" style="margin-top: 3rem; transition-delay: 0.1s;">
                <?php
                $faq_index = 0;
                while (have_rows('service_faqs')) : the_row();
                    $faq_index++;
                    $question = get_sub_field('faq_question');
                    $answer   = get_sub_field('faq_answer');
                    ?>
                    <details class="faq-item-enhanced" style="--faq-index: <?php echo esc_attr($faq_index); ?>;">
                        <summary class="faq-question-enhanced">
                            <span class="faq-icon"><i class="ph ph-plus-circle" aria-hidden="true"></i></span>
                            <span class="faq-text"><?php echo esc_html($question); ?></span>
                        </summary>
                        <div class="faq-answer-enhanced">
                            <p><?php echo esc_html($answer); ?></p>
                        </div>
                    </details>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ========================= PRICING & PACKAGES ========================== -->
    <section id="pricing" class="section bg-surface">
        <div class="container">
            <h2 class="section-heading anim-reveal">Pricing & Packages</h2>
            <p class="section-intro anim-reveal" style="transition-delay: 0.1s;">Choose the package that fits your project's scope and timeline.</p>

            <div class="packages-grid">
                <!-- Mini Sprint Package -->
                <div class="package-card anim-reveal" style="transition-delay: 0.2s;">
                    <div class="package-header">
                        <h3>Mini Sprint</h3>
                        <div class="package-price">$3K–$5K</div>
                    </div>
                    <div class="package-timeline">3–5 days</div>
                    <div class="package-content">
                        <p>Quick validation or single phase focus</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>Discovery & Strategy OR Design & Development</li>
                                <li>Basic deliverables</li>
                                <li>1-2 day delivery</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Full project scope</li>
                                <li>Content creation</li>
                                <li>Ongoing support</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('mini_sprint', 'services_page', 'package_cta')); ?>" class="btn btn-secondary">Start Mini Sprint</a>
                </div>

                <!-- Sprint Package -->
                <div class="package-card anim-reveal" style="transition-delay: 0.3s;">
                    <div class="package-header">
                        <h3>Sprint</h3>
                        <div class="package-price">$8K–$12K</div>
                    </div>
                    <div class="package-timeline">1–2 weeks</div>
                    <div class="package-content">
                        <p>Quick wins or testing</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>One phase only (Discovery & Strategy OR Launch & Optimize)</li>
                                <li>Design sprint limited to 2 templates</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Full brand development</li>
                                <li>Complete website build</li>
                                <li>Content creation</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('sprint', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Start Sprint</a>
                </div>

                <!-- Mini Core Package -->
                <div class="package-card anim-reveal" style="transition-delay: 0.4s;">
                    <div class="package-header">
                        <h3>Mini Core</h3>
                        <div class="package-price">$15K–$20K</div>
                    </div>
                    <div class="package-timeline">4–6 weeks</div>
                    <div class="package-content">
                        <p>Essential features for MVPs</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>Discovery & Strategy</li>
                                <li>Limited Design & Development</li>
                                <li>Basic Content & Campaigns</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Full brand identity</li>
                                <li>Advanced integrations</li>
                                <li>Launch & Optimize phase</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('mini_core', 'services_page', 'package_cta')); ?>" class="btn btn-accent">Choose Mini Core</a>
                </div>

                <!-- Core Four Package -->
                <div class="package-card anim-reveal" style="transition-delay: 0.5s;">
                    <div class="package-header">
                        <h3>Core Four</h3>
                        <div class="package-price">$32K–$40K</div>
                    </div>
                    <div class="package-timeline">6–8 weeks</div>
                    <div class="package-content">
                        <p>Growing brands needing full identity</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>Discovery & Strategy</li>
                                <li>Brand Foundation</li>
                                <li>Design & Development (limited)</li>
                                <li>Content & Campaigns</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Launch & Optimize phase</li>
                                <li>Growth & Scale planning</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('core_four', 'services_page', 'package_cta')); ?>" class="btn btn-accent">Choose Core Four</a>
                </div>

                <!-- Full Process Package -->
                <div class="package-card featured anim-reveal" style="transition-delay: 0.6s;">
                    <div class="package-header">
                        <h3>Full Process</h3>
                        <div class="package-price">$39K–$49K</div>
                    </div>
                    <div class="package-timeline">8–12 weeks</div>
                    <div class="package-content">
                        <p>Premium brands defining categories</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>Discovery & Strategy</li>
                                <li>Brand Foundation</li>
                                <li>Design & Development</li>
                                <li>Content & Campaigns</li>
                                <li>Launch & Optimize</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Growth & Scale phase</li>
                                <li>Dedicated team</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('full_process', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Choose Full Process</a>
                </div>

                <!-- Enterprise Package -->
                <div class="package-card anim-reveal" style="transition-delay: 0.7s;">
                    <div class="package-header">
                        <h3>Enterprise</h3>
                        <div class="package-price">$55K+</div>
                    </div>
                    <div class="package-timeline">12–20 weeks</div>
                    <div class="package-content">
                        <p>Large-scale or multi-brand projects</p>
                        <div class="package-features">
                            <h4>Included:</h4>
                            <ul>
                                <li>All phases including Growth & Scale customized</li>
                                <li>Dedicated team</li>
                                <li>Custom integrations</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Not Included:</h4>
                            <ul>
                                <li>Nothing - fully customized</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('enterprise', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Contact for Enterprise</a>
                </div>
            </div>

            <!-- Process Phases Explanation -->
            <div class="packages-note anim-reveal" style="transition-delay: 0.8s;">
                <h3>Our Process Phases</h3>
                <div class="grid grid-3">
                    <div>
                        <h4>Discovery & Strategy</h4>
                        <p>Research, planning, and project roadmap development.</p>
                    </div>
                    <div>
                        <h4>Brand Foundation</h4>
                        <p>Logo design, brand guidelines, and identity system creation.</p>
                    </div>
                    <div>
                        <h4>Design & Development</h4>
                        <p>UI/UX design, website development, and custom features.</p>
                    </div>
                    <div>
                        <h4>Content & Campaigns</h4>
                        <p>Copywriting, content strategy, and marketing assets.</p>
                    </div>
                    <div>
                        <h4>Launch & Optimize</h4>
                        <p>Deployment, testing, and performance optimization.</p>
                    </div>
                    <div>
                        <h4>Growth & Scale</h4>
                        <p>Analytics, A/B testing, and expansion planning.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================= FINAL CTA ================================ -->
    <section class="container-narrow">
        <div class="glass-panel text-center anim-reveal glow-primary">
            <h2 class="h3 mt-0 mb-1"><?php echo esc_html($cta_heading); ?></h2>
            <p class="mb-2" style="color: var(--color-text-secondary);">
                <?php echo esc_html($cta_subheading); ?>
            </p>
            <a href="<?php echo esc_url($cta_button_link); ?>" class="btn" style="margin-bottom: 1rem;">
                <?php echo esc_html($cta_button_text); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
