<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}
// The below code stops original updates from overwriting the fork and cleans up some of the servmask branding and items from the plugin rows.
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
add_filter( 'option_ai1wm_updater', 'rup_unlimited_backup_ai1wmue_clean_ai1wm_updater_option' );
function rup_unlimited_backup_ai1wmue_clean_ai1wm_updater_option( $updater ) {
	if ( ! is_array( $updater ) ) {
		return $updater;
	}

	// Keys that ServMask uses for their official Unlimited extension
	$keys_to_remove = [
		'all-in-one-wp-migration-unlimited-extension',
		'forked-all-in-one-wp-migration-unlimited-extension',
		// You can add more if needed
	];

	foreach ( $keys_to_remove as $key ) {
		unset( $updater[ $key ] );
	}

	return $updater;
}

// === Remove Ai1wm Internal Update Notice ===
add_filter( 'option_ai1wm_updater', 'rup_unlimited_backup_ai1wmue_remove_internal_update_message' );
function rup_unlimited_backup_ai1wmue_remove_internal_update_message( $updater ) {
	if ( isset( $updater['ai1wm-unlimited-fork'] ) ) {
		unset( $updater['ai1wm-unlimited-fork'] );
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
