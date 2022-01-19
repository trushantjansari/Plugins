<?php
/**
* Plugin Name:       Ajax Feedback Form
* Plugin URI:
 * Description:       Ajax feedback form is a simple and clean way to get feedback.
 * Version:           1.0.0
* Author:            Trushant Jansari
* Author URI:        http://trushantjansari.com/
 * Text Domain:       ajax-feedback-form
* Domain Path:       /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Currently plugin version.
 */
define( 'AJAX_FEEDBACK_FORM_VERSION', '1.0.0' );
define( 'AJAX_FEEDBACK_FORM_PLUGIN', plugin_basename( __FILE__ ) );
define( 'AJAX_FEEDBACK_FORM', dirname( AJAX_FEEDBACK_FORM_PLUGIN ) );
define( 'AJAX_FEEDBACK_FORM_DIR', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ajax-feedback-form-activator.php
 */
function activate_ajax_feedback_form() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajax-feedback-form-activator.php';
    Ajax_Feedback_Form_Activator::activate();
    Ajax_Feedback_Form_Activator::jal_install();
    //Ajax_Feedback_Form_Activator::jal_install_data();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ajax-feedback-form-deactivator.php
 */
function deactivate_ajax_feedback_form() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajax-feedback-form-deactivator.php';
    Ajax_Feedback_Form_Deactivator::deactivate();
}

function uninstall_ajax_feedback_form() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajax-feedback-form-uninstaller.php';
    Ajax_Feedback_Form_Uninstaller::uninstall();
}

register_activation_hook( __FILE__, 'activate_ajax_feedback_form' );
register_deactivation_hook( __FILE__, 'deactivate_ajax_feedback_form' );
register_uninstall_hook( __FILE__, 'uninstall_ajax_feedback_form' );




/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ajax-feedback-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_ajax_feedback_form() {

    $plugin = new Ajax_Feedback_Form();
    $plugin->run();

}
run_ajax_feedback_form();

