<?php

function top_down_scroll_page_content() {
    ?>
    <div class="wrap">
        <h2>Top-Down Scroll Settings</h2>
        <p>The ultimate solution for your site navigation. The control is in your hand!</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('td_scroll_options'); ?>
            <?php do_settings_sections('td_scroll_options'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row" class="td-table-heading">Enable Scroll-to-Top</th>
                    <td class="td-table-data">
                        <label for="enable-top-btn">
                            <input type="checkbox" name="enable_top" id="enable-top-btn" <?php checked(get_option('enable_top'), 'on'); ?>>
                            Yes
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Enable Scroll-to-Down:</th>
                    <td class="td-table-data">
                        <label for="enable-down-btn">
                            <input type="checkbox" name="enable_down" id="enable-down-btn" <?php checked(get_option('enable_down'), 'on'); ?>>
                            Yes
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Position:</th>
                    <td class="td-table-data">
                        <label for="td-position-left">
                            <input type="radio" name="td_position" id="td-position-left" value="left" <?php echo (get_option('td_position') == 'left') ? 'checked="checked"' : ''; ?>>
                            Left
                        </label>
                        <label for="td-position-right">
                            <input type="radio" name="td_position" id="td-position-right" value="right" <?php echo (get_option('td_position') == 'right') ? 'checked="checked"' : ''; ?>>
                            Right
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Upload Scroll-Top Icon:</th>
                    <td class="td-table-data">
                        <input type="hidden" name="top_button_icon_url" id="top_button_icon_url" value="<?php echo esc_attr(get_option('top_button_icon_url')); ?>">
                        <button type="button" class="button rudr-upload" id="upload_top_button_icon">Select Icon</button>
                        <div id="top_button_icon_preview" style="margin-top: 10px;">
                            <?php if ($top_icon_url = get_option('top_button_icon_url')) : ?>
                                <img src="<?php echo esc_url($top_icon_url); ?>" alt="Top Button Icon" style="width: 50px; height: 50px;">
                            <?php endif; ?>
                        </div>
                        <a href="#" class="rudr-remove" id="remove_top_button_icon" style="<?php echo get_option('top_button_icon_url') ? '' : 'display:none'; ?>">Remove Icon</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Upload Scroll-Down Icon:</th>
                    <td class="td-table-data">
                        <input type="hidden" name="down_button_icon_url" id="down_button_icon_url" value="<?php echo esc_attr(get_option('down_button_icon_url')); ?>">
                        <button type="button" class="button rudr-upload" id="upload_down_button_icon">Select Icon</button>
                        <div id="down_button_icon_preview" style="margin-top: 10px;">
                            <?php if ($down_icon_url = get_option('down_button_icon_url')) : ?>
                                <img src="<?php echo esc_url($down_icon_url); ?>" alt="Down Button Icon" style="width: 50px; height: 50px;">
                            <?php endif; ?>
                        </div>
                        <a href="#" class="rudr-remove" id="remove_down_button_icon" style="<?php echo get_option('down_button_icon_url') ? '' : 'display:none'; ?>">Remove Icon</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Set Icon Size:</th>
                    <td class="td-table-data">
                        <label for="set-icon-size">
                            <input type="number" name="td_icon_size" id="set-icon-size" placeholder="Enter" value="<?php echo get_option('td_icon_size'); ?>">
                            px. [Default: 20px]
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Set Icon Background Color:<br>[default: #046bd2]</th>
                    <td class="td-table-data">
                        <?php 

                        $bg_color = get_option('td_background_color','#046bd2') ?: '#046bd2';
                        $hover_color = get_option('td_hover_color', '#046bd2') ?: '#046bd2';

                        ?>
                        <div class="customColorInput">
                            <label for="backgroundColorPreview">Background:</label>
                            <input type="text" id="backgroundColorPreview" name="td_background_color" class="customColorInput__text-input jsColorValue" value="<?php echo $bg_color ?>">

                            <label for="backgroundColorSelection" class="visually-hidden">Background</label>
                            <input type="color" id="backgroundColorSelection" class="customColorInput__select-input" value="<?php echo $bg_color ?>">

                            <label for="hoverColorPreview" class="ml-40">Hover:</label>
                            <input type="text" id="hoverColorPreview" name="td_hover_color" class="customColorInput__text-input jsColorValue" value="<?php echo $hover_color ?>">

                            <label for="hoverColorSelection" class="visually-hidden">Hover</label>
                            <input type="color" id="hoverColorSelection" class="customColorInput__select-input" value="<?php echo $hover_color ?>">
                        </div>

                    </td>
                </tr>
            </table>
            <?php submit_button('Save', 'primary', 'save_plugin_settings'); ?>
        </form>
    </div>
    <?php
}
