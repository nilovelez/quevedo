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
	margin-right: 15px !important;
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
	background-color: #2196F3;
}

#quevedo-table input:focus + .slider {
	box-shadow: 0 0 1px #2196F3;
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

#quevedo-shortcode-list {
	padding: 1em 1em 0;
	background-color: #fff;
	border: 1px solid #eee;
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

.tab-pane {
	display: none;
}
.tab-pane-active {
	display: block;
}
</style>


	<h1><?php esc_html_e( 'Quevedo writer tools', 'quevedo' ); ?></h1>
	<hr class="wp-header-end">

	<p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis rutrum suscipit mi, vitae blandit eros feugiat id. Vivamus fermentum sed ligula vitae venenatis. Nunc ut vestibulum turpis. Quisque vel felis elit. Integer luctus lorem non arcu sagittis commodo. Integer at maximus elit, ut egestas ligula.', 'quevedo' ); ?></p>

	<h2 class="nav-tab-wrapper" role="tablist">
		<a href="#quevedo-features" class="nav-tab nav-tab-active"><?php esc_html_e( 'WordPress features', 'quevedo' ); ?></a>
		<a href="#quevedo-images" class="nav-tab"><?php esc_html_e( 'Default images', 'quevedo' ); ?></a>
		<a href="#quevedo-shortcodes" class="nav-tab"><?php esc_html_e( 'Shortcodes', 'quevedo' ); ?></a>
	</h2>


	<div class="feature-section">

		<form id="quevedo-options" action="" method="POST">

			<div id="quevedo-shortcodes" class="tab-pane">

				<h2><?php esc_html_e( 'Shortcodes', 'quevedo' ); ?></h2>

				<dl id="quevedo-shortcode-list">
					<dt>[year]</dt>
					<dd><?php esc_html_e( 'Returns the current year in four-digit format. Very useful for copyright notices.', 'quevedo' ); ?></dd>
					<dt>[lorem words="200"]</dt>
					<dd><?php esc_html_e( 'Returns a paragraph full of "Lorem ipsum" fill text. The optional attribute "words" defines the number of words, default is 200.', 'quevedo' ); ?></dd>
				</dl>

			</div>

			<div id="quevedo-features" class="tab-pane tab-pane-active">

				<h2><?php esc_html_e( 'WordPress features', 'quevedo' ); ?></h2>

				<?php wp_nonce_field( 'quevedo_save_options' ); ?>

				<input type="hidden" name="quevedo-saved" value="true">


				<table class="form-table" id="quevedo-table">

				<tbody>
				<?php foreach ( $quevedo_options_array as $quevedo_option_slug => $quevedo_option ) { ?>
					<tr>
					<td><fieldset><legend class="screen-reader-text"><span><?php echo esc_html( $quevedo_option_slug ); ?></span></legend>

						<label class="switch">
							<input type="checkbox" name="optionEnabled[]" value="<?php echo esc_attr( $quevedo_option_slug ); ?>" id="<?php echo esc_attr( $quevedo_option_slug ); ?>_fld" <?php checked( true, in_array( $quevedo_option_slug, $quevedo_settings, true ), true ); ?>>
							<span class="slider round"></span>
						</label>
						<label for="<?php echo esc_attr( $quevedo_option_slug ); ?>_fld"><strong><?php echo esc_html( $quevedo_option['title'] ); ?></strong><br><?php echo esc_html( $quevedo_option['description'] ); ?></label>
					</fieldset></td></tr>

				<?php } ?>

				</tbody>
				</table>

			</div>

			<div id="quevedo-images" class="tab-pane">

				<h2><?php esc_html_e( 'Default images', 'quevedo' ); ?></h2>


				<table class="form-table">
				<tbody>

				<?php
				foreach ( $quevedo_cpts as $quevedo_cpt ) {
					$quevedo_cpt_field_id = 'quevedo_cpt_image_' . $quevedo_cpt->name;
					?>
				<tr>
					<th scope="row">
						<?php // Translators: Post type name, plural lowercase (ex: pages, posts). ?>
						<label for="<?php echo esc_attr( $quevedo_cpt_field_id ); ?>"><?php echo esc_html( sprintf( __( 'Defaut image for %s', 'quevedo' ), mb_strtolower( $quevedo_cpt->label ) ) ); ?></label>
					</th>
					<td>
						<input name="<?php echo esc_attr( $quevedo_cpt_field_id ); ?>" id="<?php echo esc_attr( $quevedo_cpt_field_id ); ?>" value="<?php echo esc_attr( $quevedo_cpt->name ); ?>" class="regular-text ltr" type="text">
						<?php // Translators: Post type name, plural lowercase (ex: pages, posts). ?>
						<p class="description"><?php echo esc_html( sprintf( __( 'Image id or URL, %s without a featured image will use this one.', 'quevedo' ), mb_strtolower( $quevedo_cpt->label ) ) ); ?></p>
					</td>
				</tr>

				<?php } ?>

				</tbody></table>



			</div>

			<?php submit_button(); ?>

		</form>

	</div>

</div>



<script>
/*
<a href="#quevedo-features" class="nav-tab nav-tab-active">
<div id="quevedo-features" class="tab-pane tab-pane-active">
*/
(function($){

	var active_quevedo_tab = 'quevedo-features';
	$('.nav-tab').click(function(e){
		e.preventDefault();

		if ($(this).attr('href') == active_quevedo_tab){
			return; // clicked already active tab
		}
		active_quevedo_tab = $(this).attr('href');

		$('.nav-tab').removeClass('nav-tab-active');
		$('.nav-tab[href="'+active_quevedo_tab+'"]').addClass('nav-tab-active');

		$('.tab-pane').removeClass('tab-pane-active');
		$(active_quevedo_tab).addClass('tab-pane-active');
	});

})(jQuery);
</script>

<script>
(function($){


	$('#quevedo-options .quevedo-table :checkbox').change(function() {
		// this will contain a reference to the checkbox
		console.log(this.id); 
		var checkBoxes = $("#quevedo-options .quevedo-table input[name=optionEnabled\\[\\]]");

		if (this.id == 'quevedo_checkall_fld'){
			if (this.checked) {
				checkBoxes.prop("checked", true);
			} else {
				checkBoxes.prop("checked", false);
				// the checkbox is now no longer checked
			}
		}else{
			var checkBoxes_checked = $("#quevedo-options .quevedo-table input[name=optionEnabled\\[\\]]:checked");
			if(checkBoxes_checked.length == checkBoxes.length){
				$('#quevedo_checkall_fld').prop("checked", true);
			}else{
				$('#quevedo_checkall_fld').prop("checked", false);
			}
		}
	});
})(jQuery);
</script>
