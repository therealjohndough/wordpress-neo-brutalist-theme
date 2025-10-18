<?php
/**
 * CSL Agency Theme — functions.php
 *
 * @package CSL_Agency
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/*--------------------------------------------------------------
# ACF Fallback Functions
--------------------------------------------------------------*/
if (!function_exists('get_field')) {
    function get_field($field_name, $post_id = null) {
        return get_post_meta($post_id ?: get_the_ID(), $field_name, true);
    }
}

if (!function_exists('the_field')) {
    function the_field($field_name, $post_id = null) {
        echo get_field($field_name, $post_id);
    }
}

if (!function_exists('have_rows')) {
    function have_rows($field_name, $post_id = null) {
        return false; // Simple fallback
    }
}

if (!function_exists('the_row')) {
    function the_row() {
        return false;
    }
}

if (!function_exists('get_sub_field')) {
    function get_sub_field($field_name) {
        return '';
    }
}

/*--------------------------------------------------------------
# Mailchimp ESP Integration
--------------------------------------------------------------*/

// Mailchimp API configuration
define("MAILCHIMP_API_KEY", get_field("mailchimp_api_key", "option") ?: "");
define("MAILCHIMP_SERVER_PREFIX", get_field("mailchimp_server_prefix", "option") ?: "us1");
define("MAILCHIMP_AUDIENCE_ID", get_field("mailchimp_audience_id", "option") ?: "");

/**
 * Add contact to Mailchimp audience
 */
function csl_add_to_mailchimp($email, $data = []) {
    if (empty(MAILCHIMP_API_KEY) || empty(MAILCHIMP_AUDIENCE_ID)) {
        error_log("Mailchimp not configured");
        return false;
    }

    $url = "https://" . MAILCHIMP_SERVER_PREFIX . ".api.mailchimp.com/3.0/lists/" . MAILCHIMP_AUDIENCE_ID . "/members/";

    $merge_fields = [
        "FNAME" => $data["name"] ?? "",
        "PHONE" => $data["phone"] ?? "",
        "COMPANY" => $data["company"] ?? "",
        "PROJECT" => $data["project_type"] ?? "",
        "BUDGET" => $data["budget"] ?? "",
        "TIMELINE" => $data["timeline"] ?? "",
        "SOURCE" => $data["source"] ?? "",
        "LEADSCORE" => $data["lead_score"] ?? 0,
        "UTMSOURCE" => $data["utm_source"] ?? "",
        "UTMMEDIUM" => $data["utm_medium"] ?? "",
        "UTMCAMPAIGN" => $data["utm_campaign"] ?? "",
    ];

    $body = [
        "email_address" => $email,
        "status" => "subscribed",
        "merge_fields" => $merge_fields,
        "tags" => csl_get_lead_tags($data),
    ];

    $response = wp_remote_post($url, [
        "headers" => [
            "Authorization" => "Basic " . base64_encode("user:" . MAILCHIMP_API_KEY),
            "Content-Type" => "application/json",
        ],
        "body" => json_encode($body),
        "timeout" => 15,
    ]);

    if (is_wp_error($response)) {
        error_log("Mailchimp API error: " . $response->get_error_message());
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        $body = wp_remote_retrieve_body($response);
        error_log("Mailchimp API error ({$response_code}): " . $body);
        return false;
    }

    return true;
}

/**
 * Get Mailchimp tags based on lead data
 */
function csl_get_lead_tags($data) {
    $tags = ["Website Inquiry"];
    
    $lead_score = $data["lead_score"] ?? 0;
    if ($lead_score >= 80) {
        $tags[] = "Hot Lead";
    } elseif ($lead_score >= 60) {
        $tags[] = "Warm Lead";
    } else {
        $tags[] = "Cold Lead";
    }

    if (!empty($data["utm_source"])) {
        $tags[] = "UTM: " . $data["utm_source"];
    }

    if (!empty($data["project_type"])) {
        $tags[] = ucfirst($data["project_type"]);
    }

    return $tags;
}

/**
 * Trigger ESP automation based on lead score
 */
function csl_trigger_esp_automation($email, $data) {
    $lead_score = $data["lead_score"] ?? 0;

    // Add to Mailchimp
    $mailchimp_result = csl_add_to_mailchimp($email, $data);

    if ($mailchimp_result) {
        // Trigger automation based on lead score
        if ($lead_score >= 80) {
            // Hot lead - immediate follow-up
            csl_schedule_followup_email($email, "hot_lead_sequence", 0);
        } elseif ($lead_score >= 60) {
            // Warm lead - nurture sequence
            csl_schedule_followup_email($email, "warm_lead_sequence", 24);
        } else {
            // Cold lead - educational content
            csl_schedule_followup_email($email, "cold_lead_sequence", 72);
        }
    }

    return $mailchimp_result;
}

/**
 * Schedule follow-up email (placeholder for automation)
 */
function csl_schedule_followup_email($email, $sequence_type, $delay_hours) {
    // This would integrate with your ESP automation
    // For now, just log it
    error_log("Scheduled {$sequence_type} for {$email} in {$delay_hours} hours");

    // In a real implementation, you would:
    // 1. Use WP Cron to schedule the email
    // 2. Or trigger ESP automation webhook
    // 3. Or use a dedicated automation service
}

/*--------------------------------------------------------------
# Theme Setup
--------------------------------------------------------------*/
function csl_agency_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'csl-agency'),
    ));
}
add_action('after_setup_theme', 'csl_agency_theme_setup');

/*--------------------------------------------------------------
# Enqueue Scripts & Styles
--------------------------------------------------------------*/
function csl_agency_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Enqueue theme stylesheet
    wp_enqueue_style('csl-agency-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
    
    // Enqueue theme scripts
    wp_enqueue_script('csl-agency-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), filemtime(get_template_directory() . '/js/theme.js'), true);
    
    // Localize script for AJAX
    wp_localize_script('csl-agency-script', 'csl_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('csl_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'csl_agency_scripts');

/*--------------------------------------------------------------
# GA4/GTM Integration
--------------------------------------------------------------*/
function csl_add_ga4_gtm() {
    // Only add on frontend, not admin
    if (is_admin()) return;
    
    $ga4_id = get_field('ga4_measurement_id', 'option');
    $gtm_id = get_field('gtm_container_id', 'option');
    
    // Add GTM if configured
    if ($gtm_id) {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');</script>
        <!-- End Google Tag Manager -->
        <?php
    }
    
    // Add GA4 if configured
    if ($ga4_id) {
        ?>
        <!-- Google Analytics 4 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga4_id); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?php echo esc_js($ga4_id); ?>');
        </script>
        <!-- End Google Analytics 4 -->
        <?php
    }
}
add_action('wp_head', 'csl_add_ga4_gtm');

/*--------------------------------------------------------------
# Include Custom Components
--------------------------------------------------------------*/
require_once get_template_directory() . '/inc/contact-form-shortcode.php';

/*--------------------------------------------------------------
# Internal Linking Strategy Functions
--------------------------------------------------------------*/

/**
 * Get internal navigation links array
 */
function csl_get_internal_links($current_page = '') {
    $links = [
        'home' => [
            'url' => home_url('/'),
            'text' => 'Home',
            'rel' => ''
        ],
        'websites' => [
            'url' => home_url('/websites'),
            'text' => 'Our Packages',
            'rel' => 'noopener'
        ],
        'services' => [
            'url' => home_url('/services'),
            'text' => 'Services',
            'rel' => 'noopener'
        ],
        'process' => [
            'url' => home_url('/our-process'),
            'text' => 'Our Process',
            'rel' => 'noopener'
        ],
        'contact' => [
            'url' => home_url('/contact'),
            'text' => 'Get Started',
            'rel' => 'noopener'
        ]
    ];

    // Remove current page from links array
    if ($current_page && isset($links[$current_page])) {
        unset($links[$current_page]);
    }

    return $links;
}

/**
 * Build CTA URL with UTM parameters
 */
function csl_build_cta_url($base_url, $source = 'internal', $medium = 'link', $campaign = 'cross_page') {
    return add_query_arg([
        'utm_source' => $source,
        'utm_medium' => $medium,
        'utm_campaign' => $campaign
    ], $base_url);
}

/**
 * Get breadcrumb navigation
 */
function csl_get_breadcrumbs($current_page = '') {
    $breadcrumbs = [
        'home' => 'Home'
    ];

    $page_map = [
        'websites' => 'Our Packages',
        'services' => 'Services',
        'process' => 'Our Process',
        'contact' => 'Contact'
    ];

    if ($current_page && isset($page_map[$current_page])) {
        $breadcrumbs[$current_page] = $page_map[$current_page];
    }

    return $breadcrumbs;
}

/**
 * Enhanced CTA function with UTM tracking
 */
function csl_get_cta_link($package = '', $source = 'page', $medium = 'cta') {
    $base_url = home_url('/contact');

    $params = [
        'utm_source' => $source,
        'utm_medium' => $medium,
        'utm_campaign' => 'package_inquiry'
    ];

    if ($package) {
        $params['package'] = $package;
    }

    return add_query_arg($params, $base_url);
}

/**
 * Add theme customizer settings for homepage hero
 */
function csl_customize_register($wp_customize) {
    // Add Hero Section
    $wp_customize->add_section('csl_hero_section', array(
        'title' => 'Homepage Hero Settings',
        'description' => 'Customize the hero section buttons on the homepage',
        'priority' => 30,
    ));

    // Primary Button Text
    $wp_customize->add_setting('hero_primary_text', array(
        'default' => 'Brand Clarity Quiz',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_primary_text', array(
        'label' => 'Primary Button Text',
        'section' => 'csl_hero_section',
        'type' => 'text',
    ));

    // Primary Button Link
    $wp_customize->add_setting('hero_primary_link', array(
        'default' => '/brand-clarity-quiz',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_primary_link', array(
        'label' => 'Primary Button Link',
        'section' => 'csl_hero_section',
        'type' => 'url',
    ));

    // Secondary Button Text
    $wp_customize->add_setting('hero_secondary_text', array(
        'default' => 'Our Process',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_secondary_text', array(
        'label' => 'Secondary Button Text',
        'section' => 'csl_hero_section',
        'type' => 'text',
    ));

    // Secondary Button Link
    $wp_customize->add_setting('hero_secondary_link', array(
        'default' => '/our-process',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_secondary_link', array(
        'label' => 'Secondary Button Link',
        'section' => 'csl_hero_section',
        'type' => 'url',
    ));

    // Tertiary Button Text
    $wp_customize->add_setting('hero_tertiary_text', array(
        'default' => 'Have Questions?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_tertiary_text', array(
        'label' => 'Tertiary Button Text',
        'section' => 'csl_hero_section',
        'type' => 'text',
    ));

    // Tertiary Button Link
    $wp_customize->add_setting('hero_tertiary_link', array(
        'default' => '#faq',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_tertiary_link', array(
        'label' => 'Tertiary Button Link',
        'section' => 'csl_hero_section',
        'type' => 'url',
    ));
}
add_action('customize_register', 'csl_customize_register');

/**
 * Helper function to get customizer values
 */
function csl_get_theme_mod($key, $default = '') {
    return get_theme_mod($key, $default);
}
