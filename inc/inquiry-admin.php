<?php
/**
 * Inquiry Admin Backend Customizations
 * Custom columns, filters, meta boxes, and dashboard widgets for managing leads
 *
 * @package CSL_Agency
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/*--------------------------------------------------------------
# Custom Admin Columns for Inquiries
--------------------------------------------------------------*/
add_filter('manage_inquiry_posts_columns', 'csl_inquiry_admin_columns');
function csl_inquiry_admin_columns($columns) {
    // Remove default columns
    unset($columns['date']);

    // Add custom columns
    $new_columns = [
        'cb'            => $columns['cb'],
        'title'         => $columns['title'],
        'source'        => 'Source',
        'contact_info'  => 'Contact Info',
        'project_type'  => 'Project Type',
        'budget'        => 'Budget',
        'timeline'      => 'Timeline',
        'lead_score'    => 'Lead Score',
        'status'        => 'Status',
        'date'          => 'Date',
    ];

    return $new_columns;
}

add_action('manage_inquiry_posts_custom_column', 'csl_inquiry_admin_column_content', 10, 2);
function csl_inquiry_admin_column_content($column, $post_id) {
    $source = get_post_meta($post_id, 'inquiry_source', true);

    switch ($column) {
        case 'source':
            $badge_color = $source === 'quiz' ? '#9b59b6' : '#3498db';
            echo '<span style="display:inline-block;padding:4px 10px;border-radius:12px;background:' . esc_attr($badge_color) . ';color:#fff;font-size:11px;font-weight:600;text-transform:uppercase;">';
            echo $source === 'quiz' ? '🎯 Quiz' : '📝 Form';
            echo '</span>';
            break;

        case 'contact_info':
            $name = get_post_meta($post_id, 'inquiry_name', true);
            $email = get_post_meta($post_id, 'inquiry_email', true);
            $phone = get_post_meta($post_id, 'inquiry_phone', true);
            $company = get_post_meta($post_id, 'inquiry_company', true);

            echo '<div style="line-height:1.6;">';
            if ($name) {
                echo '<strong>' . esc_html($name) . '</strong><br>';
            }
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a><br>';
            }
            if ($phone) {
                echo '<span style="color:#666;">📞 ' . esc_html($phone) . '</span><br>';
            }
            if ($company) {
                echo '<span style="color:#666;">🏢 ' . esc_html($company) . '</span>';
            }
            echo '</div>';
            break;

        case 'project_type':
            if ($source === 'quiz') {
                $top_need = get_post_meta($post_id, 'quiz_top_need', true);
                echo '<span style="padding:4px 8px;background:#f0f0f0;border-radius:4px;font-size:12px;">';
                echo ucfirst(esc_html($top_need ?: 'N/A'));
                echo '</span>';
            } else {
                $project_type = get_post_meta($post_id, 'inquiry_project_type', true);
                echo '<span style="padding:4px 8px;background:#f0f0f0;border-radius:4px;font-size:12px;">';
                echo esc_html(ucwords(str_replace('-', ' ', $project_type ?: 'N/A')));
                echo '</span>';
            }
            break;

        case 'budget':
            if ($source === 'quiz') {
                $budget = get_post_meta($post_id, 'quiz_budget_level', true);
            } else {
                $budget = get_post_meta($post_id, 'inquiry_budget', true);
            }

            // Budget color coding
            $budget_colors = [
                'under-5k'   => '#95a5a6',
                '5k-10k'     => '#3498db',
                '10k-25k'    => '#2ecc71',
                '25k-50k'    => '#f39c12',
                '50k-plus'   => '#e74c3c',
                'lets-discuss' => '#9b59b6',
            ];

            $color = $budget_colors[$budget] ?? '#95a5a6';

            echo '<span style="display:inline-block;padding:4px 10px;border-radius:4px;background:' . esc_attr($color) . ';color:#fff;font-size:11px;font-weight:600;">';
            echo esc_html(ucwords(str_replace('-', ' ', $budget ?: 'N/A')));
            echo '</span>';
            break;

        case 'timeline':
            if ($source === 'quiz') {
                $timeline = get_post_meta($post_id, 'quiz_urgency', true);
            } else {
                $timeline = get_post_meta($post_id, 'inquiry_timeline', true);
            }

            echo '<span style="padding:4px 8px;background:#f0f0f0;border-radius:4px;font-size:12px;">';
            echo esc_html(ucwords(str_replace('-', ' ', $timeline ?: 'N/A')));
            echo '</span>';
            break;

        case 'lead_score':
            $lead_score = (int) get_post_meta($post_id, 'lead_score', true);

            // Color coding based on score
            if ($lead_score >= 80) {
                $color = '#e74c3c';
                $label = 'HOT';
            } elseif ($lead_score >= 50) {
                $color = '#f39c12';
                $label = 'WARM';
            } else {
                $color = '#95a5a6';
                $label = 'COLD';
            }

            echo '<div style="text-align:center;">';
            echo '<div style="font-size:20px;font-weight:700;color:' . esc_attr($color) . ';">' . esc_html($lead_score) . '</div>';
            echo '<div style="font-size:10px;color:' . esc_attr($color) . ';font-weight:600;">' . esc_html($label) . '</div>';
            echo '</div>';
            break;

        case 'status':
            $status = get_post_meta($post_id, 'inquiry_status', true) ?: 'new';

            $status_labels = [
                'new'        => ['New', '#3498db'],
                'contacted'  => ['Contacted', '#f39c12'],
                'qualified'  => ['Qualified', '#2ecc71'],
                'proposal'   => ['Proposal Sent', '#9b59b6'],
                'won'        => ['Won', '#27ae60'],
                'lost'       => ['Lost', '#95a5a6'],
                'quiz_completed' => ['Quiz Done', '#9b59b6'],
            ];

            $label = $status_labels[$status][0] ?? ucfirst($status);
            $color = $status_labels[$status][1] ?? '#95a5a6';

            echo '<span style="display:inline-block;padding:4px 10px;border-radius:12px;background:' . esc_attr($color) . ';color:#fff;font-size:11px;font-weight:600;">';
            echo esc_html($label);
            echo '</span>';
            break;
    }
}

/*--------------------------------------------------------------
# Make Columns Sortable
--------------------------------------------------------------*/
add_filter('manage_edit-inquiry_sortable_columns', 'csl_inquiry_sortable_columns');
function csl_inquiry_sortable_columns($columns) {
    $columns['lead_score'] = 'lead_score';
    $columns['status'] = 'inquiry_status';
    $columns['source'] = 'inquiry_source';
    $columns['budget'] = 'inquiry_budget';

    return $columns;
}

add_action('pre_get_posts', 'csl_inquiry_column_orderby');
function csl_inquiry_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('inquiry' !== $query->get('post_type')) {
        return;
    }

    $orderby = $query->get('orderby');

    switch ($orderby) {
        case 'lead_score':
            $query->set('meta_key', 'lead_score');
            $query->set('orderby', 'meta_value_num');
            break;

        case 'inquiry_status':
            $query->set('meta_key', 'inquiry_status');
            $query->set('orderby', 'meta_value');
            break;

        case 'inquiry_source':
            $query->set('meta_key', 'inquiry_source');
            $query->set('orderby', 'meta_value');
            break;

        case 'inquiry_budget':
            $query->set('meta_key', 'inquiry_budget');
            $query->set('orderby', 'meta_value');
            break;
    }
}

/*--------------------------------------------------------------
# Admin Filters (Dropdowns)
--------------------------------------------------------------*/
add_action('restrict_manage_posts', 'csl_inquiry_admin_filters');
function csl_inquiry_admin_filters($post_type) {
    if ('inquiry' !== $post_type) {
        return;
    }

    // Source filter
    $source = isset($_GET['inquiry_source']) ? $_GET['inquiry_source'] : '';
    ?>
    <select name="inquiry_source">
        <option value="">All Sources</option>
        <option value="quiz" <?php selected($source, 'quiz'); ?>>Quiz</option>
        <option value="form" <?php selected($source, 'form'); ?>>Contact Form</option>
    </select>

    <?php
    // Status filter
    $status = isset($_GET['inquiry_status']) ? $_GET['inquiry_status'] : '';
    ?>
    <select name="inquiry_status">
        <option value="">All Statuses</option>
        <option value="new" <?php selected($status, 'new'); ?>>New</option>
        <option value="contacted" <?php selected($status, 'contacted'); ?>>Contacted</option>
        <option value="qualified" <?php selected($status, 'qualified'); ?>>Qualified</option>
        <option value="proposal" <?php selected($status, 'proposal'); ?>>Proposal Sent</option>
        <option value="won" <?php selected($status, 'won'); ?>>Won</option>
        <option value="lost" <?php selected($status, 'lost'); ?>>Lost</option>
    </select>

    <?php
    // Lead score filter
    $score = isset($_GET['min_lead_score']) ? $_GET['min_lead_score'] : '';
    ?>
    <select name="min_lead_score">
        <option value="">All Lead Scores</option>
        <option value="80" <?php selected($score, '80'); ?>>Hot Leads (80+)</option>
        <option value="50" <?php selected($score, '50'); ?>>Warm Leads (50+)</option>
        <option value="0" <?php selected($score, '0'); ?>>All Leads</option>
    </select>
    <?php
}

add_filter('parse_query', 'csl_inquiry_filter_query');
function csl_inquiry_filter_query($query) {
    global $pagenow;

    if (!is_admin() || 'edit.php' !== $pagenow || !isset($_GET['post_type']) || 'inquiry' !== $_GET['post_type']) {
        return;
    }

    $meta_query = [];

    // Source filter
    if (!empty($_GET['inquiry_source'])) {
        $meta_query[] = [
            'key'   => 'inquiry_source',
            'value' => sanitize_text_field($_GET['inquiry_source']),
        ];
    }

    // Status filter
    if (!empty($_GET['inquiry_status'])) {
        $meta_query[] = [
            'key'   => 'inquiry_status',
            'value' => sanitize_text_field($_GET['inquiry_status']),
        ];
    }

    // Lead score filter
    if (isset($_GET['min_lead_score']) && $_GET['min_lead_score'] !== '') {
        $meta_query[] = [
            'key'     => 'lead_score',
            'value'   => (int) $_GET['min_lead_score'],
            'compare' => '>=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($meta_query)) {
        $query->set('meta_query', $meta_query);
    }
}

/*--------------------------------------------------------------
# Meta Box: Inquiry Details
--------------------------------------------------------------*/
add_action('add_meta_boxes', 'csl_inquiry_meta_boxes');
function csl_inquiry_meta_boxes() {
    add_meta_box(
        'csl_inquiry_details',
        'Inquiry Details',
        'csl_inquiry_details_callback',
        'inquiry',
        'normal',
        'high'
    );

    add_meta_box(
        'csl_inquiry_actions',
        'Quick Actions',
        'csl_inquiry_actions_callback',
        'inquiry',
        'side',
        'high'
    );
}

function csl_inquiry_details_callback($post) {
    $source = get_post_meta($post->ID, 'inquiry_source', true);
    $is_quiz = ($source === 'quiz');

    ?>
    <style>
        .inquiry-meta-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .inquiry-meta-table th { text-align: left; padding: 10px; background: #f5f5f5; font-weight: 600; width: 180px; }
        .inquiry-meta-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .inquiry-score-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 18px; color: #fff; }
        .inquiry-score-hot { background: #e74c3c; }
        .inquiry-score-warm { background: #f39c12; }
        .inquiry-score-cold { background: #95a5a6; }
    </style>

    <table class="inquiry-meta-table">
        <tr>
            <th>Source</th>
            <td>
                <?php if ($is_quiz): ?>
                    <span style="color: #9b59b6; font-weight: 600;">🎯 Brand Clarity Quiz</span>
                <?php else: ?>
                    <span style="color: #3498db; font-weight: 600;">📝 Contact Form</span>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>Name</th>
            <td><strong><?php echo esc_html(get_post_meta($post->ID, 'inquiry_name', true)); ?></strong></td>
        </tr>

        <tr>
            <th>Email</th>
            <td>
                <a href="mailto:<?php echo esc_attr(get_post_meta($post->ID, 'inquiry_email', true)); ?>">
                    <?php echo esc_html(get_post_meta($post->ID, 'inquiry_email', true)); ?>
                </a>
            </td>
        </tr>

        <tr>
            <th>Phone</th>
            <td><?php echo esc_html(get_post_meta($post->ID, 'inquiry_phone', true) ?: 'Not provided'); ?></td>
        </tr>

        <tr>
            <th>Company</th>
            <td><?php echo esc_html(get_post_meta($post->ID, 'inquiry_company', true) ?: 'Not provided'); ?></td>
        </tr>

        <?php if ($is_quiz): ?>
            <tr>
                <th>Top Need</th>
                <td><strong><?php echo esc_html(ucfirst(get_post_meta($post->ID, 'quiz_top_need', true))); ?></strong></td>
            </tr>

            <tr>
                <th>Quiz Scores</th>
                <td>
                    <?php
                    $scores = get_post_meta($post->ID, 'quiz_scores', true);
                    if (is_array($scores)) {
                        echo 'Branding: ' . (int) ($scores['branding'] ?? 0) . ' | ';
                        echo 'Strategy: ' . (int) ($scores['strategy'] ?? 0) . ' | ';
                        echo 'Marketing: ' . (int) ($scores['marketing'] ?? 0);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Budget Level</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'quiz_budget_level', true)))); ?></td>
            </tr>

            <tr>
                <th>Urgency</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'quiz_urgency', true)))); ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <th>Project Type</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'inquiry_project_type', true)))); ?></td>
            </tr>

            <tr>
                <th>Budget</th>
                <td><strong><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'inquiry_budget', true)))); ?></strong></td>
            </tr>

            <tr>
                <th>Timeline</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'inquiry_timeline', true)))); ?></td>
            </tr>

            <tr>
                <th>Agency Experience</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'inquiry_agency_experience', true) ?: 'Not specified'))); ?></td>
            </tr>

            <tr>
                <th>Referral Source</th>
                <td><?php echo esc_html(ucwords(str_replace('-', ' ', get_post_meta($post->ID, 'inquiry_referral_source', true) ?: 'Not specified'))); ?></td>
            </tr>

            <tr>
                <th>Message</th>
                <td><?php echo nl2br(esc_html(get_post_meta($post->ID, 'inquiry_message', true))); ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <th>Lead Score</th>
            <td>
                <?php
                $lead_score = (int) get_post_meta($post->ID, 'lead_score', true);
                $score_class = $lead_score >= 80 ? 'hot' : ($lead_score >= 50 ? 'warm' : 'cold');
                $score_label = $lead_score >= 80 ? 'HOT LEAD' : ($lead_score >= 50 ? 'WARM LEAD' : 'COLD LEAD');
                ?>
                <span class="inquiry-score-badge inquiry-score-<?php echo $score_class; ?>">
                    <?php echo $lead_score; ?>/100 - <?php echo $score_label; ?>
                </span>
            </td>
        </tr>

        <tr>
            <th>IP Address</th>
            <td><?php echo esc_html(get_post_meta($post->ID, 'inquiry_ip', true)); ?></td>
        </tr>

        <tr>
            <th>Submitted</th>
            <td><?php echo get_the_date('F j, Y g:i a', $post->ID); ?></td>
        </tr>
    </table>
    <?php
}

function csl_inquiry_actions_callback($post) {
    $status = get_post_meta($post->ID, 'inquiry_status', true) ?: 'new';
    $email = get_post_meta($post->ID, 'inquiry_email', true);
    $phone = get_post_meta($post->ID, 'inquiry_phone', true);
    $name = get_post_meta($post->ID, 'inquiry_name', true);

    wp_nonce_field('csl_inquiry_status_update', 'csl_inquiry_status_nonce');
    ?>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Update Status</label>
        <select name="inquiry_status" id="inquiry_status" style="width: 100%; padding: 8px;">
            <option value="new" <?php selected($status, 'new'); ?>>New</option>
            <option value="contacted" <?php selected($status, 'contacted'); ?>>Contacted</option>
            <option value="qualified" <?php selected($status, 'qualified'); ?>>Qualified</option>
            <option value="proposal" <?php selected($status, 'proposal'); ?>>Proposal Sent</option>
            <option value="won" <?php selected($status, 'won'); ?>>Won</option>
            <option value="lost" <?php selected($status, 'lost'); ?>>Lost</option>
        </select>
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Quick Contact</label>
        <a href="mailto:<?php echo esc_attr($email); ?>?subject=Re: Your inquiry with Case Study Labs&body=Hi <?php echo esc_attr($name); ?>,%0D%0A%0D%0A"
           class="button button-primary" style="width: 100%; text-align: center; margin-bottom: 8px; display: block;">
            📧 Send Email
        </a>
        <?php if ($phone): ?>
        <a href="tel:<?php echo esc_attr($phone); ?>" class="button" style="width: 100%; text-align: center; display: block;">
            📞 Call <?php echo esc_html($phone); ?>
        </a>
        <?php endif; ?>
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Notes</label>
        <textarea name="inquiry_notes" id="inquiry_notes" rows="5" style="width: 100%;"><?php echo esc_textarea(get_post_meta($post->ID, 'inquiry_notes', true)); ?></textarea>
        <p class="description">Internal notes about this inquiry</p>
    </div>
    <?php
}

// Save meta box data
add_action('save_post_inquiry', 'csl_save_inquiry_meta');
function csl_save_inquiry_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['csl_inquiry_status_nonce']) || !wp_verify_nonce($_POST['csl_inquiry_status_nonce'], 'csl_inquiry_status_update')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save status
    if (isset($_POST['inquiry_status'])) {
        update_post_meta($post_id, 'inquiry_status', sanitize_text_field($_POST['inquiry_status']));
    }

    // Save notes
    if (isset($_POST['inquiry_notes'])) {
        update_post_meta($post_id, 'inquiry_notes', sanitize_textarea_field($_POST['inquiry_notes']));
    }
}

/*--------------------------------------------------------------
# Dashboard Widget: Hot Leads
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_add_hot_leads_dashboard_widget');
function csl_add_hot_leads_dashboard_widget() {
    // Only add widget in admin context where the function exists
    if (!function_exists('wp_add_dashboard_widget')) {
        return;
    }

    wp_add_dashboard_widget(
        'csl_hot_leads_widget',
        '🔥 Hot Leads - Priority Inquiries',
        'csl_hot_leads_widget_content'
    );
}

function csl_hot_leads_widget_content() {
    $args = [
        'post_type'      => 'inquiry',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => 'lead_score',
                'value'   => 70,
                'compare' => '>=',
                'type'    => 'NUMERIC',
            ],
        ],
        'meta_key'       => 'lead_score',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ];

    $hot_leads = new WP_Query($args);

    if ($hot_leads->have_posts()): ?>
        <style>
            .hot-lead-item {
                padding: 12px;
                margin-bottom: 10px;
                background: #f9f9f9;
                border-left: 4px solid #e74c3c;
                border-radius: 4px;
            }
            .hot-lead-item:hover { background: #f0f0f0; }
            .hot-lead-score {
                display: inline-block;
                padding: 4px 10px;
                background: #e74c3c;
                color: #fff;
                border-radius: 12px;
                font-weight: 700;
                font-size: 12px;
                margin-right: 8px;
            }
            .hot-lead-name { font-weight: 600; font-size: 14px; color: #333; }
            .hot-lead-details { font-size: 12px; color: #666; margin-top: 4px; }
        </style>

        <?php while ($hot_leads->have_posts()): $hot_leads->the_post();
            $post_id = get_the_ID();
            $lead_score = get_post_meta($post_id, 'lead_score', true);
            $name = get_post_meta($post_id, 'inquiry_name', true);
            $email = get_post_meta($post_id, 'inquiry_email', true);
            $source = get_post_meta($post_id, 'inquiry_source', true);
            $budget = get_post_meta($post_id, $source === 'quiz' ? 'quiz_budget_level' : 'inquiry_budget', true);
            ?>
            <div class="hot-lead-item">
                <div>
                    <span class="hot-lead-score"><?php echo esc_html($lead_score); ?></span>
                    <span class="hot-lead-name"><?php echo esc_html($name); ?></span>
                    <?php if ($source === 'quiz'): ?>
                        <span style="color: #9b59b6; font-size: 12px;">🎯</span>
                    <?php endif; ?>
                </div>
                <div class="hot-lead-details">
                    <?php echo esc_html($email); ?> •
                    Budget: <?php echo esc_html(ucwords(str_replace('-', ' ', $budget))); ?> •
                    <?php echo human_time_diff(get_post_time('U', false, $post_id), current_time('timestamp')); ?> ago
                </div>
                <div style="margin-top: 8px;">
                    <a href="<?php echo admin_url('post.php?post=' . $post_id . '&action=edit'); ?>" class="button button-small">View Details</a>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="button button-small">Email</a>
                </div>
            </div>
        <?php endwhile; ?>

        <p style="text-align: center; margin-top: 15px;">
            <a href="<?php echo admin_url('edit.php?post_type=inquiry&min_lead_score=70'); ?>" class="button button-primary">
                View All Hot Leads →
            </a>
        </p>
    <?php else: ?>
        <p style="text-align: center; color: #999; padding: 20px;">No hot leads at the moment. Keep marketing! 🚀</p>
    <?php endif;

    wp_reset_postdata();
}

/*--------------------------------------------------------------
# Admin CSS Enhancements
--------------------------------------------------------------*/
add_action('admin_head', 'csl_inquiry_admin_css');
function csl_inquiry_admin_css() {
    global $post_type;
    if ('inquiry' !== $post_type) {
        return;
    }
    ?>
    <style>
        .widefat .column-lead_score { width: 80px; text-align: center; }
        .widefat .column-status { width: 120px; }
        .widefat .column-source { width: 100px; }
        .widefat .column-budget { width: 130px; }
        .widefat .column-timeline { width: 130px; }
        .widefat .column-project_type { width: 140px; }
        .widefat .column-contact_info { min-width: 200px; }
    </style>
    <?php
}
