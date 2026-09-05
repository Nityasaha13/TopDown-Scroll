<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Render the plugin settings screen.
 *
 * The form keeps posting to options.php through the Settings API, and every
 * field keeps its original name/id so saved options and the existing scripts
 * (media-uploader.js, color-input.js) keep working exactly as before.
 */
function tdsc_top_down_scroll_page_content() {

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $position    = get_option( 'tdsc_position', 'left' ) ?: 'left';
    $top_icon    = get_option( 'tdsc_top_button_icon_url' );
    $down_icon   = get_option( 'tdsc_down_button_icon_url' );
    $icon_size   = get_option( 'tdsc_icon_size' );
    $bg_color    = get_option( 'tdsc_background_color', '#046bd2' ) ?: '#046bd2';
    $hover_color = get_option( 'tdsc_hover_color', '#046bd2' ) ?: '#046bd2';
    $border_radius = get_option( 'tdsc_border_radius', '0' ) ?: '0';
    $button_padding = get_option( 'tdsc_button_padding', '8' ) ?: '8';
    $bottom_spacing = get_option( 'tdsc_bottom_spacing', '20' );
    $side_wall_spacing = get_option( 'tdsc_side_wall_spacing', '20' );
    if ( '' === $bottom_spacing ) {
        $bottom_spacing = '20';
    }
    if ( '' === $side_wall_spacing ) {
        $side_wall_spacing = '20';
    }

    // options.php redirects back with settings-updated=true, but only the core
    // options-*.php screens turn that into a notice, so add it here.
    if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        add_settings_error( 'tdsc_messages', 'tdsc_settings_updated', __( 'Settings saved.', 'top-down-scroll' ), 'updated' );
    }
    ?>
    <div class="wrap tdsc-wrap">

        <h1 class="screen-reader-text"><?php esc_html_e( 'Top-Down Scroll Settings', 'top-down-scroll' ); ?></h1>

        <?php settings_errors( 'tdsc_messages' ); ?>

        <div class="tdsc-header">
            <div class="tdsc-header__brand">
                <span class="tdsc-header__mark">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 3.4 5.8 9.6l1.4 1.4L12 6.2l4.8 4.8 1.4-1.4L12 3.4Z"/><path d="M12 20.6l6.2-6.2-1.4-1.4L12 17.8l-4.8-4.8-1.4 1.4L12 20.6Z"/></svg>
                </span>
                <div class="tdsc-header__text">
                    <h2 class="tdsc-header__title"><?php esc_html_e( 'Top-Down Scroll', 'top-down-scroll' ); ?></h2>
                    <p class="tdsc-header__subtitle"><?php esc_html_e( 'The ultimate solution for your site navigation. The control is in your hand!', 'top-down-scroll' ); ?></p>
                </div>
            </div>
            <span class="tdsc-badge"><?php echo esc_html( 'v' . TDSC_SCROLL_PLUGIN_VERSION ); ?></span>
        </div>

        <form method="post" action="options.php" class="tdsc-form">
            <?php
            settings_fields( 'tdsc_scroll_options' );
            do_settings_sections( 'tdsc_scroll_options' );
            ?>

            <div class="tdsc-card">
                <div class="tdsc-card__head">
                    <h3 class="tdsc-card__title"><?php esc_html_e( 'Buttons', 'top-down-scroll' ); ?></h3>
                </div>
                <div class="tdsc-card__body">

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="enable-top-btn"><?php esc_html_e( 'Scroll to top', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Shows a button that takes visitors back to the top of the page.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-toggle">
                                <input type="checkbox" name="tdsc_enable_top" id="enable-top-btn" value="on" <?php checked( get_option( 'tdsc_enable_top' ), 'on' ); ?>>
                                <span class="tdsc-toggle__track" aria-hidden="true"><span class="tdsc-toggle__thumb"></span></span>
                            </span>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="enable-down-btn"><?php esc_html_e( 'Scroll to bottom', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Shows a button that jumps visitors to the bottom of the page.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-toggle">
                                <input type="checkbox" name="tdsc_enable_down" id="enable-down-btn" value="on" <?php checked( get_option( 'tdsc_enable_down' ), 'on' ); ?>>
                                <span class="tdsc-toggle__track" aria-hidden="true"><span class="tdsc-toggle__thumb"></span></span>
                            </span>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <span class="tdsc-field__title"><?php esc_html_e( 'Position', 'top-down-scroll' ); ?></span>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Which side of the screen the buttons stick to.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <div class="tdsc-segmented">
                                <input type="radio" name="tdsc_position" id="td-position-left" value="left" <?php checked( $position, 'left' ); ?>>
                                <label for="td-position-left"><?php esc_html_e( 'Left', 'top-down-scroll' ); ?></label>
                                <input type="radio" name="tdsc_position" id="td-position-right" value="right" <?php checked( $position, 'right' ); ?>>
                                <label for="td-position-right"><?php esc_html_e( 'Right', 'top-down-scroll' ); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="set-border-radius"><?php esc_html_e( 'Border Radius', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Default is 0px.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-number">
                                <input type="number" name="tdsc_border_radius" id="set-border-radius" class="tdsc-input" min="0" step="1" placeholder="20" value="<?php echo esc_attr( $border_radius ); ?>">
                                <span class="tdsc-suffix"><?php esc_html_e( 'px', 'top-down-scroll' ); ?></span>
                            </span>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="set-button-padding"><?php esc_html_e( 'Button Padding', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Default is 8px.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-number">
                                <input type="number" name="tdsc_button_padding" id="set-button-padding" class="tdsc-input" min="0" step="1" placeholder="8" value="<?php echo esc_attr( $button_padding ); ?>">
                                <span class="tdsc-suffix"><?php esc_html_e( 'px', 'top-down-scroll' ); ?></span>
                            </span>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="set-bottom-spacing"><?php esc_html_e( 'Bottom Spacing', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Default is 20px.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-number">
                                <input type="number" name="tdsc_bottom_spacing" id="set-bottom-spacing" class="tdsc-input" min="0" step="1" placeholder="20" value="<?php echo esc_attr( $bottom_spacing ); ?>">
                                <span class="tdsc-suffix"><?php esc_html_e( 'px', 'top-down-scroll' ); ?></span>
                            </span>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="set-side-wall-spacing"><?php esc_html_e( 'Side Wall Spacing', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Default is 20px.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-number">
                                <input type="number" name="tdsc_side_wall_spacing" id="set-side-wall-spacing" class="tdsc-input" min="0" step="1" placeholder="20" value="<?php echo esc_attr( $side_wall_spacing ); ?>">
                                <span class="tdsc-suffix"><?php esc_html_e( 'px', 'top-down-scroll' ); ?></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tdsc-card">
                <div class="tdsc-card__head">
                    <h3 class="tdsc-card__title"><?php esc_html_e( 'Icons', 'top-down-scroll' ); ?></h3>
                </div>
                <div class="tdsc-card__body">

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <span class="tdsc-field__title"><?php esc_html_e( 'Scroll-to-top icon', 'top-down-scroll' ); ?></span>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Leave empty to use the built-in arrow.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <div class="tdsc-media">
                                <div id="top_button_icon_preview" class="tdsc-media__preview" data-placeholder="<?php esc_attr_e( 'Default', 'top-down-scroll' ); ?>"><?php if ( $top_icon ) { echo '<img src="' . esc_url( $top_icon ) . '" alt="">'; } ?></div>
                                <div class="tdsc-media__actions">
                                    <input type="hidden" name="tdsc_top_button_icon_url" id="top_button_icon_url" value="<?php echo esc_attr( $top_icon ); ?>">
                                    <button type="button" class="button rudr-upload" id="upload_top_button_icon"><?php esc_html_e( 'Select icon', 'top-down-scroll' ); ?></button>
                                    <a href="#" class="rudr-remove tdsc-remove" id="remove_top_button_icon" <?php echo $top_icon ? '' : 'style="display:none"'; ?>><?php esc_html_e( 'Remove icon', 'top-down-scroll' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <span class="tdsc-field__title"><?php esc_html_e( 'Scroll-to-bottom icon', 'top-down-scroll' ); ?></span>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Leave empty to use the built-in arrow.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <div class="tdsc-media">
                                <div id="down_button_icon_preview" class="tdsc-media__preview" data-placeholder="<?php esc_attr_e( 'Default', 'top-down-scroll' ); ?>"><?php if ( $down_icon ) { echo '<img src="' . esc_url( $down_icon ) . '" alt="">'; } ?></div>
                                <div class="tdsc-media__actions">
                                    <input type="hidden" name="tdsc_down_button_icon_url" id="down_button_icon_url" value="<?php echo esc_attr( $down_icon ); ?>">
                                    <button type="button" class="button rudr-upload" id="upload_down_button_icon"><?php esc_html_e( 'Select icon', 'top-down-scroll' ); ?></button>
                                    <a href="#" class="rudr-remove tdsc-remove" id="remove_down_button_icon" <?php echo $down_icon ? '' : 'style="display:none"'; ?>><?php esc_html_e( 'Remove icon', 'top-down-scroll' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <label for="set-icon-size"><?php esc_html_e( 'Icon size', 'top-down-scroll' ); ?></label>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Default is 20px. 18-25px works best when both buttons are enabled.', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <span class="tdsc-number">
                                <input type="number" name="tdsc_icon_size" id="set-icon-size" class="tdsc-input" min="1" step="1" placeholder="20" value="<?php echo esc_attr( $icon_size ); ?>">
                                <span class="tdsc-suffix"><?php esc_html_e( 'px', 'top-down-scroll' ); ?></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tdsc-card">
                <div class="tdsc-card__head">
                    <h3 class="tdsc-card__title"><?php esc_html_e( 'Colors', 'top-down-scroll' ); ?></h3>
                </div>
                <div class="tdsc-card__body">

                    <div class="tdsc-field">
                        <div class="tdsc-field__label">
                            <span class="tdsc-field__title"><?php esc_html_e( 'Button color', 'top-down-scroll' ); ?></span>
                            <p class="tdsc-field__hint"><?php esc_html_e( 'Background of the buttons, and the color they change to on hover. Default: #046bd2', 'top-down-scroll' ); ?></p>
                        </div>
                        <div class="tdsc-field__control">
                            <div class="customColorInput tdsc-colors">

                                <div class="tdsc-color">
                                    <label class="tdsc-color__label" for="backgroundColorPreview"><?php esc_html_e( 'Background', 'top-down-scroll' ); ?></label>
                                    <div class="tdsc-color__field">
                                        <label for="backgroundColorSelection" class="screen-reader-text"><?php esc_html_e( 'Pick a background color', 'top-down-scroll' ); ?></label>
                                        <input type="color" id="backgroundColorSelection" class="customColorInput__select-input" value="<?php echo esc_attr( $bg_color ); ?>">
                                        <input type="text" id="backgroundColorPreview" name="tdsc_background_color" class="customColorInput__text-input jsColorValue" value="<?php echo esc_attr( $bg_color ); ?>">
                                    </div>
                                </div>

                                <div class="tdsc-color">
                                    <label class="tdsc-color__label" for="hoverColorPreview"><?php esc_html_e( 'Hover', 'top-down-scroll' ); ?></label>
                                    <div class="tdsc-color__field">
                                        <label for="hoverColorSelection" class="screen-reader-text"><?php esc_html_e( 'Pick a hover color', 'top-down-scroll' ); ?></label>
                                        <input type="color" id="hoverColorSelection" class="customColorInput__select-input" value="<?php echo esc_attr( $hover_color ); ?>">
                                        <input type="text" id="hoverColorPreview" name="tdsc_hover_color" class="customColorInput__text-input jsColorValue" value="<?php echo esc_attr( $hover_color ); ?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tdsc-actions">
                <?php submit_button( __( 'Save changes', 'top-down-scroll' ), 'primary', 'save_plugin_settings', false, array( 'id' => 'tdsc-save' ) ); ?>
            </div>
        </form>

        <p class="tdsc-footer">
            <?php
            printf(
                /* translators: 1: opening link tag to the review page, 2: opening link tag to the donate page, 3: closing link tag. */
                esc_html__( 'Enjoying the plugin? %1$sLeave a review%3$s or %2$sbuy me a coffee%3$s.', 'top-down-scroll' ),
                '<a href="https://wordpress.org/support/plugin/top-down-scroll/reviews/#new-post" target="_blank" rel="noopener noreferrer">',
                '<a href="https://buymeacoffee.com/nityasaha" target="_blank" rel="noopener noreferrer">',
                '</a>'
            );
            ?>
        </p>

    </div>
    <?php
}
