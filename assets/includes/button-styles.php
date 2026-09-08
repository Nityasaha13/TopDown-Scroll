<?php
/**
 * Front-end styles built from the saved settings.
 *
 * @package top-down-scroll
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', 'tdsc_dynamic_button_styles' );

/**
 * Print the button styles in the document head.
 */
function tdsc_dynamic_button_styles() {

    $icon_size         = tdsc_get_size_option( 'tdsc_icon_size' );
    $button_padding    = tdsc_get_size_option( 'tdsc_button_padding' );
    $border_radius     = tdsc_get_size_option( 'tdsc_border_radius' );
    $border_width      = tdsc_get_size_option( 'tdsc_border_width' );
    $bottom_spacing    = tdsc_get_size_option( 'tdsc_bottom_spacing' );
    $side_wall_spacing = tdsc_get_size_option( 'tdsc_side_wall_spacing' );

    $bg_color     = tdsc_get_color_option( 'tdsc_background_color' );
    $hover_color  = tdsc_get_color_option( 'tdsc_hover_color' );
    $border_color = tdsc_get_color_option( 'tdsc_border_color' );

    /*
     * When both buttons are shown the top one has to clear the bottom one. The
     * old code hard-coded 62px, which only held for the original fixed geometry
     * (20 spacing + 20 icon + 8 padding either side + 6 gap). Now that the icon,
     * padding, border and spacing are all configurable it has to be measured.
     */
    $gap             = 6;
    $button_height   = $icon_size + ( 2 * $button_padding ) + ( 2 * $border_width );
    $bottom_position = ( 'on' === get_option( 'tdsc_enable_down' ) )
        ? $bottom_spacing + $button_height + $gap
        : $bottom_spacing;
    ?>
    <style id="tdsc-scroll-inline-css">
        .td-top-btn,
        .td-down-btn {
            background-color: <?php echo esc_html( $bg_color ); ?>;
            border-radius: <?php echo (int) $border_radius; ?>px;
            padding: <?php echo (int) $button_padding; ?>px;
            <?php if ( $border_width > 0 ) : ?>
            border: <?php echo (int) $border_width; ?>px solid <?php echo esc_html( $border_color ); ?>;
            <?php else : ?>
            border: none;
            <?php endif; ?>
        }

        .td-top-btn:hover,
        .td-top-btn:focus,
        .td-down-btn:hover,
        .td-down-btn:focus {
            background-color: <?php echo esc_html( $hover_color ); ?> !important;
        }

        .td-down-btn img,
        .td-top-btn img {
            width: <?php echo (int) $icon_size; ?>px;
            height: <?php echo (int) $icon_size; ?>px;
            object-fit: cover;
        }

        .td-top-btn {
            bottom: <?php echo (int) $bottom_position; ?>px;
        }

        .td-down-btn {
            bottom: <?php echo (int) $bottom_spacing; ?>px;
        }

        .td-position-left {
            left: <?php echo (int) $side_wall_spacing; ?>px;
        }

        .td-position-right {
            right: <?php echo (int) $side_wall_spacing; ?>px;
        }
    </style>
    <?php
}
