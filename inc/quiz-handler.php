<?php
/**
 * Quiz Results Handler
 * Captures Brand Clarity Quiz results and creates Inquiry CPT entries
 *
 * @package Aura-Grid_Machina_Enhanced
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register AJAX endpoints for quiz submission
 */
add_action('wp_ajax_csl_submit_quiz', 'csl_handle_quiz_submission');
add_action('wp_ajax_nopriv_csl_submit_quiz', 'csl_handle_quiz_submission');

/**
 * Handle quiz submission via AJAX
 */
function csl_handle_quiz_submission() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'csl_quiz_nonce')) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

    // Get and sanitize quiz data
    $quiz_data = [
        'email' => sanitize_email($_POST['email'] ?? ''),
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'company' => sanitize_text_field($_POST['company'] ?? ''),
        'scores' => [
            'branding' => absint($_POST['branding_score'] ?? 0),
            'strategy' => absint($_POST['strategy_score'] ?? 0),
            'marketing' => absint($_POST['marketing_score'] ?? 0),
        ],
        'top_need' => sanitize_text_field($_POST['top_need'] ?? ''),
        'budget_level' => sanitize_text_field($_POST['budget_level'] ?? ''),
        'urgency' => sanitize_text_field($_POST['urgency'] ?? ''),
        'timestamp' => current_time('mysql'),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    ];

    // Debug log
    error_log('Quiz submission received: ' . print_r($_POST, true));
    error_log('Parsed quiz data: ' . print_r($quiz_data, true));

    // Validate required fields
    if (empty($quiz_data['email']) || !is_email($quiz_data['email'])) {
        wp_send_json_error(['message' => 'Valid email is required.'], 400);
    }

    // Calculate total quiz score
    $total_score = array_sum($quiz_data['scores']);

    // Calculate lead score based on quiz answers
    $lead_score = csl_calculate_quiz_lead_score($quiz_data);

    // Create Inquiry CPT entry
    $inquiry_id = csl_create_inquiry_from_quiz($quiz_data, $total_score, $lead_score);

    if (is_wp_error($inquiry_id)) {
        wp_send_json_error(['message' => $inquiry_id->get_error_message()], 500);
    }

    // Store quiz data in session for contact form pre-fill
    if (!session_id()) {
        session_start();
    }
    $_SESSION['quiz_data'] = $quiz_data;
    $_SESSION['inquiry_id'] = $inquiry_id;

    // Send notification email
    csl_send_quiz_notification($quiz_data, $inquiry_id);

    // Send confirmation email to user
    csl_send_quiz_confirmation_email($quiz_data);

    wp_send_json_success([
        'message' => 'Quiz results saved!',
        'inquiry_id' => $inquiry_id,
        'contact_url' => add_query_arg('quiz', 'completed', get_permalink(get_page_by_path('contact'))),
    ]);
}

/**
 * Calculate lead score for quiz submissions
 */
function csl_calculate_quiz_lead_score($quiz_data) {
    $score = 0;

    // Budget scoring (most important factor)
    $budget_scores = [
        'under-10k' => 20,
        '10k-25k' => 50,
        '25k-50k' => 75,
        '50k+' => 100,
        'not-specified' => 40,
    ];
    $budget = $quiz_data['budget_level'] ?? 'not-specified';
    $score += $budget_scores[$budget] ?? 40;

    // Urgency scoring
    $urgency_scores = [
        'immediate' => 30,
        'soon' => 25,
        'planning' => 15,
        'not-specified' => 10,
    ];
    $urgency = $quiz_data['urgency'] ?? 'not-specified';
    $score += $urgency_scores[$urgency] ?? 10;

    // Top need scoring
    $need_scores = [
        'branding' => 25,
        'strategy' => 20,
        'marketing' => 20,
    ];
    $top_need = $quiz_data['top_need'] ?? '';
    $score += $need_scores[$top_need] ?? 15;

    // Bonus for providing company name
    if (!empty($quiz_data['company'])) {
        $score += 5;
    }

    // Bonus for providing full name
    if (!empty($quiz_data['name'])) {
        $score += 5;
    }

    return min($score, 100); // Cap at 100
}

/**
 * Create Inquiry CPT from quiz data
 */
function csl_create_inquiry_from_quiz($quiz_data, $total_score, $lead_score = 0) {
    // Create inquiry post
    $post_data = [
        'post_type' => 'inquiry',
        'post_status' => 'publish',
        'post_title' => sprintf(
            'Quiz Lead: %s (%s) - Score: %d',
            $quiz_data['name'] ?: $quiz_data['email'],
            $quiz_data['top_need'],
            $total_score
        ),
    ];

    $inquiry_id = wp_insert_post($post_data);

    if (is_wp_error($inquiry_id)) {
        return $inquiry_id;
    }

    // Save quiz data as post meta
    update_post_meta($inquiry_id, 'inquiry_source', 'quiz');
    update_post_meta($inquiry_id, 'inquiry_email', $quiz_data['email']);
    update_post_meta($inquiry_id, 'inquiry_name', $quiz_data['name']);
    update_post_meta($inquiry_id, 'inquiry_company', $quiz_data['company']);
    update_post_meta($inquiry_id, 'quiz_scores', $quiz_data['scores']);
    update_post_meta($inquiry_id, 'quiz_total_score', $total_score);
    update_post_meta($inquiry_id, 'quiz_top_need', $quiz_data['top_need']);
    update_post_meta($inquiry_id, 'quiz_budget_level', $quiz_data['budget_level']);
    update_post_meta($inquiry_id, 'quiz_urgency', $quiz_data['urgency']);
    update_post_meta($inquiry_id, 'lead_score', $lead_score); // Use calculated lead score, not total quiz score
    update_post_meta($inquiry_id, 'inquiry_status', 'quiz_completed');
    update_post_meta($inquiry_id, 'inquiry_ip', $quiz_data['ip_address']);
    update_post_meta($inquiry_id, 'inquiry_user_agent', $quiz_data['user_agent']);

    // Debug log
    error_log('Created inquiry #' . $inquiry_id . ' with lead score: ' . $lead_score);

    return $inquiry_id;
}

/**
 * Send notification email to admin
 */
function csl_send_quiz_notification($quiz_data, $inquiry_id) {
    $to = get_option('admin_email');
    $subject = sprintf('[CSL] New Quiz Completion: %s', $quiz_data['top_need']);

    $message = sprintf(
        "New Brand Clarity Quiz completed!\n\n" .
        "Name: %s\n" .
        "Email: %s\n" .
        "Company: %s\n\n" .
        "Results:\n" .
        "Top Need: %s\n" .
        "Branding Score: %d\n" .
        "Strategy Score: %d\n" .
        "Marketing Score: %d\n\n" .
        "Budget Level: %s\n" .
        "Urgency: %s\n\n" .
        "View in admin: %s",
        $quiz_data['name'] ?: '(Not provided)',
        $quiz_data['email'],
        $quiz_data['company'] ?: '(Not provided)',
        ucfirst($quiz_data['top_need']),
        $quiz_data['scores']['branding'],
        $quiz_data['scores']['strategy'],
        $quiz_data['scores']['marketing'],
        $quiz_data['budget_level'],
        $quiz_data['urgency'],
        admin_url('post.php?post=' . $inquiry_id . '&action=edit')
    );

    wp_mail($to, $subject, $message);
}

/**
 * Send confirmation email to quiz taker
 */
function csl_send_quiz_confirmation_email($quiz_data) {
    $to = $quiz_data['email'];
    $subject = 'Your Brand Clarity Quiz Results - Case Study Labs';

    $name = $quiz_data['name'] ?: 'there';

    $message = sprintf(
        "Hi %s,\n\n" .
        "Thank you for taking the Brand Clarity Quiz!\n\n" .
        "Based on your answers, your top priority is: %s\n\n" .
        "We've saved your results and would love to discuss how we can help. " .
        "Schedule a free discovery call or submit a project inquiry:\n\n" .
        "Contact us: %s\n" .
        "Book a call: https://calendar.app.google/z1veEHms9x3RJAT79\n\n" .
        "Looking forward to working with you!\n\n" .
        "— The Case Study Labs Team\n" .
        "https://casestudy-labs.com",
        esc_html($name),
        ucfirst($quiz_data['top_need']),
        get_permalink(get_page_by_path('contact'))
    );

    wp_mail($to, $subject, $message);
}

/**
 * Enqueue quiz capture JavaScript
 */
add_action('wp_enqueue_scripts', 'csl_enqueue_quiz_capture_script');

function csl_enqueue_quiz_capture_script() {
    // Only load on quiz page
    if (!is_page('case-study-labs-quiz')) {
        return;
    }

    wp_enqueue_script(
        'csl-quiz-capture',
        get_template_directory_uri() . '/assets/js/quiz-capture.js',
        ['jquery'],
        '1.0.0',
        true
    );

    wp_localize_script('csl-quiz-capture', 'cslQuiz', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('csl_quiz_nonce'),
        'contact_url' => get_permalink(get_page_by_path('contact')),
    ]);
}

/**
 * Pre-fill contact form with quiz data
 */
add_filter('csl_contact_form_prefill', 'csl_prefill_from_quiz');

function csl_prefill_from_quiz($data) {
    if (!session_id()) {
        session_start();
    }

    if (isset($_SESSION['quiz_data'])) {
        $quiz_data = $_SESSION['quiz_data'];

        // Map quiz data to contact form fields
        $data['name'] = $quiz_data['name'] ?? '';
        $data['email'] = $quiz_data['email'] ?? '';
        $data['company'] = $quiz_data['company'] ?? '';

        // Map top need to project type
        $need_to_project = [
            'branding' => 'branding',
            'strategy' => 'audit',
            'marketing' => 'marketing',
        ];
        $data['project_type'] = $need_to_project[$quiz_data['top_need']] ?? '';

        // Map budget level
        $budget_map = [
            'under-10k' => 'under-5k',
            '10k-25k' => '10k-25k',
            '25k-50k' => '25k-50k',
            '50k+' => '50k-plus',
        ];
        $data['budget'] = $budget_map[$quiz_data['budget_level']] ?? 'lets-discuss';

        // Map urgency to timeline
        $urgency_map = [
            'immediate' => 'asap',
            'soon' => '1-3-months',
            'planning' => '3-6-months',
        ];
        $data['timeline'] = $urgency_map[$quiz_data['urgency']] ?? 'flexible';

        $data['quiz_completed'] = true;
    }

    return $data;
}
