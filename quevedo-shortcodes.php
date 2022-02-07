<?php
/**
 * Quevedo shortcodes definition

 * @package WordPress
 * @subpackage Quevedo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Shortcode to return Lorem ipsum blocks
 * [lorem words="100"]
 *
 * @param array $atts only accepted param is (int) words (number of word to output).
 * min 1, max 2000, default 100.
 * @return string shortcode HTML output.
 */
function quevedo_lipsum_function( $atts ) {
	$default_words = 200;
	$max_words     = 2000;

	$lipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam justo odio, interdum sit amet egestas venenatis, tempor id erat. Cras lacus libero, lobortis ut posuere vel, vestibulum sit amet massa. Maecenas ac nulla eget arcu vehicula gravida aliquet a leo. Quisque dignissim velit ac nibh dictum convallis. Ut nec quam et nunc ultricies tempor ac at ligula. Mauris non condimentum libero. Ut odio leo, vehicula ut pharetra sed, imperdiet eu enim. Cras commodo, ex sit amet malesuada fringilla, ligula arcu vulputate erat, eu dapibus odio nisl non purus. Nulla rhoncus mi sed purus laoreet, quis congue velit consequat. Curabitur dui sapien, laoreet sed tellus ut, vehicula scelerisque ipsum. Ut tincidunt volutpat nibh. Aenean turpis leo, congue at quam vitae, maximus rutrum lorem. Donec viverra, velit et mollis sollicitudin, diam nulla blandit nisl, vel molestie ipsum libero nec ipsum. Fusce ultrices mi nisi, a dignissim elit pulvinar a. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras eget tellus ut orci convallis semper. Nam accumsan leo et mi convallis, non rutrum urna lacinia. Aliquam erat volutpat. Duis ullamcorper libero eget nisl aliquam, eget elementum nulla tincidunt. Morbi pellentesque arcu vestibulum suscipit dignissim. Phasellus ut pretium ipsum. Quisque vitae dui massa. Aliquam in orci ac dui pulvinar volutpat. In pellentesque ultricies ultrices. Donec lacus velit, vulputate in eros eget, condimentum lobortis lacus. Integer ut ultrices massa, ut vehicula risus. Aliquam vitae iaculis mauris. Maecenas ultrices velit dapibus aliquam efficitur. Sed eu venenatis augue. Pellentesque nisi nisi, rhoncus sit amet ex a, dictum tempor mauris. Nullam vulputate massa sapien, in consequat leo sagittis at. Donec quis nibh nunc. Maecenas vitae nibh nec erat tempus rutrum. Ut tincidunt scelerisque massa, sed interdum justo malesuada in. In varius ex quis tempor iaculis. Phasellus id leo convallis, rhoncus sapien non, volutpat odio. Curabitur ac auctor metus. Vivamus ex nulla, vulputate in aliquet sed, efficitur sit amet magna. Vivamus accumsan mauris eget lacinia ornare. Vivamus vel viverra libero. Sed dapibus ornare volutpat. Nulla ornare purus ac convallis vehicula. Sed porta at tellus ut sollicitudin. Cras nec ligula finibus, suscipit sem et, cursus risus. Ut sodales elit sit amet sem ullamcorper, in posuere diam malesuada. Vivamus pharetra lacus a ornare volutpat. Mauris eu ex tellus. Aliquam augue ante, pellentesque a accumsan et, fringilla vitae nibh. Nullam gravida eros sed lacinia sodales. Curabitur lobortis quis ante id auctor. Cras vel ligula tincidunt neque tincidunt interdum vel vitae elit. In at tempor nulla, mollis tempor magna. Phasellus sem nibh, vestibulum vitae tristique non, imperdiet eget metus. Proin id odio est. Vivamus et lobortis diam, vitae euismod nunc. Etiam tincidunt libero lectus, eget elementum nisl porta eu. Donec sagittis mauris non libero vehicula cursus. Sed luctus, enim a vulputate mattis, elit sem sagittis dui, at porta elit arcu at neque. Curabitur porttitor volutpat massa, lobortis placerat purus auctor id. Aliquam molestie elit suscipit lacus commodo, ut commodo augue pharetra. Nullam suscipit ex tortor, at luctus purus laoreet auctor. Quisque tincidunt dolor odio, quis lobortis massa dictum. ';

	$a = shortcode_atts(
		array(
			'words' => $default_words,
		),
		$atts
	);

	$words = ( ! is_int( $a['words'] ) ) ? $a['words'] : $default_words;
	$words = min( $words, $max_words );

	$return = '';

	$full_pages = floor( $words / 500 );
	for ( $i = 0; $i < $full_pages; $i++ ) {
		$return .= $lipsum;
	}

	$remaining = $words % 500;
	if ( $remaining > 0 ) {
		$return .= implode( ' ', array_slice( explode( ' ', $lipsum ), 0, ( $words % 500 ) ) );
	}

	return $return;
}
add_shortcode( 'lipsum', 'quevedo_lipsum_function' );

/**
 * Shortcode to return current year in Y format
 * [year]
 */
add_shortcode(
	'year',
	function() {
		return gmdate( 'Y' );
	}
);
