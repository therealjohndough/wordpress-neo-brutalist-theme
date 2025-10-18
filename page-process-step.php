<?php
/**
 * Template Name: Process Step Page
 * Description: Individual process step page with pricing and navigation
 * @package CSL_Agency
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get the step slug from page slug or custom field
$page_slug = get_post_field('post_name', get_post());

// Define all steps with detailed pricing
$all_steps = [
  'discovery' => [
    'number' => 1,
    'title' => 'Discovery & Strategy',
    'subtitle' => 'Deep-dive research and strategic foundation',
    'icon' => 'ph-compass',
    'color' => '#3498db',
    'duration' => '1-2 weeks',
    'description' => 'We start with deep-dive research into your market, competitors, and target audience. Define goals, constraints, and success metrics.',
    'what_included' => [
      'Market & competitive analysis',
      'Target audience research & personas',
      'Brand positioning workshop',
      'Strategic recommendations document',
      'Success metrics & KPIs definition',
      'Project roadmap & timeline'
    ],
    'deliverables' => [
      'Strategy Brief (15-20 pages)',
      'Competitive Analysis Report',
      'Target Audience Personas',
      'Brand Positioning Statement',
      'Project Timeline & Milestones'
    ],
    'pricing' => [
      'standalone' => '$5,000 - $8,000',
      'as_part_of_full' => 'Included in Full Process ($39K–$49K)',
      'timeline' => '1-2 weeks'
    ]
  ],
  'brand-foundation' => [
    'number' => 2,
    'title' => 'Brand Foundation',
    'subtitle' => 'Positioning, messaging, and visual identity',
    'icon' => 'ph-cube',
    'color' => '#9b59b6',
    'duration' => '2-3 weeks',
    'description' => 'Positioning, messaging, visual identity system. We build the foundation that everything else stands on.',
    'what_included' => [
      'Brand positioning & messaging framework',
      'Visual identity system (logo, colors, typography)',
      'Brand voice & tone guidelines',
      'Brand story & narrative',
      'Comprehensive brand guidelines',
      'Asset library setup'
    ],
    'deliverables' => [
      'Brand Guidelines (30-40 pages)',
      'Logo suite (primary, secondary, marks)',
      'Color palette & typography system',
      'Brand messaging framework',
      'Digital asset library'
    ],
    'pricing' => [
      'standalone' => '$8,000 - $12,000',
      'as_part_of_full' => 'Included in Full Process ($39K–$49K)',
      'timeline' => '2-3 weeks'
    ]
  ],
  'design-dev' => [
    'number' => 3,
    'title' => 'Design & Development',
    'subtitle' => 'Bring your brand to life across all touchpoints',
    'icon' => 'ph-palette',
    'color' => '#e74c3c',
    'duration' => '3-4 weeks',
    'description' => 'Bring your brand to life across all touchpoints. Website, collateral, packaging, social templates.',
    'what_included' => [
      'Custom website design & development',
      'Marketing collateral design',
      'Packaging design (if applicable)',
      'Social media templates',
      'Email templates',
      'Presentation decks'
    ],
    'deliverables' => [
      'Production-Ready Website',
      'Marketing Collateral Suite',
      'Social Media Template Pack',
      'Email Template System',
      'Print-Ready Files'
    ],
    'pricing' => [
      'standalone' => '$12,000 - $20,000',
      'as_part_of_full' => 'Included in Full Process ($39K–$49K)',
      'timeline' => '3-4 weeks'
    ]
  ],
  'content-campaigns' => [
    'number' => 4,
    'title' => 'Content & Campaigns',
    'subtitle' => 'Launch campaigns that convert',
    'icon' => 'ph-megaphone',
    'color' => '#f39c12',
    'duration' => '2-3 weeks',
    'description' => 'Launch campaigns that convert. Content strategy, ad creative, landing pages, email sequences.',
    'what_included' => [
      'Content strategy & calendar',
      'Ad creative & copy',
      'Landing page design & copy',
      'Email sequences',
      'Social media content plan',
      'Campaign tracking setup'
    ],
    'deliverables' => [
      'Campaign Assets & Copy Deck',
      '30-day content calendar',
      'Ad creative suite (10+ variations)',
      'Landing pages (3-5 pages)',
      'Email sequence (5-7 emails)'
    ],
    'pricing' => [
      'standalone' => '$6,000 - $10,000',
      'as_part_of_full' => 'Included in Full Process ($39K–$49K)',
      'timeline' => '2-3 weeks'
    ]
  ],
  'launch' => [
    'number' => 5,
    'title' => 'Launch & Optimize',
    'subtitle' => 'Go live with analytics and optimization',
    'icon' => 'ph-rocket-launch',
    'color' => '#2ecc71',
    'duration' => '1-2 weeks',
    'description' => 'Go live with analytics tracking. Monitor, test, and optimize based on real performance data.',
    'what_included' => [
      'Launch strategy & checklist',
      'Analytics setup (GA4, tracking)',
      'Performance monitoring',
      'A/B testing plan',
      'Initial optimization recommendations',
      'Launch support'
    ],
    'deliverables' => [
      'Launch Plan & Checklist',
      'Analytics Dashboard Setup',
      'Performance Monitoring System',
      'Optimization Recommendations',
      '30-day post-launch support'
    ],
    'pricing' => [
      'standalone' => '$4,000 - $6,000',
      'as_part_of_full' => 'Included in Full Process ($39K–$49K)',
      'timeline' => '1-2 weeks'
    ]
  ],
  'growth' => [
    'number' => 6,
    'title' => 'Growth & Scale',
    'subtitle' => 'Continuous improvement and expansion',
    'icon' => 'ph-trend-up',
    'color' => '#16a085',
    'duration' => 'Ongoing',
    'description' => 'Continuous improvement. Expand successful campaigns, test new channels, and scale what works.',
    'what_included' => [
      'Growth strategy & roadmap',
      'Channel expansion planning',
      'Campaign scaling',
      'Performance reporting',
      'Continuous optimization',
      'Strategic guidance'
    ],
    'deliverables' => [
      'Growth Roadmap & Reporting',
      'Monthly performance reports',
      'Quarterly strategy reviews',
      'Ongoing optimization',
      'Priority support'
    ],
    'pricing' => [
      'standalone' => '$3,000 - $5,000/month',
      'as_part_of_full' => 'Optional add-on',
      'timeline' => 'Ongoing retainer'
    ]
  ]
];

// Try to match step by page slug
$current_step = null;
foreach ($all_steps as $slug => $step_data) {
  if (strpos($page_slug, $slug) !== false) {
    $current_step = $step_data;
    $current_step['slug'] = $slug;
    break;
  }
}

// Fallback to first step if no match
if (!$current_step) {
  $current_step = $all_steps['discovery'];
  $current_step['slug'] = 'discovery';
}

// Get previous and next steps for navigation
$step_slugs = array_keys($all_steps);
$current_index = array_search($current_step['slug'], $step_slugs);
$prev_step = $current_index > 0 ? $all_steps[$step_slugs[$current_index - 1]] : null;
$next_step = $current_index < count($step_slugs) - 1 ? $all_steps[$step_slugs[$current_index + 1]] : null;

?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/process-step.css">

<main id="main-content" class="process-step-page">

  <!-- Step Hero -->
  <section class="step-hero" style="--step-color: <?php echo esc_attr($current_step['color']); ?>">
    <div class="container">
      <div class="step-breadcrumb">
        <a href="<?php echo home_url('/our-process'); ?>">Our Process</a>
        <span class="separator">/</span>
        <span>Step <?php echo $current_step['number']; ?> of 6</span>
      </div>

      <div class="step-hero-content">
        <div class="step-icon-large">
          <i class="ph <?php echo esc_attr($current_step['icon']); ?>"></i>
        </div>
        <h1 class="step-title"><?php echo esc_html($current_step['title']); ?></h1>
        <p class="step-subtitle"><?php echo esc_html($current_step['subtitle']); ?></p>
        <div class="step-meta">
          <span class="step-duration"><i class="ph ph-clock"></i> <?php echo esc_html($current_step['duration']); ?></span>
          <span class="step-number-badge">Step <?php echo $current_step['number']; ?> / 6</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Step Description -->
  <section class="step-description">
    <div class="container-narrow">
      <p class="lead-text"><?php echo esc_html($current_step['description']); ?></p>
    </div>
  </section>

  <!-- What's Included -->
  <section class="step-included">
    <div class="container">
      <div class="two-column-layout">
        <div class="column">
          <h2 class="section-heading">What's Included</h2>
          <ul class="included-list">
            <?php foreach ($current_step['what_included'] as $item): ?>
              <li><i class="ph ph-check-circle"></i> <?php echo esc_html($item); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="column">
          <h2 class="section-heading">Deliverables</h2>
          <ul class="deliverables-list">
            <?php foreach ($current_step['deliverables'] as $deliverable): ?>
              <li><i class="ph ph-package"></i> <?php echo esc_html($deliverable); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section class="step-pricing">
    <div class="container-narrow">
      <h2 class="section-heading text-center">Investment</h2>

      <div class="pricing-cards">
        <div class="pricing-card">
          <div class="pricing-label">Standalone</div>
          <div class="pricing-amount"><?php echo esc_html($current_step['pricing']['standalone']); ?></div>
          <div class="pricing-timeline"><?php echo esc_html($current_step['pricing']['timeline']); ?></div>
          <p class="pricing-desc">Perfect for focused initiatives</p>
          <a href="<?php echo home_url('/contact'); ?>?step=<?php echo urlencode($current_step['title']); ?>" class="btn btn-outline">Get Started</a>
        </div>

        <div class="pricing-card featured">
          <div class="pricing-badge">Best Value</div>
          <div class="pricing-label">Full Process</div>
          <div class="pricing-amount">$25,000</div>
          <div class="pricing-timeline">8-12 weeks</div>
          <p class="pricing-desc"><?php echo esc_html($current_step['pricing']['as_part_of_full']); ?></p>
          <a href="<?php echo home_url('/contact'); ?>?package=full-process" class="btn btn-accent">Start Full Process</a>
        </div>
      </div>

      <div class="pricing-note">
        <i class="ph ph-info"></i>
        <p>All projects include revision rounds, project management, and 30 days post-launch support. Payment plans available.</p>
      </div>
    </div>
  </section>

  <!-- Step Navigation -->
  <section class="step-navigation">
    <div class="container">
      <div class="nav-buttons">
        <?php if ($prev_step): ?>
          <a href="<?php echo home_url('/process-step-' . $step_slugs[$current_index - 1]); ?>" class="nav-btn nav-prev">
            <span class="nav-label">Previous Step</span>
            <span class="nav-title"><i class="ph ph-arrow-left"></i> <?php echo esc_html($prev_step['title']); ?></span>
          </a>
        <?php else: ?>
          <a href="<?php echo home_url('/our-process'); ?>" class="nav-btn nav-prev">
            <span class="nav-label">Back to</span>
            <span class="nav-title"><i class="ph ph-arrow-left"></i> Process Overview</span>
          </a>
        <?php endif; ?>

        <?php if ($next_step): ?>
          <a href="<?php echo home_url('/process-step-' . $step_slugs[$current_index + 1]); ?>" class="nav-btn nav-next">
            <span class="nav-label">Next Step</span>
            <span class="nav-title"><?php echo esc_html($next_step['title']); ?> <i class="ph ph-arrow-right"></i></span>
          </a>
        <?php else: ?>
          <a href="<?php echo home_url('/contact'); ?>" class="nav-btn nav-next">
            <span class="nav-label">Ready to Start?</span>
            <span class="nav-title">Get In Touch <i class="ph ph-arrow-right"></i></span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- All Steps Progress -->
  <section class="all-steps-progress">
    <div class="container">
      <h3 class="text-center">Complete Process</h3>
      <div class="steps-progress-bar">
        <?php foreach ($all_steps as $slug => $step): ?>
          <a href="<?php echo home_url('/process-step-' . $slug); ?>"
             class="progress-step <?php echo $slug === $current_step['slug'] ? 'active' : ''; ?>"
             style="--step-color: <?php echo esc_attr($step['color']); ?>">
            <div class="progress-step-icon">
              <i class="ph <?php echo esc_attr($step['icon']); ?>"></i>
            </div>
            <div class="progress-step-label"><?php echo esc_html($step['title']); ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
