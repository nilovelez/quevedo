<?php
/**
 * Plugin Name: Quevedo
 * Description: .
 * Version: 0.1
 * Author: Nilo Velez
 * Author URI: https://www.nilovelez.com
 * Text Domain: quevedo
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quevedo_settings = array();

$quevedo_options_array = array(
	'disable_tags'            => array(
		'title'       => __( 'Disable post tags', 'quevedo' ),
		'description' => __( 'If not used properly, post tags can create a lot of duplicate content in your site.', 'quevedo' ),
	),
	'disable_author_archives' => array(
		'title'       => __( 'Disable author archives', 'quevedo' ),
		'description' => __( 'If you have a single-user blog, the author archive will be exactly the same as your homepage.', 'quevedo' ),
	),
	'fix_filenames'           => array(
		'title'       => __( 'Fix uploads filenames', 'quevedo' ),
		'description' => __( 'Replaces especial characters from the uploaded files filenames', 'quevedo' ),
	),

);

add_action(
	'init',
	function () {

		global $quevedo_settings;

		if ( is_admin() ) {
			require plugin_dir_path( __FILE__ ) . 'class-notice.php';
			add_action(
				'admin_menu',
				function () {
					add_submenu_page(
						'tools.php',
						__( 'Quevedo', 'quevedo' ),
						__( 'Quevedo', 'quevedo' ),
						'manage_options',
						'quevedo',
						__NAMESPACE__ . '\submenu_page_callback'
					);
				}
			);

			/* Sanitization not needed, only used to check if form has been submitted */
			if ( filter_input( INPUT_POST, 'quevedo-saved' ) !== null ) {
				check_admin_referer( 'quevedo_save_options' );

				/* Sanitization not needed, values are checked against a valid options array */
				save_settings(
					filter_input( INPUT_POST, 'optionEnabled', FILTER_DEFAULT, FILTER_FORCE_ARRAY )
				);
			}
		}
		read_settings();
		require plugin_dir_path( __FILE__ ) . 'quevedo-actions.php';
		require plugin_dir_path( __FILE__ ) . 'quevedo-shortcodes.php';
	}
);





/**
 * Callback for the add_submenu_page function.
 */
function submenu_page_callback() {
	global $quevedo_settings, $quevedo_options_array;

	read_settings();
	$all_powertools_checked = ( count( array_intersect( array_keys( $quevedo_options_array ), $quevedo_settings ) ) === count( $quevedo_options_array ) ) ? true : false;
	include plugin_dir_path( __FILE__ ) . 'admin-content.php';
}

/**
Returns an array with the plugin settings, defaults to blank array.
 */
function read_settings() {
	global $quevedo_settings;
	$quevedo_settings = get_option( 'quevedo_settings', array() );
}

/**
 * Saves options to database
 *
 * @param array $options options array, normally $_POST.
 * @param bool  $silent  prevent the function from generating admin notices.
 */
function save_settings( $options = array(), $silent = false ) {
	global $quevedo_settings, $quevedo_options_array;

	if ( null === $options ) {
		$options = array();
	}

	read_settings();
	$options = array_intersect( $options, array_keys( $quevedo_options_array ) );

	$num_options = count( $options );
	if ( $num_options > 0 ) {
		for ( $i = 0; $i < $num_options; $i++ ) {
			$options[ $i ] = sanitize_text_field( $options[ $i ] );
		}

		if ( is_equal_array( $quevedo_settings, $options ) ) {
			if ( ! $silent ) {
				save_no_changes_notice();
			}
			return true;
		}

		if ( update_option( 'quevedo_settings', $options ) ) {
			$quevedo_settings = $options;
			if ( ! $silent ) {
				save_success_notice();
			}
			return true;
		} else {
			if ( ! $silent ) {
				save_error_notice();
			}
			return false;
		}
	} elseif ( count( $quevedo_settings ) > 0 ) {
		if ( delete_option( 'quevedo_settings' ) ) {
			$quevedo_settings = array();
			if ( ! $silent ) {
				save_success_notice();
			}
			return true;
		} else {
			if ( ! $silent ) {
				save_error_notice();
			}
			return false;
		}
	}

	if ( ! $silent ) {
		save_no_changes_notice();
	}
	return true;
}


/* utils */

/**
 * Checks if two arrays are exactly equal
 *
 * @param array $a first array to compare.
 * @param array $b second array to compare.
 */
function is_equal_array( $a, $b ) {
	return (
	is_array( $a ) && is_array( $b ) &&
	count( $a ) === count( $b ) &&
	array_diff( $a, $b ) === array_diff( $b, $a )
	);
}
