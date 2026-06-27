<?php
/**
 * WP_Rig\WP_Rig\Weekly_Services Component
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Weekly_Services;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Post;
use function add_action;
use function add_meta_box;
use function checked;
use function current_user_can;
use function delete_post_meta;
use function esc_attr;
use function esc_html;
use function esc_html__;
use function esc_textarea;
use function esc_url_raw;
use function get_post_meta;
use function register_post_meta;
use function register_post_type;
use function selected;
use function sanitize_text_field;
use function update_post_meta;
use function wp_is_post_autosave;
use function wp_is_post_revision;
use function wp_kses_post;
use function wp_nonce_field;
use function wp_verify_nonce;
use function wp_unslash;

/**
 * Class for Weekly Services component.
 */
class Component implements Component_Interface {

	const POST_TYPE = 'weekly-service';
	const NONCE_ACTION = 'scng_weekly_service_meta';
	const NONCE_NAME = 'scng_weekly_service_nonce';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'weekly-services';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'init', array( $this, 'action_register_post_type' ) );
		add_action( 'init', array( $this, 'action_register_meta' ) );
		add_action( 'add_meta_boxes', array( $this, 'action_add_meta_boxes' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'action_save_meta' ) );
	}

	/**
	 * Registers the weekly services CPT.
	 */
	public function action_register_post_type() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'                  => esc_html__( 'Weekly Services', 'socalnextgen' ),
					'singular_name'         => esc_html__( 'Weekly Service', 'socalnextgen' ),
					'add_new_item'          => esc_html__( 'Add New Weekly Service', 'socalnextgen' ),
					'edit_item'             => esc_html__( 'Edit Weekly Service', 'socalnextgen' ),
					'new_item'              => esc_html__( 'New Weekly Service', 'socalnextgen' ),
					'view_item'             => esc_html__( 'View Weekly Service', 'socalnextgen' ),
					'search_items'          => esc_html__( 'Search Weekly Services', 'socalnextgen' ),
					'not_found'             => esc_html__( 'No weekly services found.', 'socalnextgen' ),
					'not_found_in_trash'    => esc_html__( 'No weekly services found in Trash.', 'socalnextgen' ),
					'all_items'             => esc_html__( 'All Weekly Services', 'socalnextgen' ),
					'archives'              => esc_html__( 'Weekly Service Archives', 'socalnextgen' ),
					'featured_image'        => esc_html__( 'Service Featured Image', 'socalnextgen' ),
					'set_featured_image'    => esc_html__( 'Set service featured image', 'socalnextgen' ),
					'remove_featured_image' => esc_html__( 'Remove service featured image', 'socalnextgen' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => 'dashicons-admin-home',
				'rewrite'      => array(
					'slug' => 'weekly-service',
				),
				'show_in_rest' => true,
				'supports'     => array(
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'revisions',
					'custom-fields',
				),
			)
		);
	}

	/**
	 * Registers known post meta for REST/custom field support.
	 */
	public function action_register_meta() {
		foreach ( $this->get_fields() as $field ) {
			register_post_meta(
				self::POST_TYPE,
				$field['key'],
				array(
					'single'        => true,
					'type'          => in_array( $field['type'], array( 'checkbox', 'number' ), true ) ? 'integer' : 'string',
					'show_in_rest'  => true,
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	/**
	 * Adds service meta boxes.
	 */
	public function action_add_meta_boxes() {
		foreach ( $this->get_meta_boxes() as $id => $box ) {
			add_meta_box( $id, $box['title'], array( $this, 'render_meta_box' ), self::POST_TYPE, 'normal', 'default', $box );
		}
	}

	/**
	 * Renders a meta box.
	 *
	 * @param WP_Post $post Post object.
	 * @param array   $box  Meta box data.
	 */
	public function render_meta_box( WP_Post $post, array $box ) {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );

		if ( ! empty( $box['args']['description'] ) ) {
			echo '<p>' . esc_html( $box['args']['description'] ) . '</p>';
		}

		echo '<div class="scng-service-fields" style="display:grid;gap:16px;">';
		foreach ( $box['args']['fields'] as $field ) {
			$this->render_field( $post, $field );
		}
		echo '</div>';
	}

	/**
	 * Saves service meta.
	 *
	 * @param int $post_id Post ID.
	 */
	public function action_save_meta( int $post_id ) {
		if ( ! isset( $_POST[ self::NONCE_NAME ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ) {
			return;
		}

		if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( $this->get_fields() as $field ) {
			$key   = $field['key'];
			$value = $_POST[ $key ] ?? '';

			if ( 'checkbox' === $field['type'] ) {
				$value = $value ? 1 : 0;
			} elseif ( 'textarea' === $field['type'] ) {
				$value = wp_kses_post( wp_unslash( $value ) );
			} elseif ( 'url' === $field['type'] ) {
				$value = esc_url_raw( wp_unslash( $value ) );
			} else {
				$value = sanitize_text_field( wp_unslash( $value ) );
			}

			if ( '' === $value || null === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	/**
	 * Renders a single field.
	 *
	 * @param WP_Post $post  Post object.
	 * @param array   $field Field config.
	 */
	private function render_field( WP_Post $post, array $field ) {
		$value = get_post_meta( $post->ID, $field['key'], true );

		if ( 'scng_service_active' === $field['key'] && '' === $value ) {
			$value = 1;
		}

		echo '<p style="margin:0;">';
		echo '<label for="' . esc_attr( $field['key'] ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><br>';

		switch ( $field['type'] ) {
			case 'textarea':
				echo '<textarea id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" rows="3" style="width:100%;">' . esc_textarea( $value ) . '</textarea>';
				break;
			case 'select':
				echo '<select id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" style="width:100%;max-width:420px;">';
				echo '<option value="">' . esc_html__( 'Select', 'socalnextgen' ) . '</option>';
				foreach ( $field['options'] as $option ) {
					echo '<option value="' . esc_attr( $option ) . '"' . selected( $value, $option, false ) . '>' . esc_html( $option ) . '</option>';
				}
				echo '</select>';
				break;
			case 'checkbox':
				echo '<label><input id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" type="checkbox" value="1" ' . checked( (int) $value, 1, false ) . '> ' . esc_html__( 'Yes', 'socalnextgen' ) . '</label>';
				break;
			default:
				echo '<input id="' . esc_attr( $field['key'] ) . '" name="' . esc_attr( $field['key'] ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:520px;">';
				break;
		}

		if ( ! empty( $field['help'] ) ) {
			echo '<br><span class="description">' . esc_html( $field['help'] ) . '</span>';
		}

		echo '</p>';
	}

	/**
	 * Gets meta box definitions.
	 *
	 * @return array
	 */
	private function get_meta_boxes(): array {
		return array(
			'scng_service_information' => array(
				'title'       => esc_html__( 'Service Information', 'socalnextgen' ),
				'description' => esc_html__( 'Use the Featured Image panel for the service image.', 'socalnextgen' ),
				'fields'      => array(
					$this->field( 'scng_service_name', esc_html__( 'Service Name', 'socalnextgen' ), 'text', array(), esc_html__( 'Example: Sunday Worship Experience', 'socalnextgen' ) ),
					$this->field( 'scng_service_short_description', esc_html__( 'Short Description', 'socalnextgen' ), 'textarea' ),
					$this->field( 'scng_service_type', esc_html__( 'Service Type', 'socalnextgen' ), 'select', array( 'Sunday Worship', 'Midweek Service', 'Prayer Service', 'Bible Study', 'Youth Service', "Children's Church", 'Worship Night', 'Other' ) ),
				),
			),
			'scng_service_schedule'    => array(
				'title'  => esc_html__( 'Schedule', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_day', esc_html__( 'Day of Week', 'socalnextgen' ), 'select', array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ) ),
					$this->field( 'scng_service_start_time', esc_html__( 'Start Time', 'socalnextgen' ), 'time' ),
					$this->field( 'scng_service_end_time', esc_html__( 'End Time', 'socalnextgen' ), 'time' ),
					$this->field( 'scng_service_time_display', esc_html__( 'Time Display Override', 'socalnextgen' ), 'text', array(), esc_html__( 'Example: 9:00 AM & 11:00 AM', 'socalnextgen' ) ),
				),
			),
			'scng_service_location'    => array(
				'title'  => esc_html__( 'Location', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_campus', esc_html__( 'Campus', 'socalnextgen' ) ),
					$this->field( 'scng_service_building', esc_html__( 'Building', 'socalnextgen' ) ),
					$this->field( 'scng_service_room', esc_html__( 'Room', 'socalnextgen' ) ),
					$this->field( 'scng_service_address', esc_html__( 'Address', 'socalnextgen' ), 'textarea' ),
					$this->field( 'scng_service_google_maps_url', esc_html__( 'Google Maps URL', 'socalnextgen' ), 'url' ),
				),
			),
			'scng_service_livestream'  => array(
				'title'  => esc_html__( 'Livestream', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_livestream_available', esc_html__( 'Livestream Available', 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_livestream_url', esc_html__( 'Livestream URL', 'socalnextgen' ), 'url' ),
					$this->field( 'scng_service_watch_button_text', esc_html__( 'Watch Button Text', 'socalnextgen' ), 'text', array(), esc_html__( 'Example: Watch Live', 'socalnextgen' ) ),
				),
			),
			'scng_service_pastor'      => array(
				'title'       => esc_html__( 'Pastor / Speaker', 'socalnextgen' ),
				'description' => esc_html__( 'Use a Media Library image URL for the pastor photo.', 'socalnextgen' ),
				'fields'      => array(
					$this->field( 'scng_service_pastor_name', esc_html__( 'Pastor Name', 'socalnextgen' ) ),
					$this->field( 'scng_service_pastor_title', esc_html__( 'Pastor Title', 'socalnextgen' ) ),
					$this->field( 'scng_service_pastor_photo', esc_html__( 'Pastor Photo URL', 'socalnextgen' ), 'url' ),
				),
			),
			'scng_service_ministry'    => array(
				'title'  => esc_html__( 'Ministry Information', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_childcare_available', esc_html__( 'Childcare Available', 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_children_ministry', esc_html__( "Children's Ministry", 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_youth_ministry', esc_html__( 'Youth Ministry', 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_asl_available', esc_html__( 'ASL Available', 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_spanish_translation', esc_html__( 'Spanish Translation', 'socalnextgen' ), 'checkbox' ),
				),
			),
			'scng_service_cta'         => array(
				'title'  => esc_html__( 'Call to Action', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_primary_button_text', esc_html__( 'Primary Button Text', 'socalnextgen' ), 'text', array(), esc_html__( 'Example: Plan Your Visit', 'socalnextgen' ) ),
					$this->field( 'scng_service_primary_button_link', esc_html__( 'Primary Button Link', 'socalnextgen' ), 'url' ),
					$this->field( 'scng_service_secondary_button_text', esc_html__( 'Secondary Button Text', 'socalnextgen' ), 'text', array(), esc_html__( 'Example: Watch Live', 'socalnextgen' ) ),
					$this->field( 'scng_service_secondary_button_link', esc_html__( 'Secondary Button Link', 'socalnextgen' ), 'url' ),
				),
			),
			'scng_service_display'     => array(
				'title'  => esc_html__( 'Display Settings', 'socalnextgen' ),
				'fields' => array(
					$this->field( 'scng_service_featured', esc_html__( 'Featured Service', 'socalnextgen' ), 'checkbox' ),
					$this->field( 'scng_service_display_order', esc_html__( 'Display Order', 'socalnextgen' ), 'number' ),
					$this->field( 'scng_service_active', esc_html__( 'Active', 'socalnextgen' ), 'checkbox' ),
				),
			),
		);
	}

	/**
	 * Gets flattened field list.
	 *
	 * @return array
	 */
	private function get_fields(): array {
		$fields = array();

		foreach ( $this->get_meta_boxes() as $box ) {
			$fields = array_merge( $fields, $box['fields'] );
		}

		return $fields;
	}

	/**
	 * Builds a field definition.
	 *
	 * @param string $key     Meta key.
	 * @param string $label   Field label.
	 * @param string $type    Field type.
	 * @param array  $options Select options.
	 * @param string $help    Help text.
	 * @return array
	 */
	private function field( string $key, string $label, string $type = 'text', array $options = array(), string $help = '' ): array {
		return compact( 'key', 'label', 'type', 'options', 'help' );
	}
}
