<?php
/**
 * One-time script to update all service page offerings
 * Run this via wp-cli: wp eval-file update-service-offerings.php
 * Or temporarily include in functions.php and visit any page
 */

// Prevent direct access
if (!defined('ABSPATH') && !defined('WP_CLI')) {
    die('Direct access not allowed');
}

function csl_update_service_page_offerings() {
    // Define all service pages and their offerings
    $service_pages = [
        'strategy' => [
            'offerings' => [
                [
                    'offering_title' => 'Growth Roadmap',
                    'offering_description' => 'We create a step-by-step plan for achieving your long-term business goals.',
                    'offering_icon' => 'ph-chart-line-up'
                ],
                [
                    'offering_title' => 'Market Analysis',
                    'offering_description' => 'We identify your unique position and opportunities within the competitive landscape.',
                    'offering_icon' => 'ph-magnifying-glass'
                ],
                [
                    'offering_title' => 'Brand Positioning',
                    'offering_description' => 'We define your core message and value proposition to resonate with your target audience.',
                    'offering_icon' => 'ph-target'
                ],
                [
                    'offering_title' => 'Competitive Intelligence',
                    'offering_description' => 'We analyze your competitors\' strategies, messaging, and market positioning to identify gaps and opportunities for differentiation.',
                    'offering_icon' => 'ph-binoculars'
                ],
                [
                    'offering_title' => 'Go-to-Market Strategy',
                    'offering_description' => 'We develop comprehensive launch plans with channel strategies, messaging frameworks, and timeline milestones for market entry.',
                    'offering_icon' => 'ph-rocket-launch'
                ],
                [
                    'offering_title' => 'Customer Research & Personas',
                    'offering_description' => 'We conduct audience research to build detailed customer personas that inform all marketing and product decisions.',
                    'offering_icon' => 'ph-users-three'
                ]
            ]
        ],
        'branding-production' => [
            'offerings' => [
                [
                    'offering_title' => 'Packaging & Collateral',
                    'offering_description' => 'Designing physical touchpoints that create a memorable unboxing experience.',
                    'offering_icon' => 'ph-package'
                ],
                [
                    'offering_title' => 'Visual Identity Design',
                    'offering_description' => 'Logo systems, color palettes, and typography that form a cohesive brand world.',
                    'offering_icon' => 'ph-palette'
                ],
                [
                    'offering_title' => 'Creative Direction',
                    'offering_description' => 'Overseeing photo and video shoots to ensure all content aligns with the brand\'s vision.',
                    'offering_icon' => 'ph-camera'
                ],
                [
                    'offering_title' => 'Brand Guidelines Development',
                    'offering_description' => 'Comprehensive brand books documenting logo usage, color systems, typography, tone of voice, and application examples.',
                    'offering_icon' => 'ph-book-open'
                ],
                [
                    'offering_title' => 'Cannabis Compliance Review',
                    'offering_description' => 'Ensuring all brand assets, packaging, and marketing materials meet state and federal cannabis advertising regulations.',
                    'offering_icon' => 'ph-shield-check'
                ],
                [
                    'offering_title' => 'Photo & Video Production',
                    'offering_description' => 'Professional product photography, lifestyle content, and video assets optimized for web, social, and marketing campaigns.',
                    'offering_icon' => 'ph-film-strip'
                ]
            ]
        ],
        'web-design' => [
            'offerings' => [
                [
                    'offering_title' => 'E-commerce Integration',
                    'offering_description' => 'Creating seamless shopping experiences that drive sales.',
                    'offering_icon' => 'ph-shopping-cart'
                ],
                [
                    'offering_title' => 'UI/UX Design',
                    'offering_description' => 'Crafting intuitive and beautiful interfaces that guide users to action.',
                    'offering_icon' => 'ph-layout'
                ],
                [
                    'offering_title' => 'Custom Development',
                    'offering_description' => 'Building fast, responsive, and future-proof websites on WordPress or other platforms.',
                    'offering_icon' => 'ph-code'
                ],
                [
                    'offering_title' => 'Age Gate & Compliance Setup',
                    'offering_description' => 'Cannabis-compliant age verification, terms of service, and regulatory disclaimers integrated seamlessly into your site.',
                    'offering_icon' => 'ph-identification-badge'
                ],
                [
                    'offering_title' => 'Performance Optimization',
                    'offering_description' => 'Speed optimization, Core Web Vitals tuning, and caching strategies to achieve 90+ Lighthouse scores and sub-2 second load times.',
                    'offering_icon' => 'ph-gauge'
                ],
                [
                    'offering_title' => 'Hosting & Maintenance',
                    'offering_description' => 'Managed WordPress hosting, security monitoring, plugin updates, backups, and ongoing technical support packages.',
                    'offering_icon' => 'ph-cloud-check'
                ]
            ]
        ],
        'content-social' => [
            'offerings' => [
                [
                    'offering_title' => 'SEO Optimization',
                    'offering_description' => 'Ensuring your content is discovered by search engines and your target audience.',
                    'offering_icon' => 'ph-magnifying-glass'
                ],
                [
                    'offering_title' => 'Content Strategy',
                    'offering_description' => 'Planning and creating valuable blog posts, articles, and videos.',
                    'offering_icon' => 'ph-article'
                ],
                [
                    'offering_title' => 'Social Media Management',
                    'offering_description' => 'Building a community and driving engagement across all relevant channels.',
                    'offering_icon' => 'ph-users-three'
                ],
                [
                    'offering_title' => 'Short-Form Video Production',
                    'offering_description' => 'Engaging Reels, TikToks, and YouTube Shorts optimized for cannabis audiences with compliant messaging and trend-driven creativity.',
                    'offering_icon' => 'ph-video-camera'
                ],
                [
                    'offering_title' => 'Cannabis Industry Newsletters',
                    'offering_description' => 'Educational email content, industry insights, and thought leadership to build authority and nurture your subscriber list.',
                    'offering_icon' => 'ph-envelope-simple'
                ],
                [
                    'offering_title' => 'Community Management',
                    'offering_description' => 'Active monitoring, response management, and engagement strategies to build loyal communities across all social platforms.',
                    'offering_icon' => 'ph-chats-circle'
                ]
            ]
        ],
        'media-buying' => [
            'offerings' => [
                [
                    'offering_title' => 'Performance Analytics',
                    'offering_description' => 'Providing clear reports on what\'s working and how to improve.',
                    'offering_icon' => 'ph-chart-bar'
                ],
                [
                    'offering_title' => 'Programmatic Display Advertising',
                    'offering_description' => 'Automated ad buying across cannabis-friendly display networks with advanced targeting and real-time bidding optimization.',
                    'offering_icon' => 'ph-monitor'
                ],
                [
                    'offering_title' => 'Cannabis Platform Advertising',
                    'offering_description' => 'Strategic campaigns on Leafly, Weedmaps, and other cannabis-specific platforms where your audience actively shops.',
                    'offering_icon' => 'ph-leaf'
                ],
                [
                    'offering_title' => 'Connected TV (CTV) Advertising',
                    'offering_description' => 'Reach cannabis consumers through streaming services with compliant video ads on platforms like Roku, Hulu, and more.',
                    'offering_icon' => 'ph-television'
                ],
                [
                    'offering_title' => 'Geofencing & Location Targeting',
                    'offering_description' => 'Hyper-local campaigns targeting consumers near dispensaries, events, or competitor locations with mobile ads.',
                    'offering_icon' => 'ph-map-pin'
                ],
                [
                    'offering_title' => 'Native Advertising Networks',
                    'offering_description' => 'Sponsored content placement on high-traffic cannabis publications and mainstream sites that accept cannabis advertising.',
                    'offering_icon' => 'ph-newspaper'
                ]
            ]
        ],
        'lifecycle-marketing' => [
            'offerings' => [
                [
                    'offering_title' => 'Retargeting Campaigns',
                    'offering_description' => 'Bringing back interested visitors to complete their purchase or inquiry.',
                    'offering_icon' => 'ph-arrow-u-up-left'
                ],
                [
                    'offering_title' => 'Email Automation',
                    'offering_description' => 'Nurturing leads and re-engaging past customers with automated email sequences.',
                    'offering_icon' => 'ph-envelope-simple'
                ],
                [
                    'offering_title' => 'Customer Journey Mapping',
                    'offering_description' => 'Understanding and optimizing every touchpoint a customer has with your brand.',
                    'offering_icon' => 'ph-path'
                ],
                [
                    'offering_title' => 'SMS Marketing Campaigns',
                    'offering_description' => 'Compliant text message marketing for promotions, cart reminders, and personalized offers with high open and conversion rates.',
                    'offering_icon' => 'ph-chat-text'
                ],
                [
                    'offering_title' => 'Loyalty Program Strategy',
                    'offering_description' => 'Design and implement points-based rewards, VIP tiers, and exclusive perks that increase repeat purchase rates.',
                    'offering_icon' => 'ph-medal'
                ],
                [
                    'offering_title' => 'Win-Back Automation',
                    'offering_description' => 'Re-engagement campaigns targeting dormant customers with personalized offers to recover lost revenue and rebuild relationships.',
                    'offering_icon' => 'ph-arrow-clockwise'
                ]
            ]
        ]
    ];

    $updated_pages = [];
    $errors = [];

    foreach ($service_pages as $slug => $data) {
        // Get page by slug
        $page = get_page_by_path('services/' . $slug, OBJECT, 'page');

        if (!$page) {
            $errors[] = "Page not found: services/$slug";
            continue;
        }

        $page_id = $page->ID;

        // Update the service_offerings ACF repeater field
        $success = update_field('service_offerings', $data['offerings'], $page_id);

        if ($success) {
            $updated_pages[] = "✓ Updated: $slug (ID: $page_id) - " . count($data['offerings']) . " offerings";
        } else {
            $errors[] = "✗ Failed to update: $slug (ID: $page_id)";
        }
    }

    // Output results
    echo "\n========================================\n";
    echo "SERVICE PAGE OFFERINGS UPDATE COMPLETE\n";
    echo "========================================\n\n";

    if (!empty($updated_pages)) {
        echo "SUCCESSFULLY UPDATED:\n";
        foreach ($updated_pages as $msg) {
            echo $msg . "\n";
        }
    }

    if (!empty($errors)) {
        echo "\nERRORS:\n";
        foreach ($errors as $error) {
            echo $error . "\n";
        }
    }

    echo "\n========================================\n";
    echo "Total pages updated: " . count($updated_pages) . "\n";
    echo "Total offerings added: " . (count($updated_pages) * 6) . "\n";
    echo "========================================\n\n";

    return [
        'updated' => $updated_pages,
        'errors' => $errors
    ];
}

// If running via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::line('Starting service page offerings update...');
    $result = csl_update_service_page_offerings();

    if (empty($result['errors'])) {
        WP_CLI::success('All service pages updated successfully!');
    } else {
        WP_CLI::warning('Some errors occurred. Check output above.');
    }
} else {
    // If running via web (add ?update_service_offerings=1 to any page URL when this is included)
    if (isset($_GET['update_service_offerings']) && current_user_can('manage_options')) {
        echo '<pre>';
        csl_update_service_page_offerings();
        echo '</pre>';
        die();
    }
}
