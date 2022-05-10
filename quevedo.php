<?php
/**
 * Plugin Name: Quevedo
 * Description: Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.
 * Version: 1.0
 * Author: Nilo Velez
 * Author URI: https://www.nilovelez.com
 * Text Domain: quevedo
 * Domain Path: /languages

 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function() {
		load_plugin_textdomain(
			'quevedo',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}
);

$quevedo_settings = array();

$quevedo_features_array = array();

add_action(
	'init',
	function () {

		global $quevedo_settings, $quevedo_features_array;

		$quevedo_features_array = array(
			'disable_tags'            => array(
				'title'       => __( 'Disable post tags', 'quevedo' ),
				'description' => __( 'If not used properly, post tags can create a lot of duplicate content in your site.', 'quevedo' ),
			),
			'disable_formats'         => array(
				'title'       => __( 'Disable post formats', 'quevedo' ),
				'description' => __( 'If you are not using posts formats they only add clutter to the post editor', 'quevedo' ),
			),
			'disable_author_archives' => array(
				'title'       => __( 'Disable author archives', 'quevedo' ),
				'description' => __( 'If you have a single-user blog, the author archive will be exactly the same as your homepage. This could lead to duplicate content SEO issues.', 'quevedo' ),
			),
			'redirect_attachments'    => array(
				'title'       => __( 'Redirect attachment pages to parent post', 'quevedo' ),
				'description' => __( 'WordPress creates a simgle pagle for each gallery image, creating a lot of thin content. This feature redirects the attachment page to the post the image is attached to.', 'quevedo' ),
			),
		);

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
			if ( filter_input( INPUT_POST, 'quevedo_features_saved' ) !== null ) {
				check_admin_referer( 'quevedo-features-save' );

				/* Sanitization not needed, values are checked against a valid options array */
				$options = filter_input(
					INPUT_POST,
					'featureEnabled',
					FILTER_DEFAULT,
					FILTER_FORCE_ARRAY
				);
				save_features( $options );
			}

			if ( filter_input( INPUT_POST, 'quevedo_thumbnail_saved' ) !== null ) {
				check_admin_referer( 'quevedo-thumbnail-save' );

				$option = filter_input(
					INPUT_POST,
					'quevedo_thumbnail_id',
					FILTER_VALIDATE_INT
				);
				save_thumbnail( $option );
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
	global $quevedo_settings, $quevedo_features_array;
	read_settings();
	include plugin_dir_path( __FILE__ ) . 'admin-content.php';
}

/**
 * Returns an array with the plugin settings, defaults to blank array.
 */
function read_settings() {
	global $quevedo_settings;
	$quevedo_settings = array(
		'features'  => get_option( 'quevedo_features', array() ),
		'thumbnail' => intval( get_option( 'quevedo_thumbnail', 0 ) ),
	);
}

/**
 * Saves Quevedo features options to database
 *
 * @param array $options options array, normally $_POST.
 */
function save_features( $options = array() ) {
	global $quevedo_settings, $quevedo_features_array;
	if ( null === $options ) {
		$options = array();
	}

	read_settings();
	$valid_options = array_keys( $quevedo_features_array );
	$options       = array_intersect( $options, $valid_options );

	if ( count( $options ) > 0 ) {
		$num_options = count( $options );
		for ( $i = 0; $i < $num_options; $i++ ) {
			$options[ $i ] = sanitize_text_field( $options[ $i ] );
		}
		if ( is_equal_array( $quevedo_settings['features'], $options ) ) {
			save_no_changes_notice();
			return true;
		}

		if ( update_option( 'quevedo_features', $options ) ) {
			$quevedo_settings['features'] = $options;
			save_success_notice();
			return true;
		} else {
			save_error_notice();
			return false;
		}
	} elseif ( count( $quevedo_settings['features'] ) > 0 ) {
		if ( delete_option( 'quevedo_features' ) ) {
			$quevedo_settings['features'] = array();
			save_success_notice();
			return true;
		} else {
			save_error_notice();
			return false;
		}
	}
	save_no_changes_notice();
	return true;
}

/**
 * Saves Quevedo thumbnails options to database
 *
 * @param array $option thumbnail postid.
 */
function save_thumbnail( $option = 0 ) {
	global $quevedo_settings;
	read_settings();

	$option = intval( $option );

	if ( 0 !== $option ) {
		if ( $option === $quevedo_settings['thumbnail'] ) {
			save_no_changes_notice();
			return true;
		}
		if ( update_option( 'quevedo_thumbnail', $option ) ) {
			$quevedo_settings['thumbnail'] = $option;
			save_success_notice();
			return true;
		} else {
			save_error_notice();
			return false;
		}
	}

	if ( 0 !== $quevedo_settings['thumbnail'] ) {
		if ( delete_option( 'quevedo_thumbnail' ) ) {
			$quevedo_settings['thumbnail'] = null;
			save_success_notice();
			return true;
		} else {
			save_error_notice();
			return false;
		}
	}

	save_no_changes_notice();
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
