<?php
/**
 * Configuration screen contents

 * @package WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quevedo_default_thumbnail = plugin_dir_url( __FILE__ ) . 'img/no-image.svg';
if ( 0 === $quevedo_settings['thumbnail'] ) {
	$quevedo_current_thumbnail = $quevedo_default_thumbnail;
} else {
	$quevedo_current_thumbnail = wp_get_attachment_url( $quevedo_settings['thumbnail'] );
	if ( ! $quevedo_current_thumbnail ) {
		$quevedo_current_thumbnail = $quevedo_default_thumbnail;
	}
}

?>
<div class="wrap" style="max-width: 1000px;">


<div id="quevedo-header">

	<h1><?php esc_html_e( 'Quevedo writer tools', 'quevedo' ); ?></h1>

	<p><?php esc_html_e( 'WordPress was born as a small blogging tool. Over the years it has grown and now serves for many more things, but deep down there is still a lot of that little blogging tool.', 'quevedo' ); ?></p>
	<p><?php esc_html_e( 'Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.', 'quevedo' ); ?></p>

	</div>

<div>

	<hr class="wp-header-end">


	<div class="feature-section">
		<div id="quevedo-features" class="quevedo-settings-card">

			<div class="quevedo-settings-card-header">
				<h2><?php esc_html_e( 'WordPress features', 'quevedo' ); ?></h2>
				<p class="quevedo-settings-card-subtitle"><?php esc_html_e( 'Some minor theaks to make WordPress a bit more appealing to bloggers and single-user site owners.', 'quevedo' ); ?></p>
			</div>
			<div class="quevedo-settings-card-body">
				<form id="quevedo-features-form" action="" method="POST">
					<input type="hidden" name="quevedo_features_saved" value="true">
					<?php wp_nonce_field( 'quevedo-features-save' ); ?>

					<table class="form-table" id="quevedo-table">

					<tbody>
					<?php foreach ( $quevedo_features_array as $quevedo_feature_slug => $quevedo_feature ) { ?>
						<tr>
						<td class="check-column">
							<fieldset>
								<legend class="screen-reader-text"><span><?php echo esc_html( $quevedo_feature['title'] ); ?></span></legend>
								<label class="switch">
									<input type="checkbox" name="featureEnabled[]" value="<?php echo esc_attr( $quevedo_feature_slug ); ?>" id="<?php echo esc_attr( $quevedo_feature_slug ); ?>_fld" <?php checked( true, in_array( $quevedo_feature_slug, $quevedo_settings['features'], true ), true ); ?>>
									<span class="slider round"></span>
								</label>
							</fieldset>
						</td><td>
							<strong><?php echo esc_html( $quevedo_feature['title'] ); ?></strong><br><?php echo esc_html( $quevedo_feature['description'] ); ?>
						</td></tr>

					<?php } ?>

					</tbody>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>

		<div id="quevedo-images" class="quevedo-settings-card">
			<div class="quevedo-settings-card-header">
				<h2><?php esc_html_e( 'Featured image', 'quevedo' ); ?></h2>
				<p class="quevedo-settings-card-subtitle"><?php esc_html_e( 'Options for featured images on your posts.', 'quevedo' ); ?></p>
			</div>

			<div class="quevedo-settings-card-body">

			<form id="quevedo-thumbnail-form" action="" method="POST">
				<input type="hidden" name="quevedo_thumbnail_saved" value="true">
				<?php wp_nonce_field( 'quevedo-thumbnail-save' ); ?>

				<div class="quevedo-settings-subsection">
					<h3><?php esc_html_e( 'Default featured image', 'quevedo' ); ?></h3>
					<p class="quevedo-settings-subsection-description"><?php esc_html_e( 'Select a fallback image for posts that do not have a featured image set.', 'quevedo' ); ?></p>

					<input type="hidden" name="quevedo_thumbnail_id" id="quevedo_thumbnail_id" value="<?php echo esc_attr( $quevedo_settings['thumbnail'] ); ?>">

					<div class="quevedo-image-preview-wrapper">
						<img id="quevedo_thumbnail_preview" src="<?php echo esc_url( $quevedo_current_thumbnail ); ?>" alt="<?php esc_attr_e( 'Select image', 'quevedo' ); ?>">
					</div>

					<p>
						<input id="quevedo_remove_image_button" type="button" class="button" value="<?php esc_attr_e( 'Remove image', 'quevedo' ); ?>" <?php disabled( 0 === $quevedo_settings['thumbnail'] ); ?> >
					</p>
				</div>

				<div class="quevedo-settings-subsection">
					<h3><?php esc_html_e( 'Featured image options', 'quevedo' ); ?></h3>

					<table class="form-table" id="quevedo-thumbnail-table">
					<tbody>
					<?php foreach ( $quevedo_thumbnail_features_array as $quevedo_thumbnail_feature_slug => $quevedo_thumbnail_feature ) { ?>
						<tr>
						<td class="check-column">
							<fieldset>
								<legend class="screen-reader-text"><span><?php echo esc_html( $quevedo_thumbnail_feature['title'] ); ?></span></legend>
								<label class="switch">
									<input type="checkbox" name="thumbnailFeatureEnabled[]" value="<?php echo esc_attr( $quevedo_thumbnail_feature_slug ); ?>" id="<?php echo esc_attr( $quevedo_thumbnail_feature_slug ); ?>_fld" <?php checked( true, in_array( $quevedo_thumbnail_feature_slug, $quevedo_settings['thumbnail_features'], true ), true ); ?>>
									<span class="slider round"></span>
								</label>
							</fieldset>
						</td><td>
							<strong><?php echo esc_html( $quevedo_thumbnail_feature['title'] ); ?></strong><br><?php echo esc_html( $quevedo_thumbnail_feature['description'] ); ?>
						</td></tr>
					<?php } ?>
					</tbody>
					</table>
				</div>

				<?php submit_button(); ?>
			</form>
			</div>
		</div>

		<div id="quevedo-shortcodes" class="quevedo-settings-card">
			<div class="quevedo-settings-card-header">
				<h2><?php esc_html_e( 'Shortcodes', 'quevedo' ); ?></h2>
			</div>
			<div class="quevedo-settings-card-body">
				<dl id="quevedo-shortcode-list">
					<dt>[year]</dt>
					<dd><?php esc_html_e( 'Returns the current year in four-digit format. Very useful for copyright notices.', 'quevedo' ); ?></dd>
					<dt>[lipsum words="200"]</dt>
					<dd><?php esc_html_e( 'Returns a paragraph full of "Lorem ipsum" fill text. The optional attribute "words" defines the number of words, default is 200.', 'quevedo' ); ?></dd>
				</dl>
			</div>
		</div>


	</div>

</div>
