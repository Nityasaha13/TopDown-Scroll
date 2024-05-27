<?php

function top_down_scroll_page_content() {
    ?>
    <div class="wrap">
        <h2>Top-Down Scroll Settings</h2>
        
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
                            <input type="radio" name="td_position" id="td-position-left" value="left" <?php checked(get_option('td_position'), 'left'); ?>>
                            Left
                        </label>
                        <label for="td-position-right">
                            <input type="radio" name="td_position" id="td-position-right" value="right" <?php checked(get_option('td_position'), 'right'); ?>>
                            Right
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Upload Top Button Icon:</th>
                    <td class="td-table-data">
                        <input type="hidden" name="top_button_icon_url" id="top_button_icon_url" value="<?php echo esc_attr(get_option('top_button_icon_url')); ?>">
                        <button type="button" class="button" id="upload_top_button_icon">Upload/Select Icon</button>
                        <div id="top_button_icon_preview" style="margin-top: 10px;">
                            <?php if ($top_icon_url = get_option('top_button_icon_url')) : ?>
                                <img src="<?php echo esc_url($top_icon_url); ?>" alt="Top Button Icon" style="width: 30px; height: 30px;">
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="td-table-heading">Upload Down Button Icon:</th>
                    <td class="td-table-data">
                        <input type="hidden" name="down_button_icon_url" id="down_button_icon_url" value="<?php echo esc_attr(get_option('down_button_icon_url')); ?>">
                        <button type="button" class="button" id="upload_down_button_icon">Upload/Select Icon</button>
                        <div id="down_button_icon_preview" style="margin-top: 10px;">
                            <?php if ($down_icon_url = get_option('down_button_icon_url')) : ?>
                                <img src="<?php echo esc_url($down_icon_url); ?>" alt="Down Button Icon" style="width: 30px; height: 30px;">
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save', 'primary', 'save_plugin_settings'); ?>
        </form>
    </div>
    <?php
}
