<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://hmumarkhan.com/
 * @since             1.0.0
 * @package           Cf7_Mime_Type_Check
 *
 * @wordpress-plugin
 * Plugin Name:       Mime Type Check for Contact Form 7
 * Description:       This plugin will let you add the functionality in Contact Form 7 File fields to validate it by mime types
 * Version:           1.0.0
 * Author:            Umar Khan
 * Author URI:        https://hmumarkhan.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-mime-type-check
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CF7_MIME_TYPE_CHECK_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-mime-type-check.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf7_mime_type_check() {

	$plugin = new Cf7_Mime_Type_Check();
	$plugin->run();

}
run_cf7_mime_type_check();
