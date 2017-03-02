<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           uml_define_frame_options
 *
 * @wordpress-plugin
 * Plugin Name:       uml_define_frame_options
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Redefines the x frame options
 * Version:           1.0.0
 * Author:            Abel Facenda Carrasco
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       uml_define_frame_options
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-uml_define_frame_options-activator.php
 */
function activate_uml_define_frame_options() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uml_define_frame_options-activator.php';
	Uml_Define_Frame_Options_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_uml_define_frame_options() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_uml_define_frame_options' );
register_deactivation_hook( __FILE__, 'deactivate_uml_define_frame_options' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-umlDefineFrameOptions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_uml_define_frame_options() {

	$plugin = new Uml_Define_Frame_Options();
	$plugin->run();

}
run_uml_define_frame_options();
