<?php
/**
 * Improved Contact Form Shortcode
 * Clean, modular contact form with better lead qualification
 *
 * @package Aura-Grid_Machina_Enhanced
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Contact Form Shortcode
 */
function csl_improved_contact_form_shortcode($atts = []) {
    // Parse attributes
    $atts = shortcode_atts([
        'class' => 'csl-contact-form',
        'title' => 'Project Inquiry',
        'redirect' => '/thank-you',
    ], $atts);

    // Generate nonce for security
    $nonce = wp_nonce_field('csl_contact_form_submit', 'csl_contact_nonce', true, false);
    
    // Start output buffering
    ob_start();
    
    // Check for success message
    if (!session_id()) {
        session_start();
    }
    $success = $_SESSION['form_success'] ?? false;
    $lead_score = $_SESSION['lead_score'] ?? 0;

    // Get pre-fill data from quiz
    $prefill = apply_filters('csl_contact_form_prefill', []);
    $from_quiz = !empty($prefill['quiz_completed']);

    // Clear session after displaying
    if ($success) {
        unset($_SESSION['form_success']);
        unset($_SESSION['lead_score']);
    }
    ?>
    
    <div class="<?php echo esc_attr($atts['class']); ?>">
        
        <?php if ($success): ?>
        <div class="success-message" style="background: rgba(34, 197, 94, 0.1); border: 1px solid #22c55e; color: #22c55e; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <h3>Thank You! Your inquiry has been submitted.</h3>
            <p>We received your project details and will be in touch within 24 hours. In the meantime, feel free to explore our work or book a discovery call.</p>
            <div style="margin-top: 1rem;">
                <a href="/case-studies" class="btn btn-primary" style="margin-right: 1rem;">View Case Studies</a>
                <a href="https://calendar.app.google/z1veEHms9x3RJAT79" class="btn btn-secondary" target="_blank">Book Discovery Call</a>
            </div>
        </div>
        <?php else: ?>

        <?php if ($from_quiz): ?>
        <div class="quiz-notice" style="background: rgba(34, 197, 94, 0.1); border-left: 4px solid #22c55e; color: #22c55e; padding: 1rem 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <strong>✓ Quiz Completed!</strong> We've pre-filled your information. Just add your phone number and project details to get started.
        </div>
        <?php endif; ?>

        <form method="post" class="csl-form" novalidate data-redirect="<?php echo esc_url($atts['redirect']); ?>">

            <?php echo $nonce; ?>
            <input type="hidden" name="csl_form_submit" value="1">
            <input type="hidden" name="csl_ts" value="<?php echo time(); ?>">
            <input type="hidden" name="utm_source" value="<?php echo esc_attr($_GET["utm_source"] ?? ""); ?>">
            <input type="hidden" name="utm_medium" value="<?php echo esc_attr($_GET["utm_medium"] ?? ""); ?>">
            <input type="hidden" name="utm_campaign" value="<?php echo esc_attr($_GET["utm_campaign"] ?? ""); ?>">
            <input type="hidden" name="utm_term" value="<?php echo esc_attr($_GET["utm_term"] ?? ""); ?>">
            <input type="hidden" name="utm_content" value="<?php echo esc_attr($_GET["utm_content"] ?? ""); ?>">
            <?php if ($from_quiz): ?>
            <input type="hidden" name="from_quiz" value="1">
            <input type="hidden" name="inquiry_id" value="<?php echo esc_attr($_SESSION['inquiry_id'] ?? ''); ?>">
            <?php endif; ?>

            <!-- Honeypot for spam protection -->
            <input type="text" name="csl_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">

            <?php if (!empty($atts['title'])): ?>
            <h3 class="title"><?php echo esc_html($atts['title']); ?></h3>
            <?php endif; ?>

            <!-- Name and Email Row -->
            <div class="form-group">
                <label data-required="true">
                    <span>Full Name</span>
                    <input class="input" type="text" name="csl_name" value="<?php echo esc_attr($prefill['name'] ?? ''); ?>" required autocomplete="name">
                </label>
                <label data-required="true">
                    <span>Email Address</span>
                    <input class="input" type="email" name="csl_email" value="<?php echo esc_attr($prefill['email'] ?? ''); ?>" required autocomplete="email">
                </label>
            </div>

            <!-- Phone and Company Row -->
            <div class="form-group">
                <label data-required="true">
                    <span>Phone Number</span>
                    <input class="input" type="tel" name="csl_phone" required>
                </label>
                <label>
                    <span>Company (optional)</span>
                    <input class="input" type="text" name="csl_company" value="<?php echo esc_attr($prefill['company'] ?? ''); ?>" placeholder="Company (optional)">
                </label>
            </div>

            <!-- Project Type and Budget Row -->
            <div class="form-group">
                <label data-required="true">
                    <span>Project Type</span>
                    <select class="input" name="csl_project_type" required>
                        <option value="" disabled <?php echo empty($prefill['project_type']) ? 'selected' : ''; ?> hidden>Select project type…</option>
                        <option value="website" <?php echo ($prefill['project_type'] ?? '') === 'website' ? 'selected' : ''; ?>>Website Design & Development</option>
                        <option value="branding" <?php echo ($prefill['project_type'] ?? '') === 'branding' ? 'selected' : ''; ?>>Brand Identity & Strategy</option>
                        <option value="marketing" <?php echo ($prefill['project_type'] ?? '') === 'marketing' ? 'selected' : ''; ?>>Marketing & Campaigns</option>
                        <option value="ecommerce" <?php echo ($prefill['project_type'] ?? '') === 'ecommerce' ? 'selected' : ''; ?>>E-commerce & Online Store</option>
                        <option value="audit" <?php echo ($prefill['project_type'] ?? '') === 'audit' ? 'selected' : ''; ?>>Brand Audit & Consultation</option>
                        <option value="packaging" <?php echo ($prefill['project_type'] ?? '') === 'packaging' ? 'selected' : ''; ?>>Product & Packaging Design</option>
                        <option value="other" <?php echo ($prefill['project_type'] ?? '') === 'other' ? 'selected' : ''; ?>>Other / Multiple Services</option>
                    </select>
                </label>

                <label data-required="true">
                    <span>Investment Range</span>
                    <select class="input" name="csl_budget" required>
                        <option value="" disabled <?php echo empty($prefill['budget']) ? 'selected' : ''; ?> hidden>Select investment range…</option>
                        <option value="under-5k" <?php echo ($prefill['budget'] ?? '') === 'under-5k' ? 'selected' : ''; ?>>Under $5,000</option>
                        <option value="5k-10k" <?php echo ($prefill['budget'] ?? '') === '5k-10k' ? 'selected' : ''; ?>>$5,000 – $10,000</option>
                        <option value="10k-25k" <?php echo ($prefill['budget'] ?? '') === '10k-25k' ? 'selected' : ''; ?>>$10,000 – $25,000</option>
                        <option value="25k-50k" <?php echo ($prefill['budget'] ?? '') === '25k-50k' ? 'selected' : ''; ?>>$25,000 – $50,000</option>
                        <option value="50k-plus" <?php echo ($prefill['budget'] ?? '') === '50k-plus' ? 'selected' : ''; ?>>$50,000+</option>
                        <option value="lets-discuss" <?php echo ($prefill['budget'] ?? '') === 'lets-discuss' ? 'selected' : ''; ?>>Let's discuss</option>
                    </select>
                </label>
            </div>

            <!-- Timeline and Experience Row -->
            <div class="form-group">
                <label data-required="true">
                    <span>Project Timeline</span>
                    <select class="input" name="csl_timeline" required>
                        <option value="" disabled <?php echo empty($prefill['timeline']) ? 'selected' : ''; ?> hidden>Select timeline…</option>
                        <option value="asap" <?php echo ($prefill['timeline'] ?? '') === 'asap' ? 'selected' : ''; ?>>ASAP (Rush project)</option>
                        <option value="1-3-months" <?php echo ($prefill['timeline'] ?? '') === '1-3-months' ? 'selected' : ''; ?>>1-3 months</option>
                        <option value="3-6-months" <?php echo ($prefill['timeline'] ?? '') === '3-6-months' ? 'selected' : ''; ?>>3-6 months</option>
                        <option value="6-plus-months" <?php echo ($prefill['timeline'] ?? '') === '6-plus-months' ? 'selected' : ''; ?>>6+ months</option>
                        <option value="planning" <?php echo ($prefill['timeline'] ?? '') === 'planning' ? 'selected' : ''; ?>>Planning phase</option>
                        <option value="flexible" <?php echo ($prefill['timeline'] ?? '') === 'flexible' ? 'selected' : ''; ?>>Flexible timing</option>
                    </select>
                </label>
                
                <label>
                    <span>Agency Experience (optional)</span>
                    <select class="input" name="csl_agency_experience">
                        <option value="" disabled selected hidden>Agency experience (optional)…</option>
                        <option value="first-time">First time working with an agency</option>
                        <option value="previous-good">Worked with agencies before (good experience)</option>
                        <option value="previous-bad">Worked with agencies before (bad experience)</option>
                        <option value="in-house-team">Have in-house marketing team</option>
                    </select>
                </label>
            </div>

            <!-- Referral Source Row -->
            <div class="form-group full-width">
                <label>
                    <span>How did you hear about us? (optional)</span>
                    <select class="input" name="csl_source">
                        <option value="" disabled selected hidden>How did you hear about us? (optional)</option>
                        <option value="referral">Referral from client/partner</option>
                        <option value="google-search">Google Search</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="instagram">Instagram</option>
                        <option value="cannabis-event">Cannabis industry event</option>
                        <option value="business-event">Business/networking event</option>
                        <option value="press-article">Article or press mention</option>
                        <option value="other">Other</option>
                    </select>
                </label>
            </div>

            <!-- Project Description -->
            <div class="form-group full-width">
                <label data-required="true">
                    <span>Tell us about your project, goals, and what success looks like</span>
                    <textarea class="input" name="csl_message" rows="4" required></textarea>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit">
                <span class="submit-text">Send Inquiry</span>
                <span class="submit-loading" style="display:none;">Sending...</span>
            </button>

        </form>
<?php
// Calendar Integration Section
$calendly_url = get_field("calendly_url", "option") ?: "https://calendly.com/casestudy-labs/consultation";
?>
<div class="calendar-section mt-8 p-6 bg-gray-50 rounded-lg border">
    <h4 class="text-xl font-semibold mb-4 text-center">Schedule a Free Consultation</h4>
    <p class="text-center text-gray-600 mb-6">Prefer to speak directly? Book a 30-minute consultation call with our team.</p>
    <div class="text-center">
        <a href="<?php echo esc_url($calendly_url); ?>" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200"
           target="_blank" rel="noopener">
            Book Your Free Consultation
        </a>
    </div>
    <div class="calendly-inline-widget mt-6" data-url="<?php echo esc_url($calendly_url); ?>" style="min-width:320px;height:630px;"></div>
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
</div>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
}

// Register the new shortcode
add_shortcode('csl_contact_form_improved', 'csl_improved_contact_form_shortcode');

/**
 * Handle form submission
 */
function csl_handle_contact_form_submission() {
    // Only process if our form was submitted
    if (!isset($_POST['csl_form_submit']) || $_POST['csl_form_submit'] !== '1') {
        return;
    }
    
    // Debug: Log that we got here
    error_log('Contact form submitted - processing...');
    error_log('POST data: ' . print_r($_POST, true));
    
    // Start session if not already started
    if (!session_id()) {
        session_start();
    }
    
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['csl_contact_nonce'], 'csl_contact_form_submit')) {
        wp_die('Security check failed. Please try again.');
    }
    
    // Check honeypot (spam protection)
    if (!empty($_POST['csl_hp'])) {
        wp_die('Spam detected.');
    }
    
    // Sanitize and validate form data
    $form_data = [
        'name' => sanitize_text_field($_POST['csl_name'] ?? ''),
        'email' => sanitize_email($_POST['csl_email'] ?? ''),
        'phone' => sanitize_text_field($_POST['csl_phone'] ?? ''),
        'company' => sanitize_text_field($_POST['csl_company'] ?? ''),
        'project_type' => sanitize_text_field($_POST['csl_project_type'] ?? ''),
        'budget' => sanitize_text_field($_POST['csl_budget'] ?? ''),
        'timeline' => sanitize_text_field($_POST['csl_timeline'] ?? ''),
        'agency_experience' => sanitize_text_field($_POST['csl_agency_experience'] ?? ''),
        'source' => sanitize_text_field($_POST['csl_source'] ?? ''),
        'utm_source' => sanitize_text_field($_POST['utm_source'] ?? ''),
        'utm_medium' => sanitize_text_field($_POST['utm_medium'] ?? ''),
        'utm_campaign' => sanitize_text_field($_POST['utm_campaign'] ?? ''),
        'utm_term' => sanitize_text_field($_POST['utm_term'] ?? ''),
        'utm_content' => sanitize_text_field($_POST['utm_content'] ?? ''),
        'message' => sanitize_textarea_field($_POST['csl_message'] ?? ''),
        'timestamp' => current_time('mysql'),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ];
    
    // Validate required fields
    $required_fields = ['name', 'email', 'phone', 'project_type', 'budget', 'timeline', 'message'];
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }
    
    // Validate email
    if (!is_email($form_data['email'])) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (!empty($errors)) {
        // Handle validation errors
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $form_data;
        return;
    }
    
    // Calculate lead score
    $lead_score = csl_calculate_lead_score($form_data);
    $form_data['lead_score'] = $lead_score;

    // Save to database table (backward compatibility)
    csl_save_contact_submission($form_data);

    // Create Inquiry CPT entry for better backend management
    $inquiry_id = csl_create_inquiry_from_contact_form($form_data);

    // Send notification emails
    csl_send_contact_notification($form_data, $inquiry_id);

    // Send confirmation email to user
    csl_send_confirmation_email($form_data);
    

    // Add to ESP and trigger automation
    csl_trigger_esp_automation($form_data["email"], $form_data);
    // Create thank you page if it doesn't exist
    $thank_you_page = get_page_by_path('thank-you');
    if (!$thank_you_page) {
        $page_data = array(
            'post_title'    => 'Thank You',
            'post_name'     => 'thank-you',
            'post_content'  => '[csl_thank_you_content]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
        );
        wp_insert_post($page_data);
    }
    
    // Set success message in session instead of redirecting
    $_SESSION['form_success'] = true;
    $_SESSION['lead_score'] = $lead_score;
    
    // Redirect back to contact page
    wp_redirect($_SERVER['REQUEST_URI']);
    exit;
}
add_action('wp', 'csl_handle_contact_form_submission');

/**
 * Calculate lead score based on form responses
 */
function csl_calculate_lead_score($data) {
    $score = 0;
    
    // Budget scoring (most important factor)
    $budget_scores = [
        'under-5k' => 10,
        '5k-10k' => 25,
        '10k-25k' => 50,
        '25k-50k' => 75,
        '50k-plus' => 100,
        'lets-discuss' => 80
    ];
    $score += $budget_scores[$data['budget']] ?? 0;
    
    // Timeline scoring (urgency factor)
    $timeline_scores = [
        'asap' => 30,
        '1-3-months' => 25,
        '3-6-months' => 15,
        '6-plus-months' => 5,
        'planning' => 10,
        'flexible' => 10
    ];
    $score += $timeline_scores[$data['timeline']] ?? 0;
    
    // Project type scoring
    $project_scores = [
        'website' => 20,
        'branding' => 25,
        'marketing' => 15,
        'ecommerce' => 30,
        'audit' => 10,
        'packaging' => 20,
        'other' => 15
    ];
    $score += $project_scores[$data['project_type']] ?? 0;
    
    // Agency experience bonus
    if ($data['agency_experience'] === 'previous-good') {
        $score += 10;
    } elseif ($data['agency_experience'] === 'in-house-team') {
        $score += 5;
    }
    
    // Company provided bonus
    if (!empty($data['company'])) {
        $score += 5;
    }
    
    // Phone provided bonus (shows serious intent)
    if (!empty($data['phone'])) {
        $score += 5;
    }
    
    return min($score, 100); // Cap at 100
}

/**
 * Create Inquiry CPT from contact form data
 */
function csl_create_inquiry_from_contact_form($form_data) {
    // Create inquiry post
    $post_data = [
        'post_type' => 'inquiry',
        'post_status' => 'publish',
        'post_title' => sprintf(
            'Inquiry: %s — %s',
            $form_data['name'],
            wp_trim_words($form_data['message'], 5, '...')
        ),
    ];

    $inquiry_id = wp_insert_post($post_data);

    if (is_wp_error($inquiry_id)) {
        error_log('Failed to create inquiry CPT: ' . $inquiry_id->get_error_message());
        return 0;
    }

    // Save form data as post meta
    update_post_meta($inquiry_id, 'inquiry_source', 'form');
    update_post_meta($inquiry_id, 'inquiry_name', $form_data['name']);
    update_post_meta($inquiry_id, 'inquiry_email', $form_data['email']);
    update_post_meta($inquiry_id, 'inquiry_phone', $form_data['phone']);
    update_post_meta($inquiry_id, 'inquiry_company', $form_data['company']);
    update_post_meta($inquiry_id, 'inquiry_project_type', $form_data['project_type']);
    update_post_meta($inquiry_id, 'inquiry_budget', $form_data['budget']);
    update_post_meta($inquiry_id, 'inquiry_timeline', $form_data['timeline']);
    update_post_meta($inquiry_id, 'inquiry_agency_experience', $form_data['agency_experience']);
    update_post_meta($inquiry_id, 'inquiry_referral_source', $form_data['source']);
    update_post_meta($inquiry_id, 'inquiry_message', $form_data['message']);
    update_post_meta($inquiry_id, 'lead_score', $form_data['lead_score']);
    update_post_meta($inquiry_id, 'inquiry_status', 'new');
    update_post_meta($inquiry_id, 'inquiry_ip', $form_data['ip_address']);
    update_post_meta($inquiry_id, 'inquiry_user_agent', $form_data['user_agent']);

    // Debug log
    error_log('Created inquiry #' . $inquiry_id . ' from contact form with lead score: ' . $form_data['lead_score']);

    return $inquiry_id;
}

/**
 * Save contact form submission to database
 */
function csl_save_contact_submission($data) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'csl_contact_submissions';
    
    // Create table if it doesn't exist
    csl_create_contact_submissions_table();
    
    $wpdb->insert(
        $table_name,
        $data,
        [
            '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 
            '%s', '%s', '%s', '%d'
        ]
    );
}

/**
 * Create contact submissions table
 */
function csl_create_contact_submissions_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'csl_contact_submissions';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) DEFAULT '',
        company varchar(255) DEFAULT '',
        project_type varchar(50) NOT NULL,
        budget varchar(20) NOT NULL,
        timeline varchar(30) NOT NULL,
        agency_experience varchar(50) DEFAULT '',
        source varchar(50) DEFAULT '',
        message text NOT NULL,
        lead_score int(3) DEFAULT 0,
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        ip_address varchar(45) DEFAULT '',
        user_agent text DEFAULT '',
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY lead_score (lead_score),
        KEY timestamp (timestamp)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Send notification email to admin
 */
function csl_send_contact_notification($data, $inquiry_id = 0) {
    $to = 'dough@casestudylabs.com'; // Force correct admin email
    $subject = "New High-Quality Lead: {$data['name']} (Score: {$data['lead_score']})";

    // Debug: Log email attempt
    error_log('Sending admin email to: ' . $to);
    error_log('Subject: ' . $subject);

    $message = "New contact form submission with lead score: {$data['lead_score']}/100\n\n";
    $message .= "Name: {$data['name']}\n";
    $message .= "Email: {$data['email']}\n";
    $message .= "Phone: " . ($data['phone'] ?: 'Not provided') . "\n";
    $message .= "Company: " . ($data['company'] ?: 'Not provided') . "\n\n";
    $message .= "Project Details:\n";
    $message .= "Type: {$data['project_type']}\n";
    $message .= "Budget: {$data['budget']}\n";
    $message .= "Timeline: {$data['timeline']}\n";
    $message .= "Agency Experience: " . ($data['agency_experience'] ?: 'Not specified') . "\n";
    $message .= "Source: " . ($data['source'] ?: 'Not specified') . "\n\n";
    $message .= "Message:\n{$data['message']}\n\n";
    $message .= "Submitted: {$data['timestamp']}\n";

    // Add admin link if inquiry was created
    if ($inquiry_id) {
        $message .= "\nView in admin: " . admin_url('post.php?post=' . $inquiry_id . '&action=edit') . "\n";
    }

    wp_mail($to, $subject, $message);
}

/**
 * Send confirmation email to user
 */
function csl_send_confirmation_email($data) {
    $to = $data['email'];
    $subject = "Thanks for your inquiry, {$data['name']}! We'll be in touch soon.";
    
    $message = "Hi {$data['name']},\n\n";
    $message .= "Thanks for reaching out to Case Study Labs! We received your inquiry about {$data['project_type']} and we are excited to learn more about your project.\n\n";
    $message .= "What's Next:\n";
    $message .= "• We will review your project details within 24 hours\n";
    $message .= "• If we are a good fit, we will schedule a discovery call\n";
    $message .= "• We will provide a custom proposal and timeline\n\n";
    $message .= "In the meantime, feel free to:\n";
    $message .= "• Check out our case studies: " . home_url('/case-studies') . "\n";
    $message .= "• Learn about our process: " . home_url('/our-process') . "\n";
    $message .= "• Book a call directly: https://calendar.app.google/z1veEHms9x3RJAT79\n\n";
    $message .= "Best,\nThe Case Study Labs Team\n\n";
    $message .= "---\n";
    $message .= "Case Study Labs\n";
    $message .= "Strategic Design & Brand Elevation\n";
    $message .= "dough@casestudylabs.com\n";
    
    wp_mail($to, $subject, $message);
}

/**
 * Thank you page content shortcode with lead score integration
 */
function csl_thank_you_content_shortcode($atts = []) {
    $atts = shortcode_atts([
        'default_title' => 'Thanks for Your Inquiry!',
        'default_message' => 'We received your project inquiry and will be in touch within 24 hours.'
    ], $atts);
    
    // Get lead score from URL parameter
    $lead_score = isset($_GET['lead']) ? (int)$_GET['lead'] : 0;
    
    // Customize content based on lead score
    if ($lead_score >= 80) {
        $title = 'High-Priority Inquiry Received!';
        $message = 'Thank you for your detailed inquiry! Based on your project details, we are very excited to discuss this opportunity. Expect a call from our team within 4-6 hours.';
        $priority_class = 'high-priority';
        $cta_text = 'Schedule Priority Call';
    } elseif ($lead_score >= 50) {
        $title = 'Thanks for Your Inquiry!';
        $message = 'We received your project details and are excited to learn more. Our team will review everything and get back to you within 12-24 hours.';
        $priority_class = 'medium-priority';
        $cta_text = 'Book Discovery Call';
    } else {
        $title = $atts['default_title'];
        $message = $atts['default_message'];
        $priority_class = 'standard-priority';
        $cta_text = 'Schedule Call';
    }
    
    ob_start();
    ?>
    
    <div class="thank-you-content <?php echo esc_attr($priority_class); ?>">
        <h1 class="section-heading"><?php echo esc_html($title); ?></h1>
        <p class="text-secondary max-measure"><?php echo esc_html($message); ?></p>
        
        <?php if ($lead_score >= 70): ?>
        <div class="priority-notice glass-panel mt-6 mb-6">
            <h3 class="h4 mb-2">🚀 Priority Status</h3>
            <p class="text-sm">Your project profile indicates a high-value opportunity. We are fast-tracking your inquiry for immediate review.</p>
        </div>
        <?php endif; ?>
        
        <div class="cta-group mt-8">
            <a href="https://calendar.app.google/z1veEHms9x3RJAT79" class="btn btn-primary" target="_blank">
                <?php echo esc_html($cta_text); ?>
            </a>
            <a href="/case-studies" class="btn btn-secondary">View Case Studies</a>
        </div>
        
        <div class="next-steps mt-12">
            <h3 class="h4 mb-4">What Happens Next?</h3>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Review & Analysis</h4>
                        <p>We will analyze your project requirements and budget</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Discovery Call</h4>
                        <p>Schedule a conversation to discuss your vision</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Custom Proposal</h4>
                        <p>Receive a tailored strategy and timeline</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contact-info mt-12 glass-panel">
            <h3 class="h5 mb-3">Have Questions?</h3>
            <p class="text-sm mb-4">Need to discuss your project immediately?</p>
            <a href="mailto:dough@casestudylabs.com" class="btn btn-accent btn-sm">
                Email Us Directly
            </a>
        </div>
    </div>
    
    <style>
    .thank-you-content.high-priority .section-heading {
        color: var(--color-primary-500);
    }
    
    .priority-notice {
        background: linear-gradient(135deg, var(--color-primary-50), var(--color-primary-100));
        border: 1px solid var(--color-primary-200);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
    }
    
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-6);
        margin-top: var(--space-8);
    }
    
    .step {
        display: flex;
        gap: var(--space-4);
        align-items: flex-start;
    }
    
    .step-number {
        background: var(--color-primary-500);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: var(--fw-bold);
        font-size: var(--fs-sm);
        flex-shrink: 0;
    }
    
    .step-content h4 {
        margin: 0 0 var(--space-2) 0;
        font-size: var(--fs-lg);
        font-weight: var(--fw-semibold);
    }
    
    .step-content p {
        margin: 0;
        font-size: var(--fs-sm);
        color: var(--color-text-secondary);
    }
    
    .contact-info {
        text-align: center;
        padding: var(--space-6);
    }
    
    @media (max-width: 768px) {
        .steps-grid {
            grid-template-columns: 1fr;
        }
        
        .step {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
    </style>
    
    <?php
    return ob_get_clean();
}
add_shortcode('csl_thank_you_content', 'csl_thank_you_content_shortcode');
