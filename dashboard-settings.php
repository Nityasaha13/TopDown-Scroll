<?php

// Register setting and sanitize
function td_scroll_register_settings() {
    register_setting('td_scroll_options', 'enable_top', 'sanitize_checkbox');
    register_setting('td_scroll_options', 'enable_down', 'sanitize_checkbox');
    register_setting('td_scroll_options', 'td_position', 'sanitize_radio');
}
add_action('admin_init', 'td_scroll_register_settings');

// Sanitize checkbox
function sanitize_checkbox($input) {
    return ($input === 'on') ? 'on' : 'off';
}

// Sanitize radio
function sanitize_radio($input) {
    $valid = array('left', 'right');
    return in_array($input, $valid) ? $input : 'left'; // Default to 'left' if invalid
}

// Function to handle saving of settings
function td_scroll_save_settings() {
    if (!isset($_POST['save_plugin_settings']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_td_scroll_settings')) {
        return;
    }

    update_option('enable_top', isset($_POST['enable_top']) ? 'on' : 'off');
    update_option('enable_down', isset($_POST['enable_down']) ? 'on' : 'off');
    update_option('td_position', sanitize_radio($_POST['td_position']));

    // Redirect back to the settings page after saving
    wp_redirect(add_query_arg('page', 'my-custom-theme-page', admin_url('themes.php')));
    exit;
}
add_action('admin_post_save_plugin_settings', 'td_scroll_save_settings');

// Function to output the content of the custom page
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
            </table>
            <?php submit_button('Save', 'primary', 'save_plugin_settings'); ?>
        </form>
    </div>
    <?php
}

// Hook the scroll-to-top button function to wp_footer action
if (get_option('enable_top') === "on") {
    add_action('wp_footer', 'td_scroll_to_top_button');
}

// Hook the scroll-to-down button function to wp_footer action
if (get_option('enable_down') === "on") {
    add_action('wp_footer', 'td_scroll_to_down_button');
}
