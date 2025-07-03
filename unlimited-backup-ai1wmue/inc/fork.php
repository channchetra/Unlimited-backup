<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

if ( ! class_exists( 'Ai1wmue_Eula_Controller', false ) ) {
	class Ai1wmue_Eula_Controller {
		public static function should_display_eula() {
			return false;
		}

		public static function display_eula_modal() {
			// Suppressed
		}

		public static function eula_response() {
			// Suppressed or return success
			wp_send_json_success();
		}
	}
}
// The below code stops original updates from overwriting the fork and cleans up some of the servmask branding and items from the Plugin
// === Remove Ai1wm "Check for Updates" and "Contact Support" Links ===
add_filter( 'plugin_row_meta', 'rup_unlimited_backup_ai1wmue_filter_plugin_row_meta', 15, 2 );
function rup_unlimited_backup_ai1wmue_filter_plugin_row_meta( $plugin_meta, $plugin_file ) {
	if ( $plugin_file === 'unlimited-backup-ai1wmue/unlimited-backup-ai1wmue.php' ) {
		$plugin_meta = array_filter( $plugin_meta, function( $meta ) {
			return strpos( $meta, 'ai1wm_check_for_updates' ) === false
				&& strpos( $meta, 'servmask.com/help' ) === false // Typical support link
				&& stripos( $meta, 'Contact Support' ) === false;  // Extra fallback
		} );
	}
	return $plugin_meta;
}

// === Prevent Update Messages for This Plugin ===
add_filter( 'option_ai1wm_updater', 'rup_unlimited_backup_ai1wmue_combined_updater_cleanup' );
function rup_unlimited_backup_ai1wmue_combined_updater_cleanup( $updater ) {
	if ( ! is_array( $updater ) ) {
		return $updater;
	}

	$keys_to_remove = [
		'all-in-one-wp-migration-unlimited-extension',
		'forked-all-in-one-wp-migration-unlimited-extension',
		'ai1wm-unlimited-fork',
	];

	foreach ( $keys_to_remove as $key ) {
		unset( $updater[ $key ] );
	}

	return $updater;
}


// === Remove This Plugin from Ai1wm Extensions List ===
add_action( 'plugins_loaded', 'rup_unlimited_backup_ai1wmue_filter_ai1wm_extensions', 20 );
function rup_unlimited_backup_ai1wmue_filter_ai1wm_extensions() {
	if ( class_exists( 'Ai1wm_Extensions' ) && method_exists( 'Ai1wm_Extensions', 'get' ) ) {
		$original_get = \Ai1wm_Extensions::get();
		if ( isset( $original_get['ai1wm-unlimited-fork'] ) ) {
			unset( $original_get['ai1wm-unlimited-fork'] );
		}
		$GLOBALS['rup_unlimited_backup_ai1wmue_filtered_extensions'] = $original_get;

		function rup_unlimited_backup_ai1wmue_get_filtered_extensions() {
			return $GLOBALS['rup_unlimited_backup_ai1wmue_filtered_extensions'];
		}
	}
}
