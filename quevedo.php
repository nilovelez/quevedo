<?php
/**
 * Plugin Name: Quevedo
 * Description: Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.
 * Version: 1.4
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

/**
 * Global settings array for the plugin
 *
 * @var array
 */
$quevedo_settings = array();

/**
 * Global features array for the plugin
 *
 * @var array
 */
$quevedo_features_array = array();

/**
 * Global featured image options array for the plugin
 *
 * @var array
 */
$quevedo_thumbnail_features_array = array();

add_action(
	'init',
	function () {
		global $quevedo_settings, $quevedo_features_array, $quevedo_thumbnail_features_array;
		
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
			'disable_date_archives'   => array(
				'title'       => __( 'Disable date archives', 'quevedo' ),
				'description' => __( 'Date archive pages (year, month and day) can create duplicate or thin content on personal blogs. This feature redirects them to your homepage.', 'quevedo' ),
			),
			'redirect_attachments'    => array(
				'title'       => __( 'Redirect attachment pages to parent post', 'quevedo' ),
				'description' => __( 'WordPress creates a simgle pagle for each gallery image, creating a lot of thin content. This feature redirects the attachment page to the post the image is attached to.', 'quevedo' ),
			),
			'simplify_editor_blocks'  => array(
				'title'       => __( 'Simplify editor blocks', 'quevedo' ),
				'description' => __( 'When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted.', 'quevedo' ),
			),
		);

		$quevedo_thumbnail_features_array = array(
			'featured_image_og_meta' => array(
				'title'       => __( 'Add featured image to post metadata', 'quevedo' ),
				'description' => __( 'Outputs Open Graph and Twitter image meta tags using your featured image settings. Uses the default featured image when set; otherwise the post featured image.', 'quevedo' ),
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

			// Add "settings" link to Quevedo in the plugin list.
			add_filter(
				'plugin_action_links',
				function( $plugin_actions, $plugin_file ) {
					$new_actions = array();
					if ( basename( dirname( __FILE__ ) ) . '/quevedo.php' === $plugin_file ) {
						$settings_url = esc_url( add_query_arg( array( 'page' => 'quevedo' ), admin_url( 'tools.php' ) ) );
						$new_actions['sc_settings'] = '<a href="' . $settings_url . '">' . __( 'Settings', 'quevedo' ) . '</a>';
					}
					return array_merge( $new_actions, $plugin_actions );
				},
				10,
				2
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

				$thumbnail_id = filter_input(
					INPUT_POST,
					'quevedo_thumbnail_id',
					FILTER_VALIDATE_INT
				);
				$thumbnail_features = filter_input(
					INPUT_POST,
					'thumbnailFeatureEnabled',
					FILTER_DEFAULT,
					FILTER_FORCE_ARRAY
				);
				save_thumbnail_settings( $thumbnail_id, $thumbnail_features );
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
	global $quevedo_settings, $quevedo_features_array, $quevedo_thumbnail_features_array;
	read_settings();
	include plugin_dir_path( __FILE__ ) . 'admin-content.php';
}

/**
 * Returns an array with the plugin settings, defaults to blank array.
 */
function read_settings() {
	global $quevedo_settings;
	$quevedo_settings = array(
		'features'           => get_option( 'quevedo_features', array() ),
		'thumbnail'          => intval( get_option( 'quevedo_thumbnail', 0 ) ),
		'thumbnail_features' => get_option( 'quevedo_thumbnail_features', array() ),
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
 * Saves Quevedo featured image settings to database
 *
 * @param int   $thumbnail_id       Attachment ID for the default featured image.
 * @param array $thumbnail_features Enabled featured image option slugs.
 */
function save_thumbnail_settings( $thumbnail_id = 0, $thumbnail_features = array() ) {
	global $quevedo_settings, $quevedo_thumbnail_features_array;
	read_settings();

	if ( null === $thumbnail_features ) {
		$thumbnail_features = array();
	}

	$thumbnail_id       = intval( $thumbnail_id );
	$valid_features     = array_keys( $quevedo_thumbnail_features_array );
	$thumbnail_features = array_intersect( (array) $thumbnail_features, $valid_features );

	if ( count( $thumbnail_features ) > 0 ) {
		$num_features = count( $thumbnail_features );
		for ( $i = 0; $i < $num_features; $i++ ) {
			$thumbnail_features[ $i ] = sanitize_text_field( $thumbnail_features[ $i ] );
		}
	}

	$thumbnail_changed = false;
	$features_changed  = ! is_equal_array( $quevedo_settings['thumbnail_features'], $thumbnail_features );

	if ( 0 !== $thumbnail_id ) {
		if ( $thumbnail_id !== $quevedo_settings['thumbnail'] ) {
			$thumbnail_changed = true;
		}
	} elseif ( 0 !== $quevedo_settings['thumbnail'] ) {
		$thumbnail_changed = true;
	}

	if ( ! $thumbnail_changed && ! $features_changed ) {
		save_no_changes_notice();
		return true;
	}

	$save_failed = false;

	if ( $thumbnail_changed ) {
		if ( 0 !== $thumbnail_id ) {
			if ( ! update_option( 'quevedo_thumbnail', $thumbnail_id ) ) {
				$save_failed = true;
			} else {
				$quevedo_settings['thumbnail'] = $thumbnail_id;
			}
		} elseif ( ! delete_option( 'quevedo_thumbnail' ) ) {
			$save_failed = true;
		} else {
			$quevedo_settings['thumbnail'] = 0;
		}
	}

	if ( $features_changed && ! $save_failed ) {
		if ( count( $thumbnail_features ) > 0 ) {
			if ( ! update_option( 'quevedo_thumbnail_features', $thumbnail_features ) ) {
				$save_failed = true;
			} else {
				$quevedo_settings['thumbnail_features'] = $thumbnail_features;
			}
		} elseif ( ! delete_option( 'quevedo_thumbnail_features' ) ) {
			$save_failed = true;
		} else {
			$quevedo_settings['thumbnail_features'] = array();
		}
	}

	if ( $save_failed ) {
		save_error_notice();
		return false;
	}

	save_success_notice();
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
