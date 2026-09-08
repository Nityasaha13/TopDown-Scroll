<?php
/**
 * Front-end button markup.
 *
 * Note: these two functions use TDSC_SCROLL_PLUGIN_URL rather than
 * plugins_url( ..., __FILE__ ) so the default icon paths stay correct now that
 * they live in a subdirectory.
 *
 * @package top-down-scroll
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Render the scroll-to-top button.
 */
function tdsc_scroll_to_top_button() {

    $position = tdsc_sanitize_radio( get_option( 'tdsc_position', 'left' ) );
    $icon_url = get_option( 'tdsc_top_button_icon_url' );
    $icon_url = $icon_url ? $icon_url : TDSC_SCROLL_PLUGIN_URL . 'assets/images/up2.svg';
    ?>
    <button id="td-scroll-to-top" class="td-top-btn td-position-<?php echo esc_attr( $position ); ?>" style="display:none" aria-label="<?php esc_attr_e( 'Scroll to top', 'top-down-scroll' ); ?>">
        <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php esc_attr_e( 'Scroll to top', 'top-down-scroll' ); ?>">
    </button>
    <?php
}

/**
 * Render the scroll-to-bottom button.
 */
function tdsc_scroll_to_down_button() {

    $position = tdsc_sanitize_radio( get_option( 'tdsc_position', 'left' ) );
    $icon_url = get_option( 'tdsc_down_button_icon_url' );
    $icon_url = $icon_url ? $icon_url : TDSC_SCROLL_PLUGIN_URL . 'assets/images/down2.svg';
    ?>
    <button id="td-scroll-to-down" class="td-down-btn td-position-<?php echo esc_attr( $position ); ?>" style="display:none" aria-label="<?php esc_attr_e( 'Scroll to bottom', 'top-down-scroll' ); ?>">
        <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php esc_attr_e( 'Scroll to bottom', 'top-down-scroll' ); ?>">
    </button>
    <?php
}
