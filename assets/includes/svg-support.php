<?php
/**
 * SVG upload support for the button icons.
 *
 * @package top-down-scroll
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Capability required to upload an SVG.
 *
 * SVG files can carry scripts, so this is limited to administrators - the same
 * people who can reach this plugin's settings screen. Sites that need to widen
 * it again can filter the capability.
 *
 * @return string
 */
function tdsc_svg_upload_capability() {
    return (string) apply_filters( 'tdsc_svg_upload_capability', 'manage_options' );
}

/**
 * Whether this plugin should be the one allowing SVG uploads.
 *
 * Returns false when SVG is already permitted - by WordPress itself, a theme, or
 * a dedicated plugin such as Safe SVG - so an existing setup keeps its own
 * handling instead of being silently overwritten here.
 *
 * @param array<string,string> $mimes Allowed mime types keyed by extension pattern.
 * @return bool
 */
function tdsc_should_allow_svg( $mimes ) {

    foreach ( array_keys( (array) $mimes ) as $pattern ) {
        // Extensions are stored as regex alternations, e.g. 'jpg|jpeg|jpe'.
        foreach ( explode( '|', (string) $pattern ) as $ext ) {
            if ( 'svg' === $ext || 'svgz' === $ext ) {
                return false;
            }
        }
    }

    // get_allowed_mime_types() can run before the pluggable user functions are
    // available; deny rather than fatal in that case.
    if ( ! function_exists( 'wp_get_current_user' ) ) {
        return false;
    }

    return current_user_can( tdsc_svg_upload_capability() );
}

/**
 * Allow SVG in the media library when nothing else already does.
 *
 * @param array<string,string> $mimes Allowed mime types.
 * @return array<string,string>
 */
function tdsc_cc_mime_types( $mimes ) {

    if ( tdsc_should_allow_svg( $mimes ) ) {
        $mimes['svg'] = 'image/svg+xml';
    }

    return $mimes;
}
add_filter( 'upload_mimes', 'tdsc_cc_mime_types' );

/**
 * Let a genuine SVG through WordPress' real-content-type check.
 *
 * Adding the mime type on its own is not enough. wp_check_filetype_and_ext()
 * runs the uploaded file through fileinfo, and libmagic reports SVG as
 * text/plain, text/xml or text/html on plenty of hosts. Core then treats the
 * mismatch as dangerous and blanks out $ext and $type, so the upload is
 * rejected. This restores the extension only when the file really is an SVG.
 *
 * The previous version of this filter only ran on WordPress 4.7.1, so on every
 * supported version (6.0+) it did nothing at all.
 *
 * @param array<string,mixed> $data      Values for the extension, mime type and corrected filename.
 * @param string              $file      Full path to the file.
 * @param string              $filename  The name of the file.
 * @param array|null          $mimes     Allowed mime types.
 * @return array<string,mixed>
 */
function tdsc_check_svg_filetype_and_ext( $data, $file, $filename, $mimes ) {

    // Only ever touch .svg uploads; every other file keeps core's verdict.
    if ( ! preg_match( '/\.svg$/i', (string) $filename ) ) {
        return $data;
    }

    // Core already accepted it, or SVG is not allowed for this user at all.
    if ( ! empty( $data['type'] ) ) {
        return $data;
    }

    $allowed = is_array( $mimes ) ? $mimes : get_allowed_mime_types();

    if ( ! in_array( 'image/svg+xml', (array) $allowed, true ) ) {
        return $data;
    }

    if ( ! tdsc_is_svg_file( $file ) ) {
        return $data;
    }

    $data['ext']  = 'svg';
    $data['type'] = 'image/svg+xml';

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'tdsc_check_svg_filetype_and_ext', 10, 4 );

/**
 * Confirm a file is really SVG markup before trusting its extension.
 *
 * @param string $file Full path to the uploaded file.
 * @return bool
 */
function tdsc_is_svg_file( $file ) {

    if ( ! is_readable( $file ) ) {
        return false;
    }

    $handle = fopen( $file, 'rb' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen

    if ( ! $handle ) {
        return false;
    }

    // An <svg> root element has to appear early, after at most an XML
    // declaration, a doctype and a comment or two.
    $head = fread( $handle, 4096 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fread
    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

    return is_string( $head ) && (bool) preg_match( '/<svg[\s>]/i', $head );
}
