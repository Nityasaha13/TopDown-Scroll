<?php
/*
    Plugin Name: Top-Down Scroll
    Description: This plugin provides Scroll to Top and Scroll to Down functionality to your website. 
    Version: 1.3.0
    Author: Nitya Saha
    Author URI: https://codesocials.com/nitya-gopal-saha/
    License: GPLv2 or later
    Text Domain: top-down-scroll
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Define plugin version
define('TD_SCROLL_PLUGIN_VERSION', '1.3.0'); 

require_once("dashboard-settings.php");
require_once("setting-page-content.php");
require_once("assets/includes/button-styles.php");

register_activation_hook(__FILE__, 'td_scroll_activate');
function td_scroll_activate() {

    // Create transient data for activation notice
    set_transient('td-scroll-activation-notice', true, 5);

    if (empty(get_option('td_position'))) {
        add_option('td_position', 'left');
    }
    if (empty(get_option('enable_top'))) {
        add_option('enable_top', 'on');
    }
}


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
    $top_icon_url = get_option('top_button_icon_url') ? get_option('top_button_icon_url') : plugins_url('/assets/images/up2.svg', __FILE__);

    ?>

    <button id="td-scroll-to-top" class="td-top-btn td-position-<?php echo esc_attr($position); ?>">
        <img src="<?php echo esc_url($top_icon_url); ?>" alt="top down scroll to top">
    </button>
    
    <?php
}

// Function to display scroll-to-down button
function td_scroll_to_down_button() {

    $position = get_option('td_position', 'left') ?: 'left';
    $down_icon_url = get_option('down_button_icon_url') ? get_option('down_button_icon_url') : plugins_url('/assets/images/down2.svg', __FILE__);

    ?>

    <button id="td-scroll-to-down" class="td-down-btn td-position-<?php echo esc_attr($position); ?>">
        <img src="<?php echo esc_url($down_icon_url); ?>" alt="top down scroll to down">
    </button>

    <?php
}


// UPLOAD ENGINE
function td_scroll_load_wp_media_files() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'td_scroll_load_wp_media_files');


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