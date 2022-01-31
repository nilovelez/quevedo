<?php
/**
 * Plugin modules:
 * disable_tags
 * disable_author_archives

 * @package WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable post tags.
if ( in_array( 'disable_tags', $quevedo_settings['features'], true ) ) {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

// Disable author_archives.
if ( in_array( 'disable_author_archives', $quevedo_settings['features'], true ) ) {
	remove_filter( 'template_redirect', 'redirect_canonical' );
	add_action(
		'template_redirect',
		function() {
			if ( is_author() ) {
				wp_safe_redirect( home_url(), 301 );
				exit();
			} else {
				redirect_canonical();
			}
		}
	);
	add_filter(
		'author_link',
		function() {
			return home_url();
		},
		99
	);
	add_filter( 'the_author_posts_link', '__return_empty_string', 99 );
}

// Disable post formats.
if ( in_array( 'disable_formats', $quevedo_settings['features'], true ) ) {
	add_action(
		'after_setup_theme',
		function() {
			remove_theme_support( 'post-formats' );
		},
		100
	);
}

function default_post_metadata__thumbnail_id( $value, $object_id, $meta_key, $single, $meta_type ) {

	if ( '_thumbnail_id' !== $meta_key ) {
		return $value;
	}
	// Pillo el CPT de $object_id .
	$post_type = get_post_type( $object_id );
	if ( 'post' !== $post_type ) {
		return $value;
	}
	$quevedo_thumbnail_id = intval( get_option( 'quevedo_thumbnail', 0 ) );
	if ( 0 !== $quevedo_thumbnail_id ) {
		$thumbnail_post_type = get_post_type( $quevedo_thumbnail_id );
		if ( 'attachment' === $thumbnail_post_type ) {
			return $quevedo_thumbnail_id;
		}
	}
	return $value;
}
add_filter( 'default_post_metadata', __NAMESPACE__ . '\default_post_metadata__thumbnail_id', 10, 5 );
