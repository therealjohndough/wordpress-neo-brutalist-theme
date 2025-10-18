<?php
/**
 * Add offering_icon field to service_offerings ACF repeater
 * Run this via wp-cli: wp eval-file add-icon-field-to-acf.php
 */

// Prevent direct access
if (!defined('ABSPATH') && !defined('WP_CLI')) {
    die('Direct access not allowed');
}

function csl_add_offering_icon_field() {
    // Check if ACF is active
    if (!function_exists('acf_add_local_field')) {
        echo "Error: ACF is not active.\n";
        return false;
    }

    // The parent repeater field key
    $parent_key = 'field_686af3746f2a1'; // service_offerings repeater

    // Add the icon field to the repeater
    acf_add_local_field([
        'key' => 'field_offering_icon_' . time(),
        'label' => 'Offering Icon',
        'name' => 'offering_icon',
        'type' => 'text',
        'parent' => $parent_key,
        'instructions' => 'Enter Phosphor icon class (e.g., ph-chart-line-up, ph-package, ph-rocket-launch). See https://phosphoricons.com/',
        'required' => 0,
        'default_value' => 'ph-sparkle',
        'placeholder' => 'ph-sparkle',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
    ]);

    echo "✓ Added offering_icon field to ACF\n";
    echo "Now re-running the offerings update to populate icons...\n\n";

    // Re-run the update script to add icons
    if (function_exists('csl_update_service_page_offerings')) {
        csl_update_service_page_offerings();
    } else {
        // Include the update script
        require_once __DIR__ . '/update-service-offerings.php';
        csl_update_service_page_offerings();
    }

    return true;
}

// If running via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::line('Adding offering_icon field to ACF...');
    $result = csl_add_offering_icon_field();

    if ($result) {
        WP_CLI::success('Icon field added and all offerings updated!');
    } else {
        WP_CLI::error('Failed to add icon field.');
    }
}
