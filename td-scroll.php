<?php
/*
    Plugin Name: Top-Down Scroll – Customizable Scroll to Top Button
    Description: Add a scroll to top button and an optional scroll to bottom button to any WordPress theme. Custom icon, color, size and position.
    Version: 1.3.7
    Author: Nitya Saha
    Author URI: https://nitya.codesocials.com/
    License: GPLv2 or later
    Text Domain: top-down-scroll
*/

if ( ! defined( 'ABSPATH' ) ) exit;


/* -------------------------------------------------------------------------
 * Constants
 * ---------------------------------------------------------------------- */

define( 'TDSC_SCROLL_PLUGIN_VERSION', '1.3.7' );
define( 'TDSC_SCROLL_PLUGIN_FILE', __FILE__ );
define( 'TDSC_SCROLL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TDSC_SCROLL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/* -------------------------------------------------------------------------
 * Includes
 *
 * options.php first: it defines the defaults and getters the others read.
 * ---------------------------------------------------------------------- */

require_once TDSC_SCROLL_PLUGIN_DIR . 'assets/includes/options.php';
require_once TDSC_SCROLL_PLUGIN_DIR . 'dashboard-settings.php';
require_once TDSC_SCROLL_PLUGIN_DIR . 'setting-page-content.php';
require_once TDSC_SCROLL_PLUGIN_DIR . 'assets/includes/button-styles.php';
require_once TDSC_SCROLL_PLUGIN_DIR . 'assets/includes/scroll-buttons.php';
require_once TDSC_SCROLL_PLUGIN_DIR . 'assets/includes/svg-support.php';


/* -------------------------------------------------------------------------
 * Activation / deactivation / uninstall
 * ---------------------------------------------------------------------- */

register_activation_hook( __FILE__, 'tdsc_scroll_activate' );

/**
 * Seed the two options the plugin needs a stored value for.
 *
 * Everything else falls back to tdsc_get_option_defaults(), so an upgrade never
 * writes rows over settings a site already has.
 */
function tdsc_scroll_activate() {

    // Transient drives the one-time activation notice below.
    set_transient( 'tdsc-scroll-activation-notice', true, 5 );

    if ( empty( get_option( 'tdsc_position' ) ) ) {
        add_option( 'tdsc_position', 'left' );
    }
    if ( empty( get_option( 'tdsc_enable_top' ) ) ) {
        add_option( 'tdsc_enable_top', 'on' );
    }
}

register_deactivation_hook( __FILE__, 'tdsc_scroll_deactivate' );

/**
 * Nothing to tear down on deactivation; settings survive until uninstall.
 */
function tdsc_scroll_deactivate() {
}

register_uninstall_hook( __FILE__, 'tdsc_scroll_uninstall' );

/**
 * Remove every option the plugin creates.
 */
function tdsc_scroll_uninstall() {

    $options = array_merge(
        array_keys( tdsc_get_option_defaults() ),
        array(
            'tdsc_enable_top',
            'tdsc_enable_down',
            'tdsc_position',
            'tdsc_top_button_icon_url',
            'tdsc_down_button_icon_url',
        )
    );

    foreach ( $options as $option ) {
        delete_option( $option );
    }
}


/* -------------------------------------------------------------------------
 * Admin notice
 * ---------------------------------------------------------------------- */

add_action( 'admin_notices', 'tdsc_scroll_activate_admin_notice' );

/**
 * Point the user at the settings screen right after activation.
 */
function tdsc_scroll_activate_admin_notice() {

    if ( ! get_transient( 'tdsc-scroll-activation-notice' ) ) {
        return;
    }
    ?>
    <div class="updated notice is-dismissible">
        <p><?php esc_html_e( 'Add scroll buttons from settings. Goto Appearance>Top-Down Scroll.', 'top-down-scroll' ); ?></p>
    </div>
    <?php
    // Only display this notice once.
    delete_transient( 'tdsc-scroll-activation-notice' );
}


/* -------------------------------------------------------------------------
 * Assets
 * ---------------------------------------------------------------------- */

add_action( 'admin_enqueue_scripts', 'tdsc_scroll_admin_enqueue_scripts' );

/**
 * Admin styles and scripts, limited to this plugin's own screen.
 *
 * wp_enqueue_media() belongs here too. It used to run from a separate hook with
 * no page check, which loaded the whole media library on every admin screen.
 *
 * @param string $hook Current admin page.
 */
function tdsc_scroll_admin_enqueue_scripts( $hook ) {

    if ( 'appearance_page_top-down-scroll-page' !== $hook ) {
        return;
    }

    wp_enqueue_style( 'top-down-admin-css', TDSC_SCROLL_PLUGIN_URL . 'assets/css/td-dashboard.css', array(), TDSC_SCROLL_PLUGIN_VERSION );
    wp_enqueue_script( 'td-media-uploader-js', TDSC_SCROLL_PLUGIN_URL . 'assets/js/media-uploader.js', array( 'jquery' ), TDSC_SCROLL_PLUGIN_VERSION, true );
    wp_enqueue_script( 'td-color-picker-js', TDSC_SCROLL_PLUGIN_URL . 'assets/js/color-input.js', array( 'jquery' ), TDSC_SCROLL_PLUGIN_VERSION, true );

    wp_enqueue_media();
}

add_action( 'wp_enqueue_scripts', 'tdsc_scroll_enqueue_scripts' );

/**
 * Front-end styles and scripts.
 *
 * Deliberately no wp_enqueue_media() here: visitors cannot upload anything, and
 * it was pulling the entire Backbone media stack onto every page of the site.
 */
function tdsc_scroll_enqueue_scripts() {

    wp_enqueue_style( 'top-down-css', TDSC_SCROLL_PLUGIN_URL . 'assets/css/top-down.css', array(), TDSC_SCROLL_PLUGIN_VERSION );
    wp_enqueue_script( 'top-down-js', TDSC_SCROLL_PLUGIN_URL . 'assets/js/top-down.js', array( 'jquery' ), TDSC_SCROLL_PLUGIN_VERSION, true );
    wp_enqueue_script( 'scroll-buttons', TDSC_SCROLL_PLUGIN_URL . 'assets/js/button-behaviour.js', array( 'jquery' ), TDSC_SCROLL_PLUGIN_VERSION, true );
}


/* -------------------------------------------------------------------------
 * Admin menu
 * ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'tdsc_scroll_theme_page' );

/**
 * Add the settings screen under Appearance.
 */
function tdsc_scroll_theme_page() {

    add_theme_page(
        'Top-Down Scroll',
        'Top-Down Scroll',
        'manage_options',
        'top-down-scroll-page',
        'tdsc_top_down_scroll_page_content'
    );
}


/* -------------------------------------------------------------------------
 * Plugins screen links
 * ---------------------------------------------------------------------- */

if ( ! class_exists( 'TDSC_Main' ) ) {

    /**
     * Adds the Settings and support links to the plugins list table.
     */
    class TDSC_Main {

        private $plugin_basename;

        public function __construct() {
            $this->plugin_basename = plugin_basename( TDSC_SCROLL_PLUGIN_FILE );
            add_action( 'plugins_loaded', array( $this, 'init' ) );
        }

        public function init() {
            add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'insert_view_logs_link' ) );
            add_filter( 'plugin_row_meta', array( $this, 'addon_plugin_links' ), 10, 2 );
        }

        public function insert_view_logs_link( $links ) {
            $settings_link = '<a href="' . esc_url( admin_url( 'themes.php?page=top-down-scroll-page' ) ) . '">' . esc_html__( 'Settings', 'top-down-scroll' ) . '</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }

        public function addon_plugin_links( $links, $file ) {
            if ( $file === $this->plugin_basename ) {
                $links[] = __( '<a href="https://buymeacoffee.com/nityasaha" style="font-weight:bold;color:#00d300;font-size:15px;">Donate</a>', 'top-down-scroll' );
                $links[] = __( 'Made with Love ❤️', 'top-down-scroll' );
            }

            return $links;
        }
    }
}

// Instantiate the main plugin class.
new TDSC_Main();
