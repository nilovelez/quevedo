<?php
/**
 * Plugin features, loaded on init with the saved settings.

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

	// Hide the tags that posts already have, in themes and feeds.
	add_filter(
		'get_the_terms',
		function ( $terms, $post_id, $taxonomy ) {
			if ( 'post_tag' === $taxonomy ) {
				return array();
			}
			return $terms;
		},
		10,
		3
	);
	add_filter(
		'wp_tag_cloud',
		function ( $tag_cloud, $args ) {
			if ( in_array( 'post_tag', (array) $args['taxonomy'], true ) ) {
				return '';
			}
			return $tag_cloud;
		},
		10,
		2
	);
	add_filter(
		'wp_sitemaps_taxonomies',
		function ( $taxonomies ) {
			unset( $taxonomies['post_tag'] );
			return $taxonomies;
		}
	);
	add_filter(
		'tag_link',
		function () {
			return home_url();
		},
		99
	);
}

// Disable author archives.
if ( in_array( 'disable_author_archives', $quevedo_settings['features'], true ) ) {
	add_filter(
		'author_link',
		function () {
			return home_url();
		},
		99
	);
	add_filter( 'the_author_posts_link', '__return_empty_string', 99 );
}

// Disable date archives.
if ( in_array( 'disable_date_archives', $quevedo_settings['features'], true ) ) {
	foreach ( array( 'day_link', 'month_link', 'year_link' ) as $quevedo_date_link_filter ) {
		add_filter(
			$quevedo_date_link_filter,
			function () {
				return home_url();
			},
			99
		);
	}
}

// Redirect the disabled archives to the homepage. Priority 9 runs before
// redirect_canonical(), so there is only one redirect.
add_action(
	'template_redirect',
	function () {
		global $quevedo_settings;
		$features = $quevedo_settings['features'];

		$redirect = (
			( is_tag() && in_array( 'disable_tags', $features, true ) ) ||
			( is_author() && in_array( 'disable_author_archives', $features, true ) ) ||
			( is_date() && in_array( 'disable_date_archives', $features, true ) )
		);

		if ( $redirect ) {
			wp_safe_redirect( home_url(), 301 );
			exit();
		}
	},
	9
);

// Disable post formats.
// This file is loaded on init, after the theme has declared its features.
if ( in_array( 'disable_formats', $quevedo_settings['features'], true ) ) {
	remove_theme_support( 'post-formats' );
}

// Simplify editor blocks.
if ( in_array( 'simplify_editor_blocks', $quevedo_settings['features'], true ) ) {
	add_filter(
		'allowed_block_types_all',
		function ( $allowed_block_types, $editor_context ) {
			// Only apply to posts.
			if ( isset( $editor_context->post ) && 'post' === $editor_context->post->post_type ) {
				return array(
					'core/paragraph',
					'core/heading',
					'core/list',
					'core/list-item',
					'core/image',
					'core/quote',
					'core/separator',
					'core/code',
					'core/preformatted',
				);
			}
			return $allowed_block_types;
		},
		10,
		2
	);
}

// Disable attachment pages. WordPress then redirects them to the file, as it
// does by default on sites created with version 6.4 or later.
if ( in_array( 'redirect_attachments', $quevedo_settings['features'], true ) ) {
	add_filter( 'pre_option_wp_attachment_pages_enabled', '__return_zero' );
}

/**
 * Uses the default featured image for posts that don't have one.
 *
 * Callback for the post_thumbnail_id filter, so it only changes the image
 * that themes show. The post itself keeps no featured image, and the editor
 * (admin and REST API) shows it as it is.
 *
 * @param int|false    $thumbnail_id Post thumbnail ID, or false if the post has none.
 * @param WP_Post|null $post         Post object.
 * @return int|false Default featured image ID for posts without one, otherwise $thumbnail_id.
 */
function default_post_thumbnail_id( $thumbnail_id, $post ) {
	if ( $thumbnail_id || ! $post || 'post' !== $post->post_type ) {
		return $thumbnail_id;
	}
	if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $thumbnail_id;
	}

	$default_thumbnail_id = intval( get_option( 'quevedo_thumbnail', 0 ) );
	if ( 0 !== $default_thumbnail_id && 'attachment' === get_post_type( $default_thumbnail_id ) ) {
		return $default_thumbnail_id;
	}
	return $thumbnail_id;
}
add_filter( 'post_thumbnail_id', __NAMESPACE__ . '\default_post_thumbnail_id', 10, 2 );

/**
 * Returns the attachment ID to use as a post featured image.
 *
 * Priority: post featured image, default featured image, none.
 *
 * @param int $post_id Post ID.
 * @return int Attachment ID or 0.
 */
function get_post_featured_image_attachment_id( $post_id ) {
	$post_id = intval( $post_id );
	if ( 0 === $post_id ) {
		return 0;
	}

	$post_thumbnail_id = intval( get_post_meta( $post_id, '_thumbnail_id', true ) );
	if ( 0 !== $post_thumbnail_id && 'attachment' === get_post_type( $post_thumbnail_id ) ) {
		return $post_thumbnail_id;
	}

	$default_thumbnail_id = intval( get_option( 'quevedo_thumbnail', 0 ) );
	if ( 0 !== $default_thumbnail_id && 'attachment' === get_post_type( $default_thumbnail_id ) ) {
		return $default_thumbnail_id;
	}

	return 0;
}

// Featured image Open Graph and Twitter metadata.
if ( in_array( 'featured_image_og_meta', $quevedo_settings['thumbnail_features'], true ) ) {
	add_action(
		'wp_head',
		function () {
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
