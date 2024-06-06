<?php

if ( ! defined( 'ABSPATH' ) ) exit;


add_action("wp_head","tdsc_dynamic_button_styles");
function tdsc_dynamic_button_styles(){
    $icon_size = get_option('tdsc_icon_size', '20') ?: '20';
    $bg_color = get_option('tdsc_background_color','#046bd2') ?: '#046bd2';
    $hover_color = get_option('tdsc_hover_color', '#046bd2') ?: '#046bd2';
    $bottom_position = get_option('tdsc_enable_down') === 'on' ? '62px' : '20px';
?>
    <style>
        .td-top-btn:hover,
        .td-top-btn:focus {
            background-color: <?php echo esc_attr($hover_color); ?> !important;
        }

        .td-down-btn,
        .td-top-btn {
            background-color: <?php echo esc_attr($bg_color) ?>;
        }

        .td-top-btn {
            bottom: <?php echo esc_attr($bottom_position); ?>;
        }

        .td-down-btn:hover,
        .td-down-btn:focus {
            background-color: <?php echo esc_attr($hover_color); ?> !important;
        }

        .td-down-btn img,
        .td-top-btn img{
            width:<?php echo esc_attr($icon_size);?>px;
            height:<?php echo esc_attr($icon_size);?>px;
            object-fit: cover;
        }

    </style>
<?php
}