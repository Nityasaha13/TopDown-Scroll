<?php
/*
Plugin Name: Top-Down Scroll
Plugin URI: https://codesocials.com/top-down-scroll/
Description: This plugin provides Scroll to Top and Scroll to Down functionality to your website. 
Version: 1.27
Author: Nitya Saha
Author URI: https://codesocials.com/nitya-gopal-saha/
*/

// Define plugin version
define('TD_SCROLL_PLUGIN_VERSION', '1.27');

require_once("dashboard-settings.php");
require_once("setting-page-content.php");

register_activation_hook(__FILE__, 'td_scroll_activate');
function td_scroll_activate() {
    global $wpdb;

    // Create transient data for activation notice
    set_transient('td-scroll-activation-notice', true, 5);

    // SQL query to set the options in the wp_options table
    $wpdb->query("
        INSERT INTO {$wpdb->options} (option_name, option_value, autoload)
        VALUES 
        ('enable_top', 'on', 'yes'),
        ('td_position', 'left', 'yes')
        ON DUPLICATE KEY UPDATE
        option_value = VALUES(option_value)
    ");
}

// Register settings
register_setting('td_scroll_options', 'enable_top', 'sanitize_checkbox');
register_setting('td_scroll_options', 'td_position', 'sanitize_radio');

register_deactivation_hook(__FILE__, 'td_scroll_deactivate');
function td_scroll_deactivate() {

}

register_uninstall_hook(__FILE__,'td_scroll_uninstall');
function td_scroll_uninstall(){
    delete_option('enable_top');
    delete_option('enable_down');
    delete_option('td_position');
    delete_option('top_button_icon_url');
    delete_option('down_button_icon_url');
    delete_option('td_icon_size');
    delete_option('td_background_color');
    delete_option('td_hover_color');
}

// Add admin notice
add_action('admin_notices', 'td_scroll_activate_admin_notice');

/**
 * Admin Notice on Activation.
 */
function td_scroll_activate_admin_notice() {
    // Check transient, if available display notice
    if (get_transient('td-scroll-activation-notice')) {
        ?>
        <div class="updated notice is-dismissible">
            <p><?php esc_html_e('Add scroll buttons from settings. Goto Appearance>Top-Down Scroll.', 'plugin-text-domain'); ?></p>
        </div>
        <?php
        // Delete transient, only display this notice once
        delete_transient('td-scroll-activation-notice');
    }
}

// Enqueue style and scripts in plugin admin pages
add_action('admin_enqueue_scripts', 'td_scroll_admin_enqueue_scripts');
function td_scroll_admin_enqueue_scripts($hook) {
    if ($hook != 'appearance_page_top-down-scroll-page') {
        return;
    }
    wp_enqueue_style('top-down-admin-css', plugins_url('/assets/css/td-dashboard.css', __FILE__), array(), TD_SCROLL_PLUGIN_VERSION);
    wp_enqueue_script('td-media-uploader-js', plugins_url('/assets/js/media-uploader.js', __FILE__), array('jquery'), TD_SCROLL_PLUGIN_VERSION, true);
    wp_enqueue_script('td-color-picker-js', plugins_url('/assets/js/color-input.js', __FILE__), array('jquery'), TD_SCROLL_PLUGIN_VERSION, true);
}

// Enqueue scripts and styles in frontend
add_action('wp_enqueue_scripts', 'td_scroll_enqueue_scripts');
function td_scroll_enqueue_scripts() {
    wp_enqueue_style('top-down-css', plugins_url('/assets/css/top-down.css', __FILE__), array(), TD_SCROLL_PLUGIN_VERSION);
    wp_enqueue_script('top-down-js', plugins_url('/assets/js/top-down.js', __FILE__), array('jquery'), TD_SCROLL_PLUGIN_VERSION, true);
    wp_enqueue_script('scroll-buttons', plugins_url('/assets/js/button-behaviour.js', __FILE__), array('jquery'), TD_SCROLL_PLUGIN_VERSION, true);
    wp_enqueue_media();
}

// Function to add a custom page under the "Appearance" menu
function td_scroll_theme_page() {
    // Add a new submenu under "Appearance" menu
    add_theme_page(
        'Top-Down Scroll',
        'Top-Down Scroll',
        'manage_options',
        'top-down-scroll-page', 
        'top_down_scroll_page_content' 
    );
}
add_action('admin_menu', 'td_scroll_theme_page');


// Function to display scroll-to-top button
function td_scroll_to_top_button() {

    $position = get_option('td_position', 'left') ?: 'left';
    $icon_size = get_option('td_icon_size', '20') ?: '20';
    $bg_color = get_option('td_background_color','#046bd2') ?: '#046bd2';
    $hover_color = get_option('td_hover_color', '#046bd2') ?: '#046bd2';
    $bottom_position = get_option('enable_down') === 'on' ? '66px' : '20px';
    $top_icon_url = get_option('top_button_icon_url') ? get_option('top_button_icon_url') : plugins_url('/assets/images/up2.svg', __FILE__);

    ?>

    <style>
        .td-top-btn:hover,
        .td-top-btn:focus {
            background-color: <?php echo esc_attr($hover_color); ?> !important;
        }

        .td-down-btn, .td-top-btn{
            background-color:<?php echo esc_attr($bg_color) ?>;
        }

        .td-top-btn{
            bottom: <?php echo esc_attr($bottom_position); ?>;
        }
    </style>

    <button id="td-scroll-to-top" class="td-top-btn td-position-<?php echo esc_attr($position); ?>">
        <img src="<?php echo esc_url($top_icon_url); ?>" alt="top down scroll to top" style="width:<?php echo esc_attr($icon_size);?>px;">
    </button>
    
    <?php
}

// Function to display scroll-to-down button
function td_scroll_to_down_button() {

    $position = get_option('td_position', 'left') ?: 'left';
    $icon_size = get_option('td_icon_size', '20') ?: '20';
    $bg_color = get_option('td_background_color','#046bd2') ?: '#046bd2';
    $hover_color = get_option('td_hover_color', '#046bd2') ?: '#046bd2';
    $down_icon_url = get_option('down_button_icon_url') ? get_option('down_button_icon_url') : plugins_url('/assets/images/down2.svg', __FILE__);

    ?>

    <style>
        .td-down-btn:hover,
        .td-down-btn:focus {
            background-color: <?php echo esc_attr($hover_color); ?> !important;
        }

        .td-down-btn, .td-top-btn{
            background-color:<?php echo esc_attr($bg_color) ?>;
        }
    </style>

    <button id="td-scroll-to-down" class="td-down-btn td-position-<?php echo esc_attr($position); ?>">
        <img src="<?php echo esc_url($down_icon_url); ?>" alt="top down scroll to down" style="width:<?php echo esc_attr($icon_size);?>px;">
    </button>

    <?php
}


// UPLOAD ENGINE
function load_wp_media_files() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_wp_media_files');


add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
    $filetype = wp_check_filetype( $filename, $mimes );
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
  }, 10, 4 );
  function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  function fix_svg() {
    echo '';
  }
  add_action( 'admin_head', 'fix_svg' );