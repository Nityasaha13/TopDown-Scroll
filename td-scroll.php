<?php
/*
Plugin Name: Top-Down Scroll
Plugin URI:        https://codesocials.com/top-down-scroll/
Description: This plugin provides Scroll to Top and Scroll to Down functionality to your website. 
Version: 1.1
Author: Nitya Saha
Author URI:        https://codesocials.com/nitya-gopal-saha/
*/


register_activation_hook(__FILE__, 'td_scroll_activate');
function td_scroll_activate()
{
}

register_deactivation_hook(__FILE__, 'td_scroll_deactivate');
function td_scroll_deactivate()
{
}

// Function to display activation notice
function td_scroll_plugin_activation_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php esc_html_e( 'Add scroll buttons from settings. Goto Appearance>Top-Down Scroll.', 'plugin-text-domain' ); ?></p>
    </div>
    <?php
}
// add_action('admin_notices', 'td_scroll_plugin_activation_notice');

// Function to display deactivation notice
function td_scroll_plugin_deactivation_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php esc_html_e( 'The Top-Down Scroll is deactivated.', 'plugin-text-domain' ); ?></p>
    </div>
    <?php
}
// add_action('admin_notices', 'td_scroll_plugin_deactivation_notice');


$plugin_url = plugins_url();
wp_localize_script('top-down-script', 'pluginData', array(
    'pluginUrl' => esc_url( plugins_url('/', __FILE__) )
));

// Enqueue style and scripts in plugin admin pages
add_action('admin_enqueue_scripts', 'td_scroll_admin_enqueue_scripts');
function td_scroll_admin_enqueue_scripts()
{
    wp_enqueue_style('top-down-admin-css', esc_url( plugins_url('/assets/css/td-dashboard.css', __FILE__) ));
    // wp_enqueue_script('top-down-admin-js', esc_url( plugins_url('/assets/js/td-script.js', __FILE__) ), array('jquery'), null, true);
}



// Enqueue scripts and styles in frontend
add_action('wp_enqueue_scripts', 'td_scroll_enqueue_scripts');
function td_scroll_enqueue_scripts()
{
    wp_enqueue_style('top-down-css', plugins_url('/assets/css/top-down.css', __FILE__));
    wp_enqueue_script('top-down-js', plugins_url('/assets/js/top-down.js', __FILE__), array('jquery'), null, true);
}

//Scroll to top button
function td_scroll_to_top_button(){
    ?>

    <button id="td-scroll-to-top" class="td-top-btn"><img src="<?php echo esc_url(plugins_url('/assets/images/up2.svg',__FILE__)) ?>" alt="top"></button>

    <?php
}

//Scroll to down button
function td_scroll_to_down_button(){
    ?>

    <button id="td-scroll-to-down" class="td-down-btn"><img src="<?php echo esc_url(plugins_url('/assets/images/down2.svg',__FILE__)) ?>" alt="down"></button>

    <?php
}


// Hook the scroll-to-top button function to wp_footer action
if(get_option('enable_top')==="on"){
    add_action('wp_footer', 'td_scroll_to_top_button');
}


// Hook the scroll-to-down button function to wp_footer action
if(get_option('enable_down')==="on"){
    add_action('wp_footer', 'td_scroll_to_down_button');
}


// Function to add a custom page under the "Appearance" menu
function td_scroll_theme_page() {
    // Add a new submenu under "Appearance" menu
    add_theme_page(
        'Top-Down Scroll',
        'Top-Down Scroll',
        'manage_options',
        'top-down-scroll-page', 
        'top_down_scroll_page_content' 
    );
}
add_action('admin_menu', 'td_scroll_theme_page');


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
                    <th scope="row" class="td-table-heading">Enable Scroll-to-Down</th>
                    <td class="td-table-data">
                        <label for="enable-down-btn">
                            <input type="checkbox" name="enable_down" id="enable-down-btn" <?php checked(get_option('enable_down'), 'on'); ?>>
                            Yes
                        </label>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save', 'primary', 'save_plugin_settings'); ?>
        </form>
    </div>
    <?php
}


// Register setting and sanitize
function td_scroll_register_settings()
{
    register_setting('td_scroll_options', 'enable_top', 'sanitize_checkbox');
    register_setting('td_scroll_options', 'enable_down', 'sanitize_checkbox');
}
add_action('admin_init', 'td_scroll_register_settings');


// Sanitize checkbox
function sanitize_checkbox($input)
{
    return ($input === 'on') ? 'on' : 'off';
}


// Function to handle saving of settings
function td_scroll_save_settings()
{
    if (!isset($_POST['save_plugin_settings']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_td_scroll_settings')) {
        return;
    }

    update_option('enable_top', isset($_POST['enable_top']) ? 'on' : 'off');
    update_option('enable_down', isset($_POST['enable_down']) ? 'on' : 'off');

    // Redirect back to the settings page after saving
    wp_redirect(add_query_arg('page', 'my-custom-theme-page', admin_url('themes.php')));
    exit;
}
add_action('admin_post_save_plugin_settings', 'td_scroll_save_settings');
