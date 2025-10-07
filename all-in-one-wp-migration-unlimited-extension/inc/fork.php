<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

// === Clean up plugin row and optionally add disclaimer ===
add_filter( 'plugin_row_meta', 'rup_unlimited_backup_meta_row', 15, 2 );
function rup_unlimited_backup_meta_row( $plugin_meta, $plugin_file ) {

    // Only target our plugin row
    if ( defined( 'RUP_UNLIMITED_BACKUP_MAIN_FILE' ) && $plugin_file === plugin_basename( RUP_UNLIMITED_BACKUP_MAIN_FILE ) ) {

        // Always remove ServMask-related meta — this is functional
        $plugin_meta = array_values( array_filter( $plugin_meta, function( $meta ) {
            return strpos( $meta, 'ai1wm_check_for_updates' ) === false
                && stripos( $meta, 'servmask.com' ) === false
                && stripos( $meta, 'Contact Support' ) === false;
        } ) );

        // Only add disclaimer link and text if enabled (default: true)
        if ( rup_ub_disclaimer_enabled() ) {
            $plugin_meta[] = '<a href="' . esc_url( 'https://github.com/stingray82/Unlimited-backup#readme' ) . '" target="_blank" rel="noopener" title="Trademark notice and non-affiliation statement">Disclaimer</a>';
            $plugin_meta[] = '<span style="color:#888;">Not affiliated with ServMask, Inc.</span>';
        }
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
		if ( isset( $original_get['ai1wm-unlimited'] ) ) {
			unset( $original_get['ai1wm-unlimited'] );
		}
		$GLOBALS['rup_unlimited_backup_ai1wmue_filtered_extensions'] = $original_get;

		function rup_unlimited_backup_ai1wmue_get_filtered_extensions() {
			return $GLOBALS['rup_unlimited_backup_ai1wmue_filtered_extensions'];
		}
	}
}


// === Remove Ai1wm Sidebar via CSS/JS Injection ===
add_action( 'admin_head', 'rup_unlimited_backup_ai1wmue_remove_ai1wm_sidebar' );
function rup_unlimited_backup_ai1wmue_remove_ai1wm_sidebar() {
    ?>
    <style>
        /* Hide the whole Ai1wm sidebar */
        .ai1wm-sidebar {
            display: none !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var sidebar = document.querySelector(".ai1wm-sidebar");
            if (sidebar) {
                sidebar.remove();
            }
        });
    </script>
    <?php
}


// === Add a disclaimer into the UUPD "View details" modal ===
add_filter( 'plugins_api', 'rup_unlimited_backup_inject_disclaimer_into_modal', 20, 3 );
function rup_unlimited_backup_inject_disclaimer_into_modal( $res, $action, $args ) {
    if ( ! rup_ub_disclaimer_enabled() ) {
        return $res;
    }
    if ( 'plugin_information' !== $action ) {
        return $res;
    }

    $our_slug = defined('RUP_UNLIMITED_BACKUP_MAIN_FILE')
        ? dirname( plugin_basename( RUP_UNLIMITED_BACKUP_MAIN_FILE ) )
        : '';

    $is_ours = false;
    if ( isset( $args->slug ) && $our_slug && $args->slug === $our_slug ) {
        $is_ours = true;
    } elseif ( is_object( $res ) ) {
        if ( ( isset($res->slug) && $our_slug && $res->slug === $our_slug )
          || ( isset($res->homepage) && is_string($res->homepage) && strpos($res->homepage, 'github.com/stingray82/Unlimited-backup') !== false )
          || ( isset($res->name) && is_string($res->name) && stripos($res->name, 'Unlimited Backup') !== false ) ) {
            $is_ours = true;
        }
    }

    if ( ! $is_ours || ! is_object( $res ) ) {
        return $res;
    }

    if ( ! isset( $res->sections ) || ! is_array( $res->sections ) ) {
        $res->sections = array();
    }

    $disclaimer = '<p><strong>Trademark Notice:</strong> “ALL-IN-ONE WP MIGRATION®” is a registered trademark of ServMask, Inc. '
        . 'This is an independent, community-maintained fork and is not affiliated with, endorsed by, or sponsored by ServMask, Inc. '
        . 'Names are used solely for identification and compatibility.</p>';

    // Append to description
    if ( isset( $res->sections['description'] ) ) {
        $res->sections['description'] .= $disclaimer;
    } else {
        $res->sections['description'] = $disclaimer;
    }

    // Add a tab at the end
    $res->sections['disclaimer'] = $disclaimer;

    return $res;
}


/**
 * Check whether disclaimers (meta row + modal) should be shown.
 *
 * By default: true.
 * Can be disabled by defining a constant in wp-config.php or functions.php:
 * define( 'RUP_UB_DISABLE_DISCLAIMER', true );
 *
 * Or by using a filter:
 * add_filter( 'rup_ub_disclaimer_enabled', '__return_false' );
 */
function rup_ub_disclaimer_enabled() {
    // Allow global constant override
    if ( defined( 'RUP_UB_DISABLE_DISCLAIMER' ) && RUP_UB_DISABLE_DISCLAIMER === true ) {
        return false;
    }

    // Allow filter override
    return apply_filters( 'rup_ub_disclaimer_enabled', true );
}
