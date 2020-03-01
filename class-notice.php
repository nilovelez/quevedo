<?php
/**
 * Dashboard notices

 * @package WordPress
 * @subpackage Quevedo
 */

namespace quevedo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Displays standar WordPress notices.
 */
class Notice {


	/**
	 * Displays standar WordPress dashboard notice.
	 *
	 * @param string $message     Message to display.
	 * @param string $level       Can be error, warning, info or success.
	 * @param bool   $dismissible determines if the notice can be dismissed via javascript.
	 */
	public function __construct( $message, $level = 'info', $dismissible = true ) {

		$this->notice_message = $message;

		if ( ! in_array( $level, array( 'error', 'warning', 'info', 'success' ), true ) ) {
			$level = 'info';
		}
		$this->notice_class = 'notice notice-' . $level;
		if ( $dismissible ) {
			$this->notice_class .= ' is-dismissible';
		}

		add_action( 'admin_notices', array( $this, 'display_notice' ) );
	}
	/**
	 * Callback function for the admin_notices action in the notice() function.
	 */
	public function display_notice() {
		if ( ! empty( $this->notice_message ) ) {
			?>
		<div class="<?php echo esc_html( $this->notice_class ); ?>">
			<p><?php echo esc_html( $this->notice_message ); ?></p>
		</div>
			<?php
		}
	}
}
/**
 * Displays a generic 'Options saved!' success notice
 */
function save_success_notice() {
	new Notice( __( 'Options saved!', 'quevedo' ), 'success' );
}
/**
 * Displays a generic save error notice
 */
function save_error_notice() {
	new Notice( __( 'Error saving configuration to database.', 'quevedo' ), 'error' );
}
/**
 * Displays a generic 'No changes were needed.' info notice
 */
function save_no_changes_notice() {
	new Notice( __( 'No changes were needed.', 'quevedo' ), 'info' );
}
