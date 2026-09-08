<?php
/**
 * Settings registration, sanitizing and the front-end output hooks.
 *
 * @package top-down-scroll
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/* -------------------------------------------------------------------------
 * Settings registration
 * ---------------------------------------------------------------------- */

add_action( 'admin_init', 'tdsc_scroll_register_settings' );

/**
 * Register every option in the tdsc_scroll_options group.
 *
 * The settings screen posts to options.php, so WordPress writes these itself and
 * runs each sanitize callback below.
 */
function tdsc_scroll_register_settings() {

    register_setting( 'tdsc_scroll_options', 'tdsc_enable_top', 'tdsc_sanitize_checkbox' );
    register_setting( 'tdsc_scroll_options', 'tdsc_enable_down', 'tdsc_sanitize_checkbox' );
    register_setting( 'tdsc_scroll_options', 'tdsc_position', 'tdsc_sanitize_radio' );
    register_setting( 'tdsc_scroll_options', 'tdsc_top_button_icon_url', 'esc_url_raw' );
    register_setting( 'tdsc_scroll_options', 'tdsc_down_button_icon_url', 'esc_url_raw' );
    register_setting( 'tdsc_scroll_options', 'tdsc_icon_size', 'tdsc_sanitize_size' );
    register_setting( 'tdsc_scroll_options', 'tdsc_background_color', 'tdsc_sanitize_color' );
    register_setting( 'tdsc_scroll_options', 'tdsc_hover_color', 'tdsc_sanitize_color' );
    register_setting( 'tdsc_scroll_options', 'tdsc_border_radius', 'tdsc_sanitize_size' );
    register_setting( 'tdsc_scroll_options', 'tdsc_border_width', 'tdsc_sanitize_size' );
    register_setting( 'tdsc_scroll_options', 'tdsc_border_color', 'tdsc_sanitize_color' );
    register_setting( 'tdsc_scroll_options', 'tdsc_button_padding', 'tdsc_sanitize_size' );
    register_setting( 'tdsc_scroll_options', 'tdsc_bottom_spacing', 'tdsc_sanitize_size' );
    register_setting( 'tdsc_scroll_options', 'tdsc_side_wall_spacing', 'tdsc_sanitize_size' );
}


/* -------------------------------------------------------------------------
 * Sanitizing
 * ---------------------------------------------------------------------- */

/**
 * Sanitize a checkbox.
 *
 * An unchecked box is not posted at all, so options.php hands this null.
 *
 * @param mixed $input Posted value.
 * @return string 'on' or 'off'.
 */
function tdsc_sanitize_checkbox( $input ) {
    return ( 'on' === $input ) ? 'on' : 'off';
}

/**
 * Sanitize the position radio.
 *
 * @param mixed $input Posted value.
 * @return string 'left' or 'right'.
 */
function tdsc_sanitize_radio( $input ) {
    $valid = array( 'left', 'right' );
    return in_array( $input, $valid, true ) ? $input : 'left';
}

/**
 * Sanitize a pixel value.
 *
 * An empty value is stored as-is so the option's default applies. There is no
 * upper clamp, so existing custom sizes are preserved.
 *
 * @param mixed $input Posted value.
 * @return string
 */
function tdsc_sanitize_size( $input ) {

    $input = trim( (string) $input );

    if ( '' === $input ) {
        return '';
    }

    return (string) absint( $input );
}

/**
 * Sanitize a hex colour.
 *
 * Wraps sanitize_hex_color() so a missing value cannot reach it as null, and so
 * an invalid one is stored as '' rather than null - which lets
 * tdsc_get_color_option() fall back to the default.
 *
 * @param mixed $input Posted value.
 * @return string
 */
function tdsc_sanitize_color( $input ) {

    $color = sanitize_hex_color( trim( (string) $input ) );

    return $color ? $color : '';
}


/* -------------------------------------------------------------------------
 * Front-end output
 * ---------------------------------------------------------------------- */

if ( 'on' === get_option( 'tdsc_enable_top' ) ) {
    add_action( 'wp_footer', 'tdsc_scroll_to_top_button' );
}

if ( 'on' === get_option( 'tdsc_enable_down' ) ) {
    add_action( 'wp_footer', 'tdsc_scroll_to_down_button' );
}
