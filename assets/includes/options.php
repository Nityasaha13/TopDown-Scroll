<?php
/**
 * Option defaults and typed getters.
 *
 * Every setting is read through the helpers below so the front-end styles and
 * the settings screen can never disagree about what a default is.
 *
 * @package top-down-scroll
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Default value for each option.
 *
 * These double as the fallback for sites upgrading from an older version, where
 * the option row does not exist yet. `tdsc_border_radius` defaults to 3 to match
 * the radius those installs were already rendering, and `tdsc_border_width`
 * defaults to 0 so upgrading adds no border that was not there before.
 *
 * @return array<string,int|string>
 */
function tdsc_get_option_defaults() {
    return array(
        'tdsc_icon_size'         => 20,
        'tdsc_button_padding'    => 8,
        'tdsc_border_radius'     => 3,
        'tdsc_border_width'      => 0,
        'tdsc_bottom_spacing'    => 20,
        'tdsc_side_wall_spacing' => 20,
        'tdsc_background_color'  => '#046bd2',
        'tdsc_hover_color'       => '#046bd2',
        'tdsc_border_color'      => '#b8b5b5',
    );
}

/**
 * Read a single default.
 *
 * @param string $name Option name.
 * @return int|string
 */
function tdsc_get_option_default( $name ) {
    $defaults = tdsc_get_option_defaults();
    return isset( $defaults[ $name ] ) ? $defaults[ $name ] : '';
}

/**
 * Read a pixel setting as an integer.
 *
 * A missing option, or a field the user cleared, falls back to the default. A
 * saved 0 is a deliberate choice and is returned as 0 - which is why this cannot
 * use the `get_option( ... ) ?: $default` shortcut, since '0' is falsy in PHP.
 *
 * @param string $name Option name.
 * @return int
 */
function tdsc_get_size_option( $name ) {
    $value = get_option( $name, '' );

    if ( '' === $value || null === $value || false === $value ) {
        return (int) tdsc_get_option_default( $name );
    }

    return absint( $value );
}

/**
 * Read a colour setting, falling back to the default when it is missing or invalid.
 *
 * @param string $name Option name.
 * @return string Hex colour.
 */
function tdsc_get_color_option( $name ) {
    $value = sanitize_hex_color( trim( (string) get_option( $name, '' ) ) );

    return $value ? $value : (string) tdsc_get_option_default( $name );
}
