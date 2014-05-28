<?php

/*
Plugin Name: GuestApp
Plugin URI: http://guestapp.me
Description: GuestApp Plugin
Version: 1.1.2
Author: GuestApp
Author URI: http://guestapp.me
*/

include_once('CGuestApp.php');

//=============================================================================
// Admin menus
//=============================================================================

/*
 * Creates a GuestApp section in the Wordpress Admin sidebar
 */
function guestapp_admin_menu() {
    $page_title = 'GuestApp Plugin Options';
    $menu_title = 'GuestApp';
    $capability = 'manage_options';
    $menu_slug  = 'guestapp-plugin';
    $callback   = 'guestapp_options_page';
    $icon_url   = plugin_dir_url(__FILE__ ) . "images/menu_icon.png";

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $callback, $icon_url);
}
add_action('admin_menu', 'guestapp_admin_menu');
/*
 * Creates the GuestApp settings pages
 */
function guestapp_admin_init() {
    // Register the API Token setting into the wp_options table
    register_setting('guestapp-settings-group', 'guestapp_token', 'guestapp_sanitize');
    register_setting('guestapp-settings-group', 'guestapp_colorscheme');
    register_setting('guestapp-settings-group', 'guestapp_last_data_update', 'guestapp_updatedb' );
    
    // Create the settings sections and input fields
    add_settings_section('section-one', __("Data", "guestapp"), 'section_one_callback', 'guestapp-plugin');
    add_settings_field('field-one', __("Secret identification key", "guestapp"), 'field_one_callback', 'guestapp-plugin', 'section-one');
}
add_action('admin_init', 'guestapp_admin_init');

//=============================================================================
// Options callbacks
//=============================================================================

/*
 * API Token help message
 */
function section_one_callback() {
    _e("Enter your key (available at <a href='http://admin.guestapp.me'>your administration dashboard</a>) to be able to retrieve your reviews from Guest App.", "guestapp");
}

/*
 * API Token input field
 */
function field_one_callback() {
    $setting = esc_attr(get_option('guestapp_token' ));
    echo "<input type='text' name='guestapp_token' value='".$setting."'>";
}

/*
 * Hidden setting, used to refresh the DB once the token was set
 */
function field_force_refresh_callback() {
    $lastUpdated = get_option('guestapp_last_data_update');
    /**/

    echo "<div class='toggle-box'>";
    echo "<h3>" . __('Advanced settings', 'guestapp') . "</h3>";
    echo "<div class='toggle-box-content'>";
    echo "<input type='checkbox' id='toggle' class='disguise' name='guestapp_last_data_update'>";
    echo "<em><label for='toggle'>" . __('Synchronize reviews now.', 'guestapp') . '</label></em><br>';
    echo "<em>" . __('Last updated', 'guestapp'). " : " . ($lastUpdated ? date_i18n("l d F Y, H:i:s", $lastUpdated) : __('never', 'guestapp'));
    echo "<br><em>" . __('Next automatic update', 'guestapp'). ' : ' . date_i18n("l d F Y, H:i:s", wp_next_scheduled('cron_refresh_db')) . "</em>";
    echo "</div></div>";
    
}


/*
 * Verifies if the inputted token is a valid token.
 */
function guestapp_sanitize($input) {
    // Avec une seule option, $input est un string, sinon c'est un Array
    if (isset($input)) {
        $ga = new GuestApp();
        $valid = $ga->checkToken($input);

        if ($valid) {
            $new_input = $input;
        } else {
            $message = __('Your secret identification key has not been validated by the API. Please check that you have entered the correct secret identification key.', 'guestapp');
            $type = 'error';
            add_settings_error(
                'guestapp-wrong-token',
                esc_attr('guestapp_token'),
                $message,
                $type
            );

            $new_input = get_option('guestapp_token');
        }
    }

    return $new_input;
}

function guestapp_updatedb($input) {
    if (!empty($_POST['guestapp_last_data_update'])) {
        $success = refresh_db();
        $data = "Woohoo";
        
        if (!$success) {
            $message = __('Cannot reach the Guest App API.', 'guestapp');
            $type = 'error';
            add_settings_error(
                'guestapp-api-down',
                $data,
                $message,
                $type
            );
        }  
    }

    return get_option('guestapp_last_data_update') ? get_option('guestapp_last_data_update') : time();
}

/*
 * Affiche toutes les options
 */
function guestapp_options_page() {
    ?>
    <div class="wrap">
        <form action="options.php" method="POST">
            <?php settings_errors(); ?>
            <?php settings_fields('guestapp-settings-group' ); ?>
            <?php do_settings_sections('guestapp-plugin' ); ?>
            <?php submit_button(); ?>

            <?php field_force_refresh_callback() ?>
        </form>
    </div>
    <?php
}

//=============================================================================
// cron data
//============================================================================= 

/*
 * Add the cron on plugin activation
 */
register_activation_hook(__FILE__, 'activation_cron_refresh_db');
function activation_cron_refresh_db() {
    wp_schedule_event(time(), 'twicedaily', 'cron_refresh_db');
}

/*
 * Cron method
 * Pulls everything from the API, inserts it into the database
 * Also updates the expiration date.
 */

add_action('cron_refresh_db', 'refresh_db');
function refresh_db() {
    global $wpdb;

    $ga = new GuestApp(get_option('guestapp_token'));
    $json = $ga->getAll();

    // An error occured while pulling from the API
    // We don't want to insert anything in the database, leave it as is
    // We fill the ga_review_error_data, to indicate why there's no data
    // Otherwise, we clear the latest error data

    if (isset($json->error) || $json === null) {
        $data = array("option_name"  => "guestapp_review_error_data",
                      "option_value" => json_encode($json),
                      "autoload"     => "yes");
        $wpdb->replace($wpdb->options, $data);    
        return false;
    }

    $jsonRepr = json_encode($json);

    // Inserting into the database !
    // First off, the review data
    // This is a json representation of the reviews
    $data = array("option_name"  => "guestapp_review_data",
                          "option_value" => $jsonRepr,
                          "autoload"     => "yes");
    $wpdb->replace($wpdb->options, $data);

    // Everything went smoothly, empty the errors
    $data = array("option_name"  => "guestapp_review_error_data",
                      "option_value" => "",
                      "autoload"     => "yes");
    $wpdb->replace($wpdb->options, $data);    

    $data = array("option_name"  => "guestapp_last_data_update",
                      "option_value" => time(),
                      "autoload"     => "yes");
    $wpdb->replace($wpdb->options, $data);    

    return true;
}

/*
 * Delete cron rule when plugin is deactivated
 */
register_deactivation_hook(__FILE__, 'deactivate_cron_refresh' );
function deactivate_cron_refresh() {
    wp_clear_scheduled_hook('cron_refresh_db');
    remove_shortcode('guestapp');
    remove_action('media_buttons', 'add_form_button');
    unregister_widget('GuestApp_Widget');
}

/*
 * Delete everything related to GuestApp when uninstalling
 */
register_uninstall_hook(__FILE__, 'uninstall' );
function uninstall() {
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die();
    }
    remove_shortcode('guestapp');
    remove_action('media_buttons', 'add_form_button');
    unregister_widget('GuestApp_Widget');

    global $wpdb;

    // Delete everything related to guestapp in the options table
    $wpdb->query("DELETE FROM " . $wpdb->options . " WHERE option_name LIKE %guestapp%");
}

//=============================================================================
// Tools
//=============================================================================

/*
 * Outputs a file's contents
 */
function render($template, $param){
    ob_start();
    // Extract every param in the current scope
    extract($param);
    include($template);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}

//=============================================================================
// Widget
//=============================================================================
include_once('guestapp-widget.php');
