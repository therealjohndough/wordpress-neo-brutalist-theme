<?php
/**
 * Dashboard Customization
 * Custom widgets, stats, quick links, and admin styling
 *
 * @package CSL_Agency
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/*--------------------------------------------------------------
# Remove Default WordPress Dashboard Widgets
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_remove_default_dashboard_widgets', 999);
function csl_remove_default_dashboard_widgets() {
    // Remove WordPress News
    remove_meta_box('dashboard_primary', 'dashboard', 'side');

    // Remove Quick Draft
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');

    // Remove Activity
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');

    // Remove Site Health
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');

    // Remove Welcome panel
    remove_action('welcome_panel', 'wp_welcome_panel');
}

/*--------------------------------------------------------------
# Dashboard Widget: Quick Stats
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_add_quick_stats_widget');
function csl_add_quick_stats_widget() {
    if (!function_exists('wp_add_dashboard_widget')) {
        return;
    }

    wp_add_dashboard_widget(
        'csl_quick_stats_widget',
        '📊 Quick Stats - Business Overview',
        'csl_quick_stats_widget_content'
    );
}

function csl_quick_stats_widget_content() {
    // Get inquiry stats
    $total_inquiries = wp_count_posts('inquiry')->publish;

    // Get inquiries from last 30 days
    $recent_inquiries = new WP_Query([
        'post_type' => 'inquiry',
        'post_status' => 'publish',
        'date_query' => [
            [
                'after' => '30 days ago',
            ],
        ],
        'fields' => 'ids',
    ]);
    $inquiries_30_days = $recent_inquiries->found_posts;

    // Get hot leads (70+)
    $hot_leads = new WP_Query([
        'post_type' => 'inquiry',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => 'lead_score',
                'value' => 70,
                'compare' => '>=',
                'type' => 'NUMERIC',
            ],
        ],
        'fields' => 'ids',
    ]);
    $hot_leads_count = $hot_leads->found_posts;

    // Get new/uncontacted inquiries
    $new_inquiries = new WP_Query([
        'post_type' => 'inquiry',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => 'inquiry_status',
                'value' => 'new',
                'compare' => '=',
            ],
        ],
        'fields' => 'ids',
    ]);
    $new_count = $new_inquiries->found_posts;

    // Get case studies count
    $case_studies = wp_count_posts('casestudy')->publish;

    // Get client projects count
    $client_projects = wp_count_posts('client_project')->publish;

    // Calculate average lead score
    global $wpdb;
    $avg_score = $wpdb->get_var("
        SELECT AVG(CAST(meta_value AS DECIMAL(5,2)))
        FROM {$wpdb->postmeta}
        WHERE meta_key = 'lead_score'
        AND CAST(meta_value AS DECIMAL(5,2)) > 0
    ");
    $avg_score = round($avg_score ?? 0);

    ?>
    <style>
        .csl-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        .csl-stat-box {
            background: linear-gradient(135deg, #f5f5f5 0%, #fff 100%);
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .csl-stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #ff4500;
        }
        .csl-stat-number {
            font-size: 36px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 8px;
        }
        .csl-stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .csl-stat-sublabel {
            font-size: 11px;
            color: #999;
            margin-top: 4px;
        }
        .stat-hot { color: #e74c3c; }
        .stat-new { color: #3498db; }
        .stat-avg { color: #f39c12; }
        .stat-total { color: #2ecc71; }
        .stat-work { color: #9b59b6; }
        .stat-clients { color: #16a085; }
    </style>

    <div class="csl-stats-grid">
        <div class="csl-stat-box">
            <div class="csl-stat-number stat-new"><?php echo $new_count; ?></div>
            <div class="csl-stat-label">New Leads</div>
            <div class="csl-stat-sublabel">Need Response</div>
        </div>

        <div class="csl-stat-box">
            <div class="csl-stat-number stat-hot"><?php echo $hot_leads_count; ?></div>
            <div class="csl-stat-label">Hot Leads</div>
            <div class="csl-stat-sublabel">70+ Score</div>
        </div>

        <div class="csl-stat-box">
            <div class="csl-stat-number stat-total"><?php echo $inquiries_30_days; ?></div>
            <div class="csl-stat-label">Last 30 Days</div>
            <div class="csl-stat-sublabel"><?php echo $total_inquiries; ?> Total</div>
        </div>

        <div class="csl-stat-box">
            <div class="csl-stat-number stat-avg"><?php echo $avg_score; ?></div>
            <div class="csl-stat-label">Avg Lead Score</div>
            <div class="csl-stat-sublabel">Out of 100</div>
        </div>

        <div class="csl-stat-box">
            <div class="csl-stat-number stat-work"><?php echo $case_studies; ?></div>
            <div class="csl-stat-label">Case Studies</div>
            <div class="csl-stat-sublabel">Portfolio Items</div>
        </div>

        <div class="csl-stat-box">
            <div class="csl-stat-number stat-clients"><?php echo $client_projects; ?></div>
            <div class="csl-stat-label">Active Projects</div>
            <div class="csl-stat-sublabel">Client Work</div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 15px;">
        <a href="<?php echo admin_url('edit.php?post_type=inquiry&inquiry_status=new'); ?>" class="button button-primary">
            Review New Leads →
        </a>
    </div>
    <?php
}

/*--------------------------------------------------------------
# Dashboard Widget: Quick Links
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_add_quick_links_widget');
function csl_add_quick_links_widget() {
    if (!function_exists('wp_add_dashboard_widget')) {
        return;
    }

    wp_add_dashboard_widget(
        'csl_quick_links_widget',
        '⚡ Quick Actions',
        'csl_quick_links_widget_content'
    );
}

function csl_quick_links_widget_content() {
    ?>
    <style>
        .csl-quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin: 15px 0;
        }
        .csl-quick-link {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f9f9f9;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .csl-quick-link:hover {
            background: #fff;
            border-color: #ff4500;
            color: #ff4500;
            transform: translateX(5px);
        }
        .csl-quick-link-icon {
            font-size: 24px;
            margin-right: 12px;
            line-height: 1;
        }
        .csl-quick-link-text {
            flex: 1;
        }
        .csl-quick-link-badge {
            background: #ff4500;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
        }
    </style>

    <div class="csl-quick-links">
        <a href="<?php echo admin_url('edit.php?post_type=inquiry'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">📧</span>
            <span class="csl-quick-link-text">View All Inquiries</span>
        </a>

        <a href="<?php echo admin_url('edit.php?post_type=inquiry&inquiry_status=new'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">🆕</span>
            <span class="csl-quick-link-text">New Leads</span>
            <?php
            $new_count = new WP_Query([
                'post_type' => 'inquiry',
                'post_status' => 'publish',
                'meta_query' => [['key' => 'inquiry_status', 'value' => 'new']],
                'fields' => 'ids',
            ]);
            if ($new_count->found_posts > 0): ?>
                <span class="csl-quick-link-badge"><?php echo $new_count->found_posts; ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo admin_url('edit.php?post_type=inquiry&min_lead_score=70'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">🔥</span>
            <span class="csl-quick-link-text">Hot Leads (70+)</span>
        </a>

        <a href="<?php echo admin_url('post-new.php?post_type=casestudy'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">📁</span>
            <span class="csl-quick-link-text">Add Case Study</span>
        </a>

        <a href="<?php echo admin_url('edit.php?post_type=casestudy'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">💼</span>
            <span class="csl-quick-link-text">Manage Portfolio</span>
        </a>

        <a href="<?php echo admin_url('post-new.php?post_type=client_project'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">➕</span>
            <span class="csl-quick-link-text">New Client Project</span>
        </a>

        <a href="<?php echo admin_url('edit.php?post_type=client_project'); ?>" class="csl-quick-link">
            <span class="csl-quick-link-icon">👥</span>
            <span class="csl-quick-link-text">Client Projects</span>
        </a>

        <a href="<?php echo home_url('/contact'); ?>" class="csl-quick-link" target="_blank">
            <span class="csl-quick-link-icon">🌐</span>
            <span class="csl-quick-link-text">View Contact Page</span>
        </a>
    </div>
    <?php
}

/*--------------------------------------------------------------
# Dashboard Widget: Support Tickets
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_add_tickets_widget');
function csl_add_tickets_widget() {
    if (!function_exists('wp_add_dashboard_widget')) {
        return;
    }

    wp_add_dashboard_widget(
        'csl_tickets_widget',
        '🎫 Support Tickets',
        'csl_tickets_widget_content'
    );
}

function csl_tickets_widget_content() {
    // Check if tickets custom post type exists
    $ticket_post_type_exists = post_type_exists('support_ticket');

    if (!$ticket_post_type_exists) {
        ?>
        <div style="text-align: center; padding: 30px 20px;">
            <p style="color: #999; margin-bottom: 20px;">Support ticket system is not yet configured.</p>
            <a href="#" onclick="alert('Ticket system setup coming soon!'); return false;" class="button button-primary">
                Set Up Ticketing System
            </a>
        </div>
        <?php
        return;
    }

    // Get recent tickets
    $tickets = new WP_Query([
        'post_type' => 'support_ticket',
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    if (!$tickets->have_posts()) {
        ?>
        <div style="text-align: center; padding: 30px 20px;">
            <p style="color: #999; margin-bottom: 20px;">No support tickets found.</p>
            <a href="<?php echo admin_url('post-new.php?post_type=support_ticket'); ?>" class="button button-primary">
                Create New Ticket
            </a>
        </div>
        <?php
        return;
    }

    ?>
    <style>
        .csl-ticket-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f9f9f9;
            border-left: 4px solid #3498db;
            border-radius: 4px;
        }
        .csl-ticket-item:hover { background: #f0f0f0; }
        .csl-ticket-status {
            display: inline-block;
            padding: 4px 10px;
            background: #3498db;
            color: #fff;
            border-radius: 12px;
            font-weight: 700;
            font-size: 11px;
            margin-right: 8px;
        }
        .csl-ticket-status.status-open { background: #e74c3c; }
        .csl-ticket-status.status-in-progress { background: #f39c12; }
        .csl-ticket-status.status-resolved { background: #2ecc71; }
        .csl-ticket-title { font-weight: 600; font-size: 14px; color: #333; }
        .csl-ticket-meta { font-size: 12px; color: #666; margin-top: 4px; }
    </style>

    <?php while ($tickets->have_posts()): $tickets->the_post();
        $ticket_id = get_the_ID();
        $status = get_post_meta($ticket_id, 'ticket_status', true) ?: 'open';
        ?>
        <div class="csl-ticket-item">
            <div>
                <span class="csl-ticket-status status-<?php echo esc_attr($status); ?>">
                    <?php echo esc_html(strtoupper($status)); ?>
                </span>
                <span class="csl-ticket-title"><?php the_title(); ?></span>
            </div>
            <div class="csl-ticket-meta">
                <?php echo human_time_diff(get_post_time('U'), current_time('timestamp')); ?> ago
            </div>
            <div style="margin-top: 8px;">
                <a href="<?php echo get_edit_post_link(); ?>" class="button button-small">View Ticket</a>
            </div>
        </div>
    <?php endwhile; ?>

    <p style="text-align: center; margin-top: 15px;">
        <a href="<?php echo admin_url('edit.php?post_type=support_ticket'); ?>" class="button">
            View All Tickets →
        </a>
        <a href="<?php echo admin_url('post-new.php?post_type=support_ticket'); ?>" class="button button-primary">
            New Ticket
        </a>
    </p>
    <?php

    wp_reset_postdata();
}

/*--------------------------------------------------------------
# Custom Admin CSS & Styling
--------------------------------------------------------------*/
add_action('admin_head', 'csl_custom_admin_css');
function csl_custom_admin_css() {
    ?>
    <style>
        /* Case Study Labs Admin Branding */
        #wpadminbar {
            background: linear-gradient(90deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        #wpadminbar .ab-item,
        #wpadminbar a.ab-item,
        #wpadminbar > #wp-toolbar span.ab-label,
        #wpadminbar > #wp-toolbar span.noticon {
            color: #f5f5f5;
        }

        #wpadminbar .ab-icon:before,
        #wpadminbar .ab-item:before {
            color: #ff4500;
        }

        #wpadminbar .ab-top-menu > li:hover > .ab-item,
        #wpadminbar .ab-top-menu > li.hover > .ab-item {
            background: rgba(255, 69, 0, 0.2);
            color: #fff;
        }

        /* Admin Menu Styling */
        #adminmenu,
        #adminmenu .wp-submenu,
        #adminmenuback,
        #adminmenuwrap {
            background: #1a1a1a;
        }

        #adminmenu a {
            color: #e0e0e0;
        }

        #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,
        #adminmenu .wp-menu-arrow,
        #adminmenu .wp-menu-arrow div,
        #adminmenu li.current a.menu-top,
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
        .folded #adminmenu li.current.menu-top,
        .folded #adminmenu li.wp-has-current-submenu {
            background: #ff4500;
            color: #fff;
        }

        #adminmenu li.menu-top:hover,
        #adminmenu li.opensub > a.menu-top,
        #adminmenu li > a.menu-top:focus {
            background: rgba(255, 69, 0, 0.3);
            color: #fff;
        }

        #adminmenu .wp-submenu a:hover,
        #adminmenu .wp-submenu a:focus {
            background: rgba(255, 69, 0, 0.2);
            color: #fff;
        }

        /* Dashboard Widget Styling */
        .postbox {
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .postbox .postbox-header {
            background: linear-gradient(135deg, #f5f5f5 0%, #fff 100%);
            border-bottom: 2px solid #ff4500;
        }

        .postbox .postbox-header h2 {
            color: #333;
            font-weight: 600;
        }

        /* Button Styling */
        .button-primary {
            background: #ff4500;
            border-color: #cc3700;
            text-shadow: none;
            box-shadow: 0 2px 4px rgba(255, 69, 0, 0.2);
        }

        .button-primary:hover,
        .button-primary:focus {
            background: #cc3700;
            border-color: #991900;
        }

        /* Welcome Panel Custom */
        .welcome-panel {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: 2px solid #ff4500;
            color: #f5f5f5;
        }

        .welcome-panel h2 {
            color: #ff4500;
        }

        .welcome-panel a {
            color: #ff4500;
        }

        /* Custom Header Branding */
        #wpadminbar #wp-admin-bar-site-name > .ab-item:before {
            content: "🔥";
            top: 2px;
        }

        /* Inquiry Badge Colors Match */
        .widefat .column-source span,
        .widefat .column-budget span,
        .widefat .column-status span {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modern Card Design for Meta Boxes */
        .postbox {
            border-radius: 8px;
            overflow: hidden;
        }

        .postbox .inside {
            padding: 20px;
        }

        /* Success Messages */
        .updated,
        .notice-success {
            border-left-color: #ff4500;
        }
    </style>
    <?php
}

/*--------------------------------------------------------------
# Custom Admin Footer Text
--------------------------------------------------------------*/
add_filter('admin_footer_text', 'csl_custom_admin_footer');
function csl_custom_admin_footer($text) {
    return '<span style="color: #999;">Powered by <strong style="color: #ff4500;">Case Study Labs</strong> | Strategic Design & Brand Elevation</span>';
}

/*--------------------------------------------------------------
# Custom Login Logo
--------------------------------------------------------------*/
add_action('login_head', 'csl_custom_login_logo');
function csl_custom_login_logo() {
    ?>
    <style>
        body.login {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        .login h1 a {
            background-image: none;
            background-color: #ff4500;
            width: 200px;
            height: 80px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
            text-indent: 0;
        }

        .login h1 a:before {
            content: "CSL";
        }

        .login form {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #ff4500;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .login #backtoblog a,
        .login #nav a {
            color: #f5f5f5;
        }

        .login #backtoblog a:hover,
        .login #nav a:hover {
            color: #ff4500;
        }

        .login .button-primary {
            background: #ff4500;
            border-color: #cc3700;
            text-shadow: none;
        }

        .login .button-primary:hover {
            background: #cc3700;
        }
    </style>
    <?php
}

/*--------------------------------------------------------------
# Dashboard Widget: Site Performance & Analytics
--------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'csl_add_performance_widget');
function csl_add_performance_widget() {
    if (!function_exists('wp_add_dashboard_widget')) {
        return;
    }

    wp_add_dashboard_widget(
        'csl_performance_widget',
        '📈 Site Performance & Analytics',
        'csl_performance_widget_content'
    );
}

function csl_performance_widget_content() {
    // Get basic WordPress stats
    $total_posts = wp_count_posts('post')->publish;
    $total_pages = wp_count_posts('page')->publish;
    $total_media = wp_count_posts('attachment')->inherit;

    // Check if Site Kit by Google is active
    $site_kit_active = is_plugin_active('google-site-kit/google-site-kit.php');

    // Get theme and plugin info
    $theme = wp_get_theme();
    $plugins = get_plugins();
    $active_plugins = get_option('active_plugins');

    ?>
    <style>
        .csl-perf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        .csl-perf-box {
            background: #f9f9f9;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .csl-perf-number {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .csl-perf-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }
        .csl-perf-status {
            padding: 8px 12px;
            background: #2ecc71;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            margin: 10px 0;
        }
        .csl-perf-status.warning { background: #f39c12; }
        .csl-perf-status.error { background: #e74c3c; }
        .csl-analytics-section {
            margin: 20px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f5f5f5 0%, #fff 100%);
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .csl-analytics-section h4 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 14px;
            font-weight: 600;
        }
    </style>

    <div class="csl-perf-grid">
        <div class="csl-perf-box">
            <div class="csl-perf-number"><?php echo $total_posts; ?></div>
            <div class="csl-perf-label">Blog Posts</div>
        </div>

        <div class="csl-perf-box">
            <div class="csl-perf-number"><?php echo $total_pages; ?></div>
            <div class="csl-perf-label">Pages</div>
        </div>

        <div class="csl-perf-box">
            <div class="csl-perf-number"><?php echo $total_media; ?></div>
            <div class="csl-perf-label">Media Files</div>
        </div>

        <div class="csl-perf-box">
            <div class="csl-perf-number"><?php echo count($active_plugins); ?></div>
            <div class="csl-perf-label">Active Plugins</div>
        </div>
    </div>

    <div class="csl-analytics-section">
        <h4>🌐 Google Analytics Integration</h4>
        <?php if ($site_kit_active): ?>
            <div class="csl-perf-status">✓ Site Kit by Google is Active</div>
            <p style="margin: 10px 0; font-size: 13px; color: #666;">
                View detailed analytics in <a href="<?php echo admin_url('admin.php?page=googlesitekit-dashboard'); ?>">Site Kit Dashboard</a>
            </p>
        <?php else: ?>
            <div class="csl-perf-status warning">⚠ Site Kit Not Configured</div>
            <p style="margin: 10px 0; font-size: 13px; color: #666;">
                Install Site Kit by Google to track traffic, conversions, and user behavior.
            </p>
            <a href="<?php echo admin_url('plugin-install.php?s=site+kit&tab=search'); ?>" class="button">
                Install Site Kit
            </a>
        <?php endif; ?>
    </div>

    <div class="csl-analytics-section">
        <h4>🚀 Site Health & Performance</h4>
        <?php
        // Get site health status
        $health_check_site_status = get_option('site_health_status', 'unknown');
        $status_class = $health_check_site_status === 'good' ? '' : 'warning';
        $status_text = ucfirst($health_check_site_status);
        ?>
        <div class="csl-perf-status <?php echo $status_class; ?>">
            Site Health: <?php echo $status_text; ?>
        </div>
        <p style="margin: 10px 0; font-size: 13px;">
            <a href="<?php echo admin_url('site-health.php'); ?>">View Full Site Health Report</a>
        </p>
    </div>

    <div class="csl-analytics-section">
        <h4>📊 Key Metrics to Track</h4>
        <ul style="margin: 0; padding-left: 20px; font-size: 13px; line-height: 2;">
            <li><strong>Conversion Rate:</strong> Contact form submissions / total visitors</li>
            <li><strong>Bounce Rate:</strong> Users leaving after viewing only one page</li>
            <li><strong>Avg. Session Duration:</strong> How long users stay on site</li>
            <li><strong>Top Pages:</strong> Most visited pages on your site</li>
            <li><strong>Traffic Sources:</strong> Where your visitors come from</li>
        </ul>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <?php if ($site_kit_active): ?>
            <a href="<?php echo admin_url('admin.php?page=googlesitekit-dashboard'); ?>" class="button button-primary">
                View Analytics Dashboard →
            </a>
        <?php else: ?>
            <a href="https://analytics.google.com" target="_blank" class="button button-primary">
                Open Google Analytics →
            </a>
        <?php endif; ?>
    </div>
    <?php
}
