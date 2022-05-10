<?php
/**
 * Uninstall script
 *
 * This file contains all the logic required to uninstall the plugin
 *
 * @package WordPress
 * @subpackage Quevedo
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'quevedo_features' );
delete_option( 'quevedo_thumbnail' );
