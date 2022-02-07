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


<style>
/* The switch - the box around the slider */
#quevedo-table td {
	padding-top: 0;
}
#quevedo-table .switch {
	position: relative;
	display: inline-block;
	width: 60px;
	height: 34px;
}
#quevedo-table td {
	vertical-align: top;
}
#quevedo-table .check-column {
	padding-left: 0;
}

/* Hide default HTML checkbox */
#quevedo-table .switch input {display:none;}

/* The slider */
#quevedo-table .slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	-webkit-transition: .4s;
	transition: .4s;
}

#quevedo-table .slider:before {
	position: absolute;
	content: "";
	height: 26px;
	width: 26px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
}

#quevedo-table input:checked + .slider {
	background-color: #34a853;
}

#quevedo-table input:focus + .slider {
	box-shadow: 0 0 1px #34a853;
}

#quevedo-table input:checked + .slider:before {
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
}

/* Rounded sliders */
#quevedo-table .slider.round {
	border-radius: 34px;
}

#quevedo-table .slider.round:before {
	border-radius: 50%;
}

#quevedo-table .quevedo-table thead td.check-column {
	width: 60px;
}
#quevedo-table .quevedo-table tbody th.check-column {
	padding-top: 5px;
	padding-bottom: 5px;
	width: 60px;
}


.quevedo-settings-card {
	box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
	border-radius: 2px;
	background-color: #fff;
	margin-bottom: 24px;
}
.quevedo-settings-card-header {
	padding: 16px 24px;
	border-bottom: 1px solid rgba(0,0,0,0.1);
}
.quevedo-settings-card-subtitle {
	margin: 4px 0 0;
	color: #757575;
}
.quevedo-settings-card-header h2 {
	margin: 0;
}
.quevedo-settings-card-body {
	padding: 16px 24px 0;
}


#quevedo-shortcode-list {
	padding-bottom: 24px;
}
#quevedo-shortcode-list dt {
	font-family: monospace;
	font-weight: bold;
	font-size: 120%;
}
#quevedo-shortcode-list dd {
	margin-bottom: 1em;
	padding-left: 3em;
}

.quevedo-image-preview-wrapper {
	position: relative;
	width: auto;
}
#quevedo_thumbnail_preview {
	max-width: 100%;
	max-height: 200px;
	width: auto;
	cursor: pointer;
}
#quevedo_remove_image_button {

}
#quevedo-header {
	margin-bottom: 1em;
	position: relative;
	min-height: 128px;
	padding-right: 140px;
}
#quevedo-header:before {
	display: block;
	position: absolute;
	bottom: 0;
	right: 0;
	content: '';
	width: 128px;
	height: 128px;
	background: url('<?php echo esc_attr( plugin_dir_url( __FILE__ ) . 'img/icon-256x256.png' ); ?>') center center no-repeat;
	background-size: contain;
}

</style>


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
				<h2><?php esc_html_e( 'Default post image', 'quevedo' ); ?></h2>
			</div>

			<div class="quevedo-settings-card-body">

			<?php wp_enqueue_media(); ?>


			<form id="quevedo-thumbnail-form" action="" method="POST">
				<input type="hidden" name="quevedo_thumbnail_saved" value="true">
				<?php wp_nonce_field( 'quevedo-thumbnail-save' ); ?>

				<input type="hidden" name="quevedo_thumbnail_id" id="quevedo_thumbnail_id" value="<?php echo esc_attr( $quevedo_settings['thumbnail'] ); ?>">

				<div class="quevedo-image-preview-wrapper">
					<img id="quevedo_thumbnail_preview" src="<?php echo esc_attr( $quevedo_current_thumbnail ); ?>" alt="<?php esc_attr_e( 'Select image', 'quevedo' ); ?>">
				</div>

				<p class="submit">
					<input id="quevedo_remove_image_button" type="button" class="button" value="<?php esc_attr_e( 'Remove image', 'quevedo' ); ?>" <?php disabled( 0 === $quevedo_settings['thumbnail'] ); ?> >

					<?php submit_button( null, 'primary', 'submit', false ); ?>
				</p>
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

<script type='text/javascript'>

	jQuery( document ).ready( function( $ ) {



		// Uploading files
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = <?php echo intval( $quevedo_settings['thumbnail'] ); ?>; // Set this
		var default_thumbnail = '<?php echo esc_attr( $quevedo_default_thumbnail ); ?>';

		jQuery('#quevedo_thumbnail_preview').on('click', function( event ){

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				// Set the post ID to what we want
				file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
				// Open frame
				file_frame.open();
				return;
			} else {
				// Set the wp.media post id so the uploader grabs the ID we want when initialised
				wp.media.model.settings.post.id = set_to_post_id;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Select defaul image',
				button: {
					text: 'Use this image',
				},
				multiple: false	// Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();

				// Do something with attachment.id and/or attachment.url here
				$( '#quevedo_thumbnail_preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
				$( '#quevedo_thumbnail_id' ).val( attachment.id );
				$( '#quevedo_remove_image_button' ).removeAttr("disabled");


				// Restore the main post ID
				wp.media.model.settings.post.id = wp_media_post_id;
			});

			// Finally, open the modal
			file_frame.open();
		});
		jQuery('#quevedo_remove_image_button').on('click', function( event ){
			$( '#quevedo_thumbnail_id' ).val( '0' );
			$( '#quevedo_thumbnail_preview' ).attr( 'src', default_thumbnail );
			$(this).prop('disabled', true);
		});

		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});
	});
</script>
