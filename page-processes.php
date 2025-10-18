<?php
/**
 * Template Name: Processes Page
 * Description: Custom template for the processes workflow page with expandable pricing and compare packages table.
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero bg-cover bg-center" style="background-image: url('<?php echo get_field('hero_background_image'); ?>');">
        <div class="container">
            <h1 class="headline"><?php the_field('hero_headline'); ?></h1>
            <p class="hero-intro"><?php the_field('hero_subheadline'); ?></p>
            <div class="hero-cta">
                <a href="<?php echo get_field('cta_link'); ?>" class="btn btn-primary"><?php the_field('cta_text'); ?></a>
            </div>
        </div>
    </section>

    <!-- Process Steps Section with Expandable Pricing -->
    <section class="section">
        <div class="container">
            <h2 class="section-heading"><?php the_field('steps_section_title'); ?></h2>
            <div class="timeline">
                <?php if (have_rows('process_steps')): ?>
                    <?php while (have_rows('process_steps')): the_row(); ?>
                        <div class="process-step anim-reveal">
                            <details class="step-details">
                                <summary class="step-summary glass-panel">
                                    <div class="step-header">
                                        <div class="step-icon">
                                            <img src="<?php the_sub_field('step_icon'); ?>" alt="<?php the_sub_field('step_title'); ?>">
                                        </div>
                                        <div class="step-content">
                                            <h3><?php the_sub_field('step_title'); ?></h3>
                                            <p><?php the_sub_field('step_description'); ?></p>
                                            <div class="step-pricing-preview">
                                                <span class="pricing-label">Starting at:</span>
                                                <span class="pricing-amount"><?php the_sub_field('step_pricing_preview'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </summary>
                                <div class="step-expanded">
                                    <div class="pricing-details">
                                        <h4>Pricing Breakdown</h4>
                                        <ul>
                                            <?php if (have_rows('step_pricing_details')): ?>
                                                <?php while (have_rows('step_pricing_details')): the_row(); ?>
                                                    <li><?php the_sub_field('pricing_item'); ?>: <?php the_sub_field('pricing_amount'); ?></li>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </ul>
                                        <p class="pricing-note"><?php the_sub_field('step_pricing_note'); ?></p>
                                        <a href="<?php echo esc_url(csl_get_cta_link('pricing_tiers', 'process_page', 'cta')); ?>" class="btn btn-secondary">Get Quote</a>
                                    </div>
                                </div>
                            </details>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Compare Packages Table -->
    <section class="section bg-surface">
        <div class="container">
            <h2>Compare Packages</h2>
            <div class="table-scroll">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Included Phases</th>
                            <th>Timeline</th>
                            <th>Price (USD)</th>
                            <th>Who it's for</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sprint</td>
                            <td>One phase only (Discovery & Strategy OR Launch & Optimize; Design sprint limited to 2 templates)</td>
                            <td>1–2 weeks</td>
                            <td>$8K–$12K</td>
                            <td>Quick wins or testing</td>
                        </tr>
                        <tr>
                            <td>Core Four</td>
                            <td>Discovery & Strategy, Brand Foundation, Design & Development (limited), Content & Campaigns</td>
                            <td>6–8 weeks</td>
                            <td>$32K–$40K</td>
                            <td>Growing brands needing full identity</td>
                        </tr>
                        <tr>
                            <td>Full Process</td>
                            <td>Discovery & Strategy, Brand Foundation, Design & Development, Content & Campaigns, Launch & Optimize</td>
                            <td>8–12 weeks</td>
                            <td>$39K–$49K</td>
                            <td>Premium brands defining categories</td>
                        </tr>
                        <tr>
                            <td>Enterprise</td>
                            <td>All phases including Growth & Scale customized, dedicated team, custom integrations</td>
                            <td>12–20 weeks</td>
                            <td>$55K+</td>
                            <td>Large-scale or multi-brand projects</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Pricing Tiers Section -->
    <section class="section">
        <div class="container">
            <h2>Pricing That Matches Your Journey</h2>
            <p>Our packages align with your project's complexity and our process stages.</p>
            <div class="pricing-grid">
                <?php if (have_rows('pricing_tiers')): ?>
                    <?php while (have_rows('pricing_tiers')): the_row(); ?>
                        <div class="pricing-card">
                            <h3><?php the_sub_field('tier_name'); ?></h3>
                            <div class="tier-price"><?php the_sub_field('tier_price'); ?></div>
                            <p><?php the_sub_field('tier_description'); ?></p>
                            <ul>
                                <?php if (have_rows('tier_features')): ?>
                                    <?php while (have_rows('tier_features')): the_row(); ?>
                                        <li><?php the_sub_field('feature'); ?></li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>
                            <a href="<?php echo esc_url(csl_get_cta_link('pricing_tiers', 'process_page', 'cta')); ?>" class="btn btn-primary">Get Started</a>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h2>Testimonials</h2>
            <div class="grid grid-3">
                <?php if (have_rows('testimonials')): ?>
                    <?php while (have_rows('testimonials')): the_row(); ?>
                        <blockquote class="card">
                            <p><?php the_sub_field('testimonial_text'); ?></p>
                            <cite><?php the_sub_field('client_name'); ?></cite>
                        </blockquote>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="section">
        <div class="container">
            <h2>FAQs</h2>
            <div class="faq-accordion">
                <?php if (have_rows('faqs')): ?>
                    <?php while (have_rows('faqs')): the_row(); ?>
                        <details class="faq-item">
                            <summary class="faq-question"><?php the_sub_field('question'); ?></summary>
                            <div class="faq-answer">
                                <p><?php the_sub_field('answer'); ?></p>
                            </div>
                        </details>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Related Case Studies -->
    <section class="section">
        <div class="container">
            <h2>Related Case Studies</h2>
            <div class="project-grid">
                <?php
                $related_posts = get_field('related_case_studies');
                if ($related_posts): ?>
                    <?php foreach ($related_posts as $post): setup_postdata($post); ?>
                        <div class="project-card">
                            <div class="card-image-wrapper">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="card-content">
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-ghost">View Case</a>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="section bg-primary text-center">
        <div class="container">
            <h2>Ready to Start?</h2>
            <p>Let's turn your ideas into results.</p>
            <a href="/contact" class="btn btn-secondary">Get Started</a>
        </div>
    </section>
</main>

<?php get_footer(); ?>