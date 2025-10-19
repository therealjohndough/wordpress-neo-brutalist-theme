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

    <!-- ========================= UNLIMITED CREATIVE ========================== -->
    <section id="pricing" class="section bg-surface">
        <div class="container">
            <h2 class="section-heading anim-reveal">Unlimited Creative: Make Every Idea a Reality</h2>
            <p class="section-intro anim-reveal" style="transition-delay: 0.1s;">At Case Study Labs, we don&rsquo;t believe in half-measures. Unlimited Creative is our monthly subscription that gives you ongoing access to our premium design team without bloated retainers or mystery invoices.</p>

            <div class="glass-panel anim-reveal" style="transition-delay: 0.2s; margin-bottom: 2rem;">
                <h3>Why Unlimited?</h3>
                <ul class="checklist">
                    <li><strong>Unlimited Requests &amp; Revisions:</strong> Submit as many design, web, or content requests as you need. We&rsquo;ll keep working until you&rsquo;re satisfied&mdash;no additional fees, no surprises.</li>
                    <li><strong>Transparent Hours:</strong> Each plan includes a fixed amount of creative hours per business day. We timebox tasks, log our hours, and send you clear daily and weekly updates.</li>
                    <li><strong>Fast Turnaround:</strong> Our Lite and Core plans deliver 24- to 48-hour turnaround on most requests; Studio+ and Enterprise offer same-day rush when you need it.</li>
                    <li><strong>Strategic Partnership:</strong> Higher tiers include a dedicated creative director who keeps your work cohesive and on-message.</li>
                    <li><strong>Slack &amp; Notion Portal Access:</strong> Collaborate in real time, leave feedback, and track progress from a shared dashboard&mdash;no more emails lost to the void.</li>
                </ul>
            </div>

            <h3 class="anim-reveal" style="transition-delay: 0.3s;">Choose Your Plan</h3>
            <div class="table-scroll anim-reveal" style="transition-delay: 0.4s;">
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

            <div class="glass-panel anim-reveal" style="transition-delay: 0.5s; margin-top: 2rem;">
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

            <div class="grid grid-2 anim-reveal" style="gap: 2rem; margin-top: 2rem; transition-delay: 0.6s;">
                <div class="glass-panel">
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
                <div class="glass-panel">
                    <h3>Extras at Higher Tiers</h3>
                    <ul class="checklist">
                        <li>Dedicated creative director oversight</li>
                        <li>Priority queue management and overflow support</li>
                        <li>Motion graphics and basic video editing</li>
                        <li>Strategy consultation in monthly check-ins (Core Unlimited and above)</li>
                    </ul>
                </div>
            </div>

            <div class="glass-panel anim-reveal" style="transition-delay: 0.7s; margin-top: 2rem;">
                <h3>FAQs</h3>
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
                    <p>Each plan is month-to-month&mdash;no rollovers, no banked hours. If you need a full website or app build, we&rsquo;ll scope it separately.</p>
                    <a href="<?php echo esc_url(csl_get_cta_link('core_unlimited', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Get Started Today</a>
            <div class="packages-grid">
                <!-- Lite Unlimited -->
                <div class="package-card anim-reveal" style="transition-delay: 0.2s;">
                    <div class="package-header">
                        <h3>Lite Unlimited</h3>
                        <div class="package-price">$2,000&ndash;$2,500</div>
                    </div>
                    <div class="package-timeline">2 hrs/day &bull; ~40 hrs/month</div>
                    <div class="package-content">
                        <p>Perfect for ongoing updates, social graphics, and simple web tasks that keep momentum moving.</p>
                        <div class="package-features">
                            <h4>Highlights:</h4>
                            <ul>
                                <li>Unlimited design, web, and content requests</li>
                                <li>24&ndash;48 hour turnaround on most tasks</li>
                                <li>Daily Slack/Notion updates</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Ideal For:</h4>
                            <ul>
                                <li>Marketing teams needing consistent production</li>
                                <li>Light web maintenance and template tweaks</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('lite_unlimited', 'services_page', 'package_cta')); ?>" class="btn btn-secondary">Choose Lite Unlimited</a>
                </div>

                <!-- Core Unlimited -->
                <div class="package-card anim-reveal" style="transition-delay: 0.3s;">
                    <div class="package-header">
                        <h3>Core Unlimited</h3>
                        <div class="package-price">$3,500&ndash;$5,000</div>
                    </div>
                    <div class="package-timeline">4 hrs/day &bull; ~80 hrs/month</div>
                    <div class="package-content">
                        <p>Scale multi-channel campaigns, launch new brand assets, and keep your site fresh with on-demand support.</p>
                        <div class="package-features">
                            <h4>Highlights:</h4>
                            <ul>
                                <li>Unlimited requests with transparent daily timeboxing</li>
                                <li>Creative director check-ins each month</li>
                                <li>Weekly reports with priorities and hours used</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Ideal For:</h4>
                            <ul>
                                <li>Marketing leaders juggling multiple channels</li>
                                <li>Brands expanding their campaign calendar</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('core_unlimited', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Choose Core Unlimited</a>
                </div>

                <!-- Studio+ -->
                <div class="package-card featured anim-reveal" style="transition-delay: 0.4s;">
                    <div class="package-header">
                        <h3>Studio+</h3>
                        <div class="package-price">$6,500+</div>
                    </div>
                    <div class="package-timeline">6 hrs/day &bull; ~120 hrs/month</div>
                    <div class="package-content">
                        <p>Unlock motion graphics, front-end development, and complex brand systems with a senior creative pod.</p>
                        <div class="package-features">
                            <h4>Highlights:</h4>
                            <ul>
                                <li>Same-day rush support when you need it</li>
                                <li>Motion graphics and basic video editing</li>
                                <li>Advanced dev and design collaboration</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Ideal For:</h4>
                            <ul>
                                <li>Product teams launching complex experiences</li>
                                <li>Brands refreshing across channels in tandem</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('studio_plus', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Choose Studio+</a>
                </div>

                <!-- Enterprise -->
                <div class="package-card anim-reveal" style="transition-delay: 0.5s;">
                    <div class="package-header">
                        <h3>Enterprise</h3>
                        <div class="package-price">Custom Quote</div>
                    </div>
                    <div class="package-timeline">8+ hrs/day &bull; 160+ hrs/month</div>
                    <div class="package-content">
                        <p>Dedicated team support for large-scale organizations and white-label partners that need relentless creative velocity.</p>
                        <div class="package-features">
                            <h4>Highlights:</h4>
                            <ul>
                                <li>Priority queue management and overflow coverage</li>
                                <li>Embedded creative director and strategy support</li>
                                <li>Custom tooling and integration workflows</li>
                            </ul>
                        </div>
                        <div class="package-exclusions">
                            <h4>Ideal For:</h4>
                            <ul>
                                <li>Enterprise teams coordinating multiple brands</li>
                                <li>Agencies seeking a white-label creative partner</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(csl_get_cta_link('enterprise_unlimited', 'services_page', 'package_cta')); ?>" class="btn btn-primary">Start Enterprise Discovery</a>
                </div>
            </div>

            <!-- Process Phases Explanation -->
            <div class="packages-note anim-reveal" style="transition-delay: 0.6s;">
                <h3>Every Plan Includes</h3>
                <div class="grid grid-3">
                    <div>
                        <h4>Unlimited Requests</h4>
                        <p>Queue design, web, and content needs without worrying about overages or surprise invoices.</p>
                    </div>
                    <div>
                        <h4>Daily Progress Updates</h4>
                        <p>Track hours, deliverables, and next steps from a shared Slack + Notion workspace.</p>
                    </div>
                    <div>
                        <h4>Creative Toolkit</h4>
                        <p>Collaborate with us in Figma, WordPress, Adobe CC, and our full production stack.</p>
                    </div>
                    <div>
                        <h4>Strategic Support</h4>
                        <p>Core Unlimited and above add creative director oversight to keep everything on-message.</p>
                    </div>
                    <div>
                        <h4>Fast Turnarounds</h4>
                        <p>24&ndash;48 hour delivery on most requests, with same-day rush options for Studio+ and Enterprise.</p>
                    </div>
                    <div>
                        <h4>Scalable Capacity</h4>
                        <p>Flex daily time allocations as your roadmap evolves with month-to-month commitments.</p>
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
