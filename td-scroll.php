<?php
/*
Plugin Name: Top-Down Scroll
Plugin URI:        https://codesocials.com/top-down-scroll/
Description: This plugin provides Scroll to Top and Scroll to Down functionality to your website. 
Version: 1.2
Author: Nitya Saha
Author URI:        https://codesocials.com/nitya-gopal-saha/
*/

if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}
if ( ! function_exists( 'media_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
}
if ( ! function_exists( 'wp_get_attachment_url' ) ) {
    require_once( ABSPATH . 'wp-includes/post.php' );
}


require_once("dashboard-settings.php");
require_once("setting-page-content.php");

register_activation_hook(__FILE__, 'td_scroll_activate');
function td_scroll_activate() {
    // Create transient data for activation notice
    set_transient('td-scroll-activation-notice', true, 5);
}

register_deactivation_hook(__FILE__, 'td_scroll_deactivate');
function td_scroll_deactivate()
{
    
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


$plugin_url = plugins_url();
wp_localize_script('top-down-script', 'pluginData', array(
    'pluginUrl' => esc_url( plugins_url('/', __FILE__) )
));


// Enqueue style and scripts in plugin admin pages
add_action('admin_enqueue_scripts', 'td_scroll_admin_enqueue_scripts');
function td_scroll_admin_enqueue_scripts()
{
    wp_enqueue_style('top-down-admin-css', esc_url( plugins_url('/assets/css/td-dashboard.css', __FILE__) ));
    // wp_enqueue_script('top-down-admin-js', esc_url( plugins_url('/assets/js/td-script.js', __FILE__) ), array('jquery'), null, true);
}


// Enqueue scripts and styles in frontend
add_action('wp_enqueue_scripts', 'td_scroll_enqueue_scripts');
function td_scroll_enqueue_scripts()
{
    wp_enqueue_style('top-down-css', plugins_url('/assets/css/top-down.css', __FILE__));
    wp_enqueue_script('top-down-js', plugins_url('/assets/js/top-down.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('scroll-buttons', plugins_url('/assets/js/button-behaviour.js', __FILE__), array('jquery'), null, true);

    wp_enqueue_media();
    wp_enqueue_script('td-media-uploader', plugins_url('/assets/js/media-uploader.js', __FILE__), array('jquery'), null, true);
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


function td_scroll_to_top_button() {
    $position = get_option('td_position', 'left'); // Default to 'left' if not set
    $bottom_position = get_option('enable_down') === 'on' ? '75px' : '20px';
    $top_icon_url = get_option('top_button_icon_url') ? get_option('top_button_icon_url') : plugins_url('/assets/images/up2.svg', __FILE__);
    ?>

    <button id="td-scroll-to-top" class="td-top-btn td-position-<?php echo esc_attr($position); ?>" style="bottom: <?php echo esc_attr($bottom_position); ?>;">
        <img src="<?php echo esc_url($top_icon_url); ?>" alt="top">
    </button>

    <?php
}

function td_scroll_to_down_button() {
    $position = get_option('td_position', 'left'); // Default to 'left' if not set
    $down_icon_url = get_option('down_button_icon_url') ? get_option('down_button_icon_url') : plugins_url('/assets/images/down2.svg', __FILE__);
    ?>

    <button id="td-scroll-to-down" class="td-down-btn td-position-<?php echo esc_attr($position); ?>">
        <img src="<?php echo esc_url($down_icon_url); ?>" alt="down">
    </button>

    <?php
}


