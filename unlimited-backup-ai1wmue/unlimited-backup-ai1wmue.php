<?php
/**
 * Plugin Name:       Unlimited Backup Plugin
 * Description:       Extension for All-in-One WP Migration that enables unlimited size exports and imports
 * Tested up to:      6.8.1
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Version:           2.70.2
 * Author:            stingray82
 * Author URI:        https://github.com/stingray82/
 * License:           GPL2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       unlimited-backup-ai1wmue
 * Website:           https://reallyusefulplugins.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

function ai1wmue_mock_license_response( $pre, $args, $url ) {
	// Intercept all requests to servmask.com domains
	if ( false !== strpos( $url, 'servmask.com' ) ) {
		$body = wp_json_encode(
			array(
				'success'        => true,
				'license_status' => 'valid',
			)
		);
		return array(
			'headers'  => array(),
			'body'     => $body,
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'cookies'  => array(),
			'filename' => null,
		);
	}
	return false;
}
add_filter( 'pre_http_request', 'ai1wmue_mock_license_response', 10, 3 );

// Disable license checks
function ai1wmue_disable_license_checks() {
	return true;
}
add_filter( 'ai1wm_license_validation', 'ai1wmue_disable_license_checks', 10, 0 );

if ( is_multisite() ) {
	// Multisite Extension shall be used instead
	return;
}

// Check SSL Mode
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && ( $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}

// Plugin Basename
define( 'AI1WMUE_PLUGIN_BASENAME', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

// Plugin Path
define( 'AI1WMUE_PATH', dirname( __FILE__ ) );

// Plugin URL
define( 'AI1WMUE_URL', plugins_url( '', AI1WMUE_PLUGIN_BASENAME ) );

// Include constants
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'constants.php';

// Include functions
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'functions.php';

// Include loader
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'loader.php';

// Register activation hook to install and activate base plugin if needed
register_activation_hook( __FILE__, 'ai1wmue_activate_plugin' );

/**
 * Plugin activation hook
 *
 * @return void
 */
function ai1wmue_activate_plugin() {
	// Check if the base plugin is installed
	if ( ! ai1wmue_is_base_plugin_installed() ) {
		// Install the base plugin
		$install_result = ai1wmue_install_base_plugin();

		if ( is_wp_error( $install_result ) ) {
			// Installation failed, deactivate this plugin
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die(
				sprintf(
					__( 'The All-in-One WP Migration plugin could not be installed automatically. Please <a href="%s" target="_blank">download and install it manually</a> before activating this extension.', AI1WMUE_PLUGIN_NAME ),
					'https://wordpress.org/plugins/all-in-one-wp-migration/'
				)
			);
		}
	}

	// Activate the base plugin if it's not already active
	if ( ! ai1wmue_is_base_plugin_active() ) {
		if ( ! function_exists( 'activate_plugin' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$activate_result = activate_plugin( 'all-in-one-wp-migration/all-in-one-wp-migration.php' );

		if ( is_wp_error( $activate_result ) ) {
			// Activation failed, deactivate this plugin
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die(
				sprintf(
					__( 'The All-in-One WP Migration plugin could not be activated automatically. Please <a href="%s">activate it manually</a> before activating this extension.', AI1WMUE_PLUGIN_NAME ),
					admin_url( 'plugins.php' )
				)
			);
		}
	}
}

// ===========================================================================
// = All app initialization is done in Ai1wmue_Main_Controller __constructor =
// ===========================================================================
$main_controller = new Ai1wmue_Main_Controller( 'AI1WMUE', 'file' );









// ===========================================================================
// = Lets Fork this thing! =
// ===========================================================================
require_once __DIR__ . '/inc/fork.php';
add_action( 'plugins_loaded', function() {
    // 1) Load our universal drop-in. Because that file begins with "namespace UUPD\V1;",
    //    both the class and the helper live under UUPD\V1.
    require_once __DIR__ . '/inc/updater.php';

    // 2) Build a single $updater_config array:
    $updater_config = [
        'plugin_file' => plugin_basename( __FILE__ ),             // e.g. "simply-static-export-notify/simply-static-export-notify.php"
        'slug'        => 'unlimited-backup-ai1wmue',           // must match your updater‐server slug
        'name'        => 'Unlimited Backup Plugin',         // human‐readable plugin name
        'version'     => AI1WMUE_VERSION, // same as the VERSION constant above
        'key'         => '',                 // your secret key for private updater
        'server'      => 'https://raw.githubusercontent.com/stingray82/Unlimited-backup/main/uupd/index.json',
    ];

    // 3) Call the helper in the UUPD\V1 namespace:
    \UUPD\V1\UUPD_Updater_V1::register( $updater_config );
}, 1 );
