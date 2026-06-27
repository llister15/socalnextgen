<?php
/**
 * WP_Rig\WP_Rig\Plugin_Dependencies Component
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Plugin_Dependencies;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function admin_url;
use function current_user_can;
use function esc_html__;
use function esc_url;
use function is_admin;
use function is_plugin_active;

/**
 * Class for Plugin Dependencies component.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'plugin-dependencies';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'admin_notices', array( $this, 'action_admin_notices' ) );
	}

	/**
	 * Shows required plugin notices.
	 */
	public function action_admin_notices() {
		if ( ! is_admin() || ! current_user_can( 'activate_plugins' ) || $this->is_events_calendar_active() ) {
			return;
		}

		$plugin_search_url = admin_url( 'plugin-install.php?s=The+Events+Calendar&tab=search&type=term' );

		?>
		<div class="notice notice-error">
			<p>
				<strong><?php esc_html_e( 'SoCalNextGen requires The Events Calendar.', 'socalnextgen' ); ?></strong>
				<?php esc_html_e( 'Install and activate it to manage the event calendar experience from WordPress.', 'socalnextgen' ); ?>
				<a href="<?php echo esc_url( $plugin_search_url ); ?>"><?php esc_html_e( 'Install The Events Calendar', 'socalnextgen' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Checks whether The Events Calendar is active.
	 *
	 * @return bool
	 */
	private function is_events_calendar_active(): bool {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) || post_type_exists( 'tribe_events' );
	}
}
