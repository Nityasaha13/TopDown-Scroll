<?php

// Register setting and sanitize
function td_scroll_register_settings() {
    register_setting('td_scroll_options', 'enable_top', 'sanitize_checkbox');
    register_setting('td_scroll_options', 'enable_down', 'sanitize_checkbox');
    register_setting('td_scroll_options', 'td_position', 'sanitize_radio');
}
add_action('admin_init', 'td_scroll_register_settings');

// Sanitize checkbox
function sanitize_checkbox($input) {
    return ($input === 'on') ? 'on' : 'off';
}

// Sanitize radio
function sanitize_radio($input) {
    $valid = array('left', 'right');
    return in_array($input, $valid) ? $input : 'left'; // Default to 'left' if invalid
}


// Function to handle saving of settings
function td_scroll_save_settings() {
    if (!isset($_POST['save_plugin_settings']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_td_scroll_settings')) {
        return;
    }

    update_option('enable_top', isset($_POST['enable_top']) ? 'on' : 'off');
    update_option('enable_down', isset($_POST['enable_down']) ? 'on' : 'off');
    update_option('td_position', sanitize_radio($_POST['td_position']));

    if (!empty($_POST['top_button_icon_url'])) {
        update_option('top_button_icon_url', esc_url_raw($_POST['top_button_icon_url']));
    }

    if (!empty($_POST['down_button_icon_url'])) {
        update_option('down_button_icon_url', esc_url_raw($_POST['down_button_icon_url']));
    }

    // Redirect back to the settings page after saving
    wp_redirect(add_query_arg('page', 'my-custom-theme-page', admin_url('themes.php')));
    exit;
}
add_action('admin_post_save_plugin_settings', 'td_scroll_save_settings');



// Hook the scroll-to-top button function to wp_footer action
if (get_option('enable_top') === "on") {
    add_action('wp_footer', 'td_scroll_to_top_button');
}

// Hook the scroll-to-down button function to wp_footer action
if (get_option('enable_down') === "on") {
    add_action('wp_footer', 'td_scroll_to_down_button');
}
