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

    <!-- Unlimited Creative Overview -->
    <section class="section bg-surface">
        <div class="container container-narrow">
            <h2 class="section-heading">Unlimited Creative: Make Every Idea a Reality</h2>
            <p>At Case Study Labs, we don&rsquo;t believe in half-measures. Your brand deserves a steady stream of smart, bold creative that keeps your audience engaged. Unlimited Creative is our monthly subscription that gives you ongoing access to our premium design team without the bloated retainers or mystery invoices.</p>
            <h3>Why Unlimited?</h3>
            <ul class="feature-list">
                <li><strong>Unlimited Requests &amp; Revisions:</strong> Submit as many design, web, or content requests as you need. We&rsquo;ll keep working until you&rsquo;re satisfied&mdash;no additional fees, no surprises.</li>
                <li><strong>Transparent Hours:</strong> Each plan includes a fixed amount of creative hours per business day. We timebox tasks, log our hours, and send you clear daily and weekly updates.</li>
                <li><strong>Fast Turnaround:</strong> Our Lite and Core plans deliver 24&ndash; to 48-hour turnaround on most requests; Studio+ and Enterprise offer same-day rush when you need it.</li>
                <li><strong>Strategic Partnership:</strong> Higher tiers include a dedicated creative director who acts as your brand guardian, ensuring your work stays cohesive and on-message.</li>
                <li><strong>Slack &amp; Notion Portal Access:</strong> Collaborate in real time, leave feedback, and track progress from a shared dashboard&mdash;no more emails lost to the void.</li>
            </ul>
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

    <!-- Unlimited Creative Overview -->
    <section class="section bg-surface">
        <div class="container">
            <h2>Unlimited Creative: Make Every Idea a Reality</h2>
            <p class="section-intro">At Case Study Labs, we don&rsquo;t believe in half-measures. Your brand deserves a steady stream of smart, bold creative that keeps your audience engaged. Unlimited Creative is our monthly subscription that gives you ongoing access to our premium design team without the bloated retainers or mystery invoices.</p>

            <div class="glass-panel anim-reveal" style="margin-bottom: 2rem;">
                <h3>Why Unlimited?</h3>
                <ul class="checklist">
                    <li><strong>Unlimited Requests &amp; Revisions:</strong> Submit as many design, web, or content requests as you need. We&rsquo;ll keep working until you&rsquo;re satisfied&mdash;no additional fees, no surprises.</li>
                    <li><strong>Transparent Hours:</strong> Each plan includes a fixed amount of creative hours per business day. We timebox tasks, log our hours, and send you clear daily and weekly updates.</li>
                    <li><strong>Fast Turnaround:</strong> Our Lite and Core plans deliver 24- to 48-hour turnaround on most requests; Studio+ and Enterprise offer same-day rush when you need it.</li>
                    <li><strong>Strategic Partnership:</strong> Higher tiers include a dedicated creative director who acts as your brand guardian, ensuring your work stays cohesive and on-message.</li>
                    <li><strong>Slack &amp; Notion Portal Access:</strong> Collaborate in real time, leave feedback, and track progress from a shared dashboard&mdash;no more emails lost to the void.</li>
                </ul>
            </div>

            <h3>Choose Your Plan</h3>
    <!-- Choose Your Plan Table -->
    <section class="section bg-surface">
        <div class="container">
            <h2>Choose Your Plan</h2>
            <div class="table-scroll">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Daily Access Time</th>
                            <th>Monthly Estimate</th>
                            <th>Price Range</th>
                            <th>Best For</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lite Unlimited</td>
                            <td>2 hrs/day</td>
                            <td>~40 hrs/month</td>
                            <td>$2,000&ndash;$2,500</td>
                            <td>Ongoing updates, social graphics, simple web tasks</td>
                        </tr>
                        <tr>
                            <td>Core Unlimited</td>
                            <td>4 hrs/day</td>
                            <td>~80 hrs/month</td>
                            <td>$3,500&ndash;$5,000</td>
                            <td>Multi-channel campaigns, brand assets, regular web updates</td>
                        </tr>
                        <tr>
                            <td>Studio+</td>
                            <td>6 hrs/day</td>
                            <td>~120 hrs/month</td>
                            <td>$6,500+</td>
                            <td>Motion graphics, front-end dev, complex brand systems</td>
                        </tr>
                        <tr>
                            <td>Enterprise</td>
                            <td>8+ hrs/day</td>
                            <td>160+ hrs/month</td>
                            <td>Custom quote</td>
                            <td>Large-scale teams, white-label partnerships</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="glass-panel anim-reveal" style="margin-top: 2rem;">
                <h3>How It Works</h3>
                <ol class="ordered-steps">
                    <li><strong>Request:</strong> You submit tasks via our portal or Slack&mdash;anything from a social campaign to a product mockup.</li>
                    <li><strong>Prioritize:</strong> We triage and queue your requests based on urgency and daily available hours. Only a handful of tasks are live at once to ensure focus.</li>
                    <li><strong>Design &amp; Deliver:</strong> Our team works in 1&ndash;2 hour sprints per day, delivering drafts, revisions, and final files in Figma, WordPress, or your preferred tool.</li>
                    <li><strong>Update:</strong> You receive a daily digest of completed work and a weekly recap summarizing hours used and priorities for the coming week.</li>
                    <li><strong>Repeat:</strong> Need something new? Fire off another request. It&rsquo;s unlimited.</li>
                </ol>
                <p>No fluff. No guesswork. Unlimited Creative gets real work done&mdash;fast.</p>
            </div>
        </div>
    </section>

    <!-- Unlimited Creative Benefits -->
    <!-- How It Works -->
    <section class="section">
        <div class="container container-narrow">
            <h2>How It Works</h2>
            <ol class="numbered-list">
                <li><strong>Request:</strong> You submit tasks via our portal or Slack&mdash;anything from a social campaign to a product mockup.</li>
                <li><strong>Prioritize:</strong> We triage and queue your requests based on urgency and daily available hours. Only a handful of tasks are live at once to ensure focus.</li>
                <li><strong>Design &amp; Deliver:</strong> Our team works in 1&ndash;2 hour sprints per day, delivering drafts, revisions, and final files in Figma, WordPress, or your preferred tool.</li>
                <li><strong>Update:</strong> You receive a daily digest of completed work and a weekly recap summarizing hours used and priorities for the coming week.</li>
                <li><strong>Repeat:</strong> Need something new? Fire off another request. It&rsquo;s unlimited.</li>
            </ol>
            <p>No fluff. No guesswork. Unlimited Creative gets real work done&mdash;fast.</p>
        </div>
    </section>

    <!-- What's Included -->
    <section class="section bg-surface">
        <div class="container">
            <h2>What&rsquo;s Included in Every Subscription</h2>
            <div class="grid grid-2">
                <ul>
                    <li>Unlimited design, web, and content requests</li>
                    <li>Unlimited revisions within your daily time block</li>
                    <li>Transparent time tracking and weekly reports</li>
                    <li>24&ndash;48-hour average turnaround (same-day rush on Studio+/Enterprise)</li>
                    <li>Dedicated Slack/Notion portal</li>
                    <li>Access to our full creative toolkit: Figma, WordPress, Adobe CC, motion graphics, and more</li>
                </ul>
                <div>
                    <h3>Extras at Higher Tiers</h3>
                    <ul>
                        <li>Dedicated creative director oversight</li>
                        <li>Priority queue management and overflow support</li>
                        <li>Motion graphics and basic video editing</li>
                        <li>Strategy consultation in monthly check-ins (Core Unlimited and above)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Unlimited Creative FAQs -->
    <section class="section">
        <div class="container container-narrow">
            <h2>Unlimited Creative FAQs</h2>
            <div class="faq-accordion">
                <details class="faq-item" open>
                    <summary class="faq-question">What if I need something big, like a website?</summary>
                    <div class="faq-answer">
                        <p>Large projects are broken into phases or scoped separately, ensuring you still receive the benefits of unlimited requests without blowing through your daily time block.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">Can I pause my subscription?</summary>
                    <div class="faq-answer">
                        <p>Core Unlimited and higher plans may pause once per quarter with advance notice. Pausing Lite Unlimited suspends your access until you resume&mdash;no rollovers.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">Do unused hours carry over?</summary>
                    <div class="faq-answer">
                        <p>No. Our model focuses on daily creative bursts. Consistency keeps momentum high and reduces bottlenecks.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">What&rsquo;s not included?</summary>
                    <div class="faq-answer">
                        <p>Apps, major strategic engagements, and SEO-heavy campaigns require separate quotes. We can still handle them&mdash;just not within the Unlimited Creative subscription.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- Pricing Tiers Section -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2" style="gap: 2rem;">
                <div class="glass-panel anim-reveal">
                    <h3>What&rsquo;s Included in Every Subscription</h3>
                    <ul class="checklist">
                        <li>Unlimited design, web, and content requests</li>
                        <li>Unlimited revisions within your daily time block</li>
                        <li>Transparent time tracking and weekly reports</li>
                        <li>24&ndash;48-hour average turnaround (same-day rush on Studio+/Enterprise)</li>
                        <li>Dedicated Slack/Notion portal</li>
                        <li>Access to our full creative toolkit: Figma, WordPress, Adobe CC, motion graphics, and more</li>
                    </ul>
                </div>
                <div class="glass-panel anim-reveal" style="--stagger-index: 1;">
                    <h3>Extras at Higher Tiers</h3>
                    <ul class="checklist">
                        <li>Dedicated creative director oversight</li>
                        <li>Priority queue management and overflow support</li>
                        <li>Motion graphics and basic video editing</li>
                        <li>Strategy consultation in monthly check-ins (Core Unlimited and above)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Unlimited Creative FAQs -->
    <section class="section bg-surface">
        <div class="container">
            <h2>Unlimited Creative FAQs</h2>
            <div class="faq-accordion">
                <details class="faq-item" open>
                    <summary class="faq-question">What if I need something big, like a website?</summary>
                    <div class="faq-answer">
                        <p>Large projects are broken into phases or scoped separately, ensuring you still receive the benefits of unlimited requests without blowing through your daily time block.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">Can I pause my subscription?</summary>
                    <div class="faq-answer">
                        <p>Core Unlimited and higher plans may pause once per quarter with advance notice. Pausing Lite Unlimited suspends your access until you resume&mdash;no rollovers.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">Do unused hours carry over?</summary>
                    <div class="faq-answer">
                        <p>No. Our model focuses on daily creative bursts. Consistency keeps momentum high and reduces bottlenecks.</p>
                    </div>
                </details>
                <details class="faq-item">
                    <summary class="faq-question">What&rsquo;s not included?</summary>
                    <div class="faq-answer">
                        <p>Apps, major strategic engagements, and SEO-heavy campaigns require separate quotes. We can still handle them&mdash;just not within the Unlimited Creative subscription.</p>
                    </div>
                </details>
            </div>
            <div class="text-center" style="margin-top: 2rem;">
                <p class="section-intro">Ready to turn your backlog into a brand asset machine?</p>
                <a href="<?php echo esc_url(csl_get_cta_link('pricing_tiers', 'process_page', 'cta')); ?>" class="btn btn-primary">Get Started Today</a>
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