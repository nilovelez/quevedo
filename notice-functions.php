<?php
/**
 * Helpers to show the settings page notices
 *
 * @package WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Displays a generic 'Options saved!' success notice
 */
function save_success_notice() {
	new Notice( __( 'Options saved!', 'quevedo' ), 'success' );
}
/**
 * Displays a generic save error notice
 */
function save_error_notice() {
	new Notice( __( 'Error saving configuration to database.', 'quevedo' ), 'error' );
}
/**
 * Displays a generic 'No changes were needed.' info notice
 */
function save_no_changes_notice() {
	new Notice( __( 'No changes were needed.', 'quevedo' ), 'info' );
}
