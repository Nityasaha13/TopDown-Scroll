<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Register setting and sanitize
function tdsc_scroll_register_settings() {
    register_setting('tdsc_scroll_options', 'tdsc_enable_top', 'tdsc_sanitize_checkbox');
    register_setting('tdsc_scroll_options', 'tdsc_enable_down', 'tdsc_sanitize_checkbox');
    register_setting('tdsc_scroll_options', 'tdsc_position', 'tdsc_sanitize_radio');
    register_setting('tdsc_scroll_options', 'tdsc_top_button_icon_url', 'esc_url_raw');
    register_setting('tdsc_scroll_options', 'tdsc_down_button_icon_url', 'esc_url_raw');
    register_setting('tdsc_scroll_options', 'tdsc_icon_size');
    register_setting('tdsc_scroll_options', 'tdsc_background_color', 'sanitize_hex_color');
    register_setting('tdsc_scroll_options', 'tdsc_hover_color', 'sanitize_hex_color');
}
add_action('admin_init', 'tdsc_scroll_register_settings');


// Sanitize checkbox
function tdsc_sanitize_checkbox($input) {
    return ($input === 'on') ? 'on' : 'off';
}

// Sanitize radio
function tdsc_sanitize_radio($input) {
    $valid = array('left', 'right');
    return in_array($input, $valid) ? $input : 'left'; // Default to 'left' if invalid
}

// Function to handle saving of settings
function tdsc_scroll_save_settings() {
    if ( ! isset( $_POST['save_plugin_settings'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'save_tdsc_scroll_settings' ) ) {
        return;
    }
    

    update_option('tdsc_enable_top', isset($_POST['tdsc_enable_top']) ? 'on' : 'off');
    update_option('tdsc_enable_down', isset($_POST['tdsc_enable_down']) ? 'on' : 'off');
    update_option( 'tdsc_position', tdsc_sanitize_radio( sanitize_text_field( wp_unslash( $_POST['tdsc_position'] ) ) ) );
    update_option('tdsc_icon_size', sanitize_text_field($_POST['tdsc_icon_size']));
    
    if (isset($_POST['tdsc_background_color'])) {
        update_option('tdsc_ackground_color', sanitize_hex_color($_POST['tdsc_background_color']));
    }
    if (isset($_POST['tdsc_hover_color'])) {
        update_option('tdsc_hover_color', sanitize_hex_color($_POST['tdsc_hover_color']));
    }

    if (!empty($_POST['tdsc_top_button_icon_url'])) {
        update_option('tdsc_top_button_icon_url', esc_url_raw($_POST['tdsc_top_button_icon_url']));
    } else {
        delete_option('tdsc_top_button_icon_url');
    }

    if (!empty($_POST['tdsc_down_button_icon_url'])) {
        update_option('tdsc_down_button_icon_url', esc_url_raw($_POST['tdsc_down_button_icon_url']));
    } else {
        delete_option('tdsc_down_button_icon_url');
    }

    // Redirect back to the settings page after saving
    wp_redirect(add_query_arg('page', 'tdsc_scroll_options', admin_url('options-general.php')));
    exit;
}
add_action('admin_post_save_plugin_settings', 'tdsc_scroll_save_settings');

// Hook the scroll-to-top button function to wp_footer action
if (get_option('tdsc_enable_top') === "on") {
    add_action('wp_footer', 'tdsc_scroll_to_top_button');
}

// Hook the scroll-to-down button function to wp_footer action
if (get_option('tdsc_enable_down') === "on") {
    add_action('wp_footer', 'tdsc_scroll_to_down_button');
}



