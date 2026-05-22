<?php
/**
 * Plugin modules:
 * disable_tags
 * disable_author_archives
 * disable_date_archives

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

// Disable date archives.
if ( in_array( 'disable_date_archives', $quevedo_settings['features'], true ) ) {
	remove_filter( 'template_redirect', 'redirect_canonical' );
	add_action(
		'template_redirect',
		function() {
			if ( is_date() ) {
				wp_safe_redirect( home_url(), 301 );
				exit();
			} else {
				redirect_canonical();
			}
		}
	);
	foreach ( array( 'day_link', 'month_link', 'year_link' ) as $quevedo_date_link_filter ) {
		add_filter(
			$quevedo_date_link_filter,
			function() {
				return home_url();
			},
			99
		);
	}
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
	add_action(
		'admin_init',
		function() {
			remove_theme_support( 'post-formats' );
		}
	);
}

// Simplify editor blocks.
if ( in_array( 'simplify_editor_blocks', $quevedo_settings['features'], true ) ) {
	add_filter( 'allowed_block_types_all', function( $allowed_block_types, $editor_context ) {
		// Only apply to posts
		if ( isset( $editor_context->post ) && 'post' === $editor_context->post->post_type ) {
			return array(
				'core/paragraph',
				'core/heading',
				'core/list',
				'core/image',
				'core/quote',
				'core/separator',
				'core/code',
				'core/preformatted'
			);
		}
		return $allowed_block_types;
	}, 10, 2 );
}

// Redirect attachments.
if ( in_array( 'redirect_attachments', $quevedo_settings['features'], true ) ) {
	add_action(
		'template_redirect',
		function() {
			global $post;
			if (
				is_attachment() &&
				isset( $post->post_parent ) &&
				is_numeric( $post->post_parent ) &&
				( 0 !== $post->post_parent )
			) {
				wp_safe_redirect( get_permalink( $post->post_parent ), 301 );
				exit();
			}
		}
	);
}

function default_post_metadata__thumbnail_id( $value, $object_id, $meta_key, $single, $meta_type ) {
	global $quevedo_settings;
	
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

/**
 * Returns the attachment ID to use as a post featured image.
 *
 * Priority: default featured image, post featured image, none.
 *
 * @param int $post_id Post ID.
 * @return int Attachment ID or 0.
 */
function get_post_featured_image_attachment_id( $post_id ) {
	$post_id = intval( $post_id );
	if ( 0 === $post_id ) {
		return 0;
	}

	$default_thumbnail_id = intval( get_option( 'quevedo_thumbnail', 0 ) );
	if ( 0 !== $default_thumbnail_id && 'attachment' === get_post_type( $default_thumbnail_id ) ) {
		return $default_thumbnail_id;
	}

	$post_thumbnail_id = intval( get_post_meta( $post_id, '_thumbnail_id', true ) );
	if ( 0 !== $post_thumbnail_id && 'attachment' === get_post_type( $post_thumbnail_id ) ) {
		return $post_thumbnail_id;
	}

	return 0;
}

// Featured image Open Graph and Twitter metadata.
if ( in_array( 'featured_image_og_meta', $quevedo_settings['thumbnail_features'], true ) ) {
	add_action(
		'wp_head',
		function() {
			if ( ! is_singular( 'post' ) ) {
				return;
			}

			$attachment_id = get_post_featured_image_attachment_id( get_queried_object_id() );
			if ( 0 === $attachment_id ) {
				return;
			}

			$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
			if ( ! $image_url ) {
				return;
			}

			echo '<meta property="og:image" content="' . esc_url( $image_url ) . '" />' . "\n";
			echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '" />' . "\n";
		},
		5
	);
}
