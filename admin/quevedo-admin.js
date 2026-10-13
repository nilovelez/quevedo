/* global jQuery, wp, quevedoAdmin */

/**
 * Quevedo settings page: default featured image picker.
 */
jQuery( document ).ready( function( $ ) {
	var file_frame;
	var wp_media_post_id = wp.media.view.settings.post.id;
	var default_thumbnail = quevedoAdmin.defaultThumbnail;

	function quevedoRestoreMediaPostId() {
		wp.media.view.settings.post.id = wp_media_post_id;
		wp.media.model.settings.post.id = wp_media_post_id;
	}

	function quevedoPrepareMediaUploader( frame ) {
		wp.media.view.settings.post.id = 0;
		wp.media.model.settings.post.id = 0;

		if ( ! frame || ! frame.uploader || ! frame.uploader.uploader || ! frame.uploader.uploader.uploader ) {
			return;
		}

		delete frame.uploader.uploader.uploader.settings.multipart_params.post_id;
	}

	jQuery( '#quevedo_thumbnail_preview' ).on( 'click', function( event ) {
		event.preventDefault();

		if ( file_frame ) {
			quevedoPrepareMediaUploader( file_frame );
			file_frame.open();
			return;
		}

		file_frame = wp.media( {
			title: quevedoAdmin.selectImageTitle,
			button: {
				text: quevedoAdmin.selectImageButton,
			},
			library: {
				type: 'image',
			},
			multiple: false,
		} );

		file_frame.on( 'open', function() {
			quevedoPrepareMediaUploader( file_frame );

			if ( file_frame.uploader && file_frame.uploader.uploader ) {
				$( file_frame.uploader.uploader ).off( 'uploader:ready.quevedo' ).on( 'uploader:ready.quevedo', function() {
					quevedoPrepareMediaUploader( file_frame );
				} );
			}
		} );

		file_frame.on( 'select', function() {
			var attachment = file_frame.state().get( 'selection' ).first().toJSON();

			$( '#quevedo_thumbnail_preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
			$( '#quevedo_thumbnail_id' ).val( attachment.id );
			$( '#quevedo_remove_image_button' ).prop( 'disabled', false );

			quevedoRestoreMediaPostId();
		} );

		file_frame.on( 'close', function() {
			quevedoRestoreMediaPostId();
		} );

		quevedoPrepareMediaUploader( file_frame );
		file_frame.open();
	} );

	jQuery( '#quevedo_remove_image_button' ).on( 'click', function() {
		$( '#quevedo_thumbnail_id' ).val( '0' );
		$( '#quevedo_thumbnail_preview' ).attr( 'src', default_thumbnail );
		$( this ).prop( 'disabled', true );
	} );
} );
