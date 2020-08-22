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
if ( in_array( 'disable_tags', $quevedo_settings, true ) ) {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

// Disable author_archives.
if ( in_array( 'disable_author_archives', $quevedo_settings, true ) ) {
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
if ( in_array( 'disable_formats', $quevedo_settings, true ) ) {
	add_action(
		'after_setup_theme',
		function() {
			remove_theme_support( 'post-formats' );
		},
		100
	);
}
