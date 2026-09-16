<?php
/**
 * WP_Rig\WP_Rig\Youth_Groups Component.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Youth_Groups;

use WP_Post;
use WP_Rig\WP_Rig\Component_Interface;

/**
 * Registers and manages editor-owned youth group directory records.
 */
class Component implements Component_Interface {

	const POST_TYPE     = 'youth-group';
	const NONCE_ACTION  = 'scng_youth_group_meta';
	const NONCE_NAME    = 'scng_youth_group_nonce';
	const IMPORT_OPTION = 'scng_youth_group_import_version';

	/**
	 * Gets the component slug.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'youth-groups';
	}

	/**
	 * Adds WordPress hooks.
	 */
	public function initialize() {
		add_action( 'init', array( $this, 'action_register_post_type' ) );
		add_action( 'init', array( $this, 'action_register_meta' ) );
		add_action( 'add_meta_boxes', array( $this, 'action_add_meta_box' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'action_save_meta' ) );
		add_action( 'admin_init', array( $this, 'action_maybe_import_directory' ), 30 );
		add_action( 'after_switch_theme', array( $this, 'action_maybe_import_directory' ) );
	}

	/**
	 * Registers the Youth Groups content type.
	 */
	public function action_register_post_type(): void {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'               => esc_html__( 'Youth Groups', 'socalnextgen' ),
					'singular_name'      => esc_html__( 'Youth Group', 'socalnextgen' ),
					'add_new_item'       => esc_html__( 'Add New Youth Group', 'socalnextgen' ),
					'edit_item'          => esc_html__( 'Edit Youth Group', 'socalnextgen' ),
					'new_item'           => esc_html__( 'New Youth Group', 'socalnextgen' ),
					'view_item'          => esc_html__( 'View Youth Group', 'socalnextgen' ),
					'search_items'       => esc_html__( 'Search Youth Groups', 'socalnextgen' ),
					'not_found'          => esc_html__( 'No youth groups found.', 'socalnextgen' ),
					'not_found_in_trash' => esc_html__( 'No youth groups found in Trash.', 'socalnextgen' ),
					'all_items'          => esc_html__( 'All Youth Groups', 'socalnextgen' ),
					'archives'           => esc_html__( 'NextGen Locator', 'socalnextgen' ),
				),
				'public'       => true,
				'has_archive'  => 'nextgen-locator',
				'menu_icon'    => 'dashicons-location-alt',
				'rewrite'      => array( 'slug' => 'nextgen-locator' ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);
	}

	/**
	 * Registers directory metadata.
	 */
	public function action_register_meta(): void {
		foreach ( $this->get_fields() as $key => $field ) {
			register_post_meta(
				self::POST_TYPE,
				$key,
				array(
					'single'            => true,
					'type'              => 'boolean' === $field['type'] ? 'boolean' : 'string',
					'show_in_rest'      => true,
					'sanitize_callback' => $field['sanitize'],
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	/**
	 * Adds the directory details meta box.
	 */
	public function action_add_meta_box(): void {
		add_meta_box(
			'scng_youth_group_details',
			esc_html__( 'Youth Group Details', 'socalnextgen' ),
			array( $this, 'render_meta_box' ),
			self::POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Renders directory fields.
	 *
	 * @param WP_Post $post Current youth group.
	 */
	public function render_meta_box( WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
		echo '<div class="scng-youth-group-fields" style="display:grid;gap:16px;">';

		foreach ( $this->get_fields() as $key => $field ) {
			if ( str_starts_with( $key, '_scng_' ) ) {
				continue;
			}

			$value = get_post_meta( $post->ID, $key, true );
			echo '<p style="margin:0;">';

			if ( 'boolean' === $field['type'] ) {
				echo '<label><input name="' . esc_attr( $key ) . '" type="checkbox" value="1" ' . checked( (bool) $value, true, false ) . '> <strong>' . esc_html( $field['label'] ) . '</strong></label>';
			} else {
				echo '<label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><br>';
				echo '<input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['input'] ) . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:640px;">';
			}

			echo '</p>';
		}

		echo '</div>';
	}

	/**
	 * Saves directory fields.
	 *
	 * @param int $post_id Youth group post ID.
	 */
	public function action_save_meta( int $post_id ): void {
		if (
			! isset( $_POST[ self::NONCE_NAME ] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ||
			wp_is_post_autosave( $post_id ) ||
			wp_is_post_revision( $post_id ) ||
			! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		foreach ( $this->get_fields() as $key => $field ) {
			if ( str_starts_with( $key, '_scng_' ) ) {
				continue;
			}

			$value = $_POST[ $key ] ?? '';
			$value = 'boolean' === $field['type'] ? (bool) $value : call_user_func( $field['sanitize'], wp_unslash( $value ) );

			if ( '' === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	/**
	 * Imports the approved initial directory exactly once.
	 */
	public function action_maybe_import_directory(): void {
		if ( 1 <= (int) get_option( self::IMPORT_OPTION, 0 ) ) {
			return;
		}

		foreach ( $this->get_seed_records() as $record ) {
			$import_key = sanitize_title( $record['title'] );
			$existing   = get_posts(
				array(
					'post_type'      => self::POST_TYPE,
					'post_status'    => 'any',
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'meta_key'       => '_scng_import_key',
					'meta_value'     => $import_key,
				)
			);

			if ( $existing ) {
				continue;
			}

			$post_id = wp_insert_post(
				array(
					'post_type'    => self::POST_TYPE,
					'post_status'  => 'publish',
					'post_title'   => $record['title'],
					'post_excerpt' => $record['complete'] ? '' : __( 'Details coming soon.', 'socalnextgen' ),
				),
				true
			);

			if ( is_wp_error( $post_id ) ) {
				continue;
			}

			update_post_meta( $post_id, '_scng_import_key', $import_key );
			foreach ( $record as $key => $value ) {
				if ( in_array( $key, array( 'title', 'complete' ), true ) || '' === $value ) {
					continue;
				}
				update_post_meta( $post_id, 'scng_youth_group_' . $key, $value );
			}
			update_post_meta( $post_id, 'scng_youth_group_complete', (bool) $record['complete'] );
		}

		update_option( self::IMPORT_OPTION, 1 );
	}

	/**
	 * Returns field definitions.
	 *
	 * @return array<string,array<string,mixed>> Field definitions.
	 */
	private function get_fields(): array {
		return array(
			'scng_youth_group_pastors'  => array( 'label' => __( 'Lead Pastor(s)', 'socalnextgen' ), 'type' => 'string', 'input' => 'text', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_address'  => array( 'label' => __( 'Street Address', 'socalnextgen' ), 'type' => 'string', 'input' => 'text', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_city'     => array( 'label' => __( 'City', 'socalnextgen' ), 'type' => 'string', 'input' => 'text', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_state'    => array( 'label' => __( 'State', 'socalnextgen' ), 'type' => 'string', 'input' => 'text', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_zip'      => array( 'label' => __( 'ZIP Code', 'socalnextgen' ), 'type' => 'string', 'input' => 'text', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_phone'    => array( 'label' => __( 'Phone', 'socalnextgen' ), 'type' => 'string', 'input' => 'tel', 'sanitize' => 'sanitize_text_field' ),
			'scng_youth_group_website'  => array( 'label' => __( 'Website', 'socalnextgen' ), 'type' => 'string', 'input' => 'url', 'sanitize' => 'esc_url_raw' ),
			'scng_youth_group_complete' => array( 'label' => __( 'Details complete', 'socalnextgen' ), 'type' => 'boolean', 'input' => 'checkbox', 'sanitize' => 'rest_sanitize_boolean' ),
			'_scng_import_key'           => array( 'label' => '', 'type' => 'string', 'input' => 'hidden', 'sanitize' => 'sanitize_key' ),
		);
	}

	/**
	 * Returns approved initial directory records.
	 *
	 * @return array<int,array<string,mixed>> Directory records.
	 */
	private function get_seed_records(): array {
		return array(
			array( 'title' => 'CORONA SAOG', 'pastors' => 'Ioane & Rose Gauta', 'address' => '804 S Lincoln Ave', 'city' => 'Corona', 'state' => 'CA', 'zip' => '92882', 'phone' => '(714) 900-9700', 'website' => '', 'complete' => true ),
			array( 'title' => 'FAITH FELLOWSHIP AG', 'pastors' => 'Samasoni & Fulu’ula Sagale', 'address' => '3629 Atlantic Ave', 'city' => 'Long Beach', 'state' => 'CA', 'zip' => '90807', 'phone' => '(562) 335-8151', 'website' => '', 'complete' => true ),
			array( 'title' => 'FIRST SAMOAN KILLEEN AG', 'pastors' => 'Larry & Lillian Anoai', 'address' => '1601 N 8th Street', 'city' => 'Killeen', 'state' => 'TX', 'zip' => '76540', 'phone' => '(808) 450-8131', 'website' => '', 'complete' => true ),
			array( 'title' => 'FIRST SAMOAN ONTARIO AG', 'pastors' => 'Albert & Rebecca Fruean', 'address' => '931 South Bon View', 'city' => 'Ontario', 'state' => 'CA', 'zip' => '91761', 'phone' => '(909) 456-0239', 'website' => '', 'complete' => true ),
			array( 'title' => 'FIRST SAMOAN SAN BERNADINO', 'pastors' => 'Tumua & Shanna Sialoi', 'address' => '895 W 40th Street', 'city' => 'San Bernardino', 'state' => 'CA', 'zip' => '92407', 'phone' => '(760) 936-2014', 'website' => '', 'complete' => true ),
			array( 'title' => 'FIRST SAMOAN VISTA AG', 'pastors' => 'David & Lisa Mamea', 'address' => '1130 E Taylor Street', 'city' => 'Vista', 'state' => 'CA', 'zip' => '92084', 'phone' => '(808) 291-6341', 'website' => '', 'complete' => true ),
			array( 'title' => 'GARDEN GROVE SAOG', 'pastors' => 'Faasaoina & Maggievei Opeta', 'address' => '13171 Century Blvd', 'city' => 'Garden Grove', 'state' => 'CA', 'zip' => '92843', 'phone' => '(714) 590-7915', 'website' => '', 'complete' => true ),
			array( 'title' => 'GRACEWAY KINGDOM WORSHIP SAOG - Las Vegas', 'pastors' => 'Simaualuga & Mareta Tuimaualuga', 'address' => '5401 W Oakley Blvd', 'city' => 'Las Vegas', 'state' => 'NV', 'zip' => '89146', 'phone' => '(909) 739-0508', 'website' => '', 'complete' => true ),
			array( 'title' => 'LIFELINE AOG', 'pastors' => 'Jerry & Toliu Tua', 'address' => '7000 Edgemere Blvd', 'city' => 'El Paso', 'state' => 'TX', 'zip' => '79925', 'phone' => '(808) 291-6341', 'website' => '', 'complete' => true ),
			array( 'title' => 'LONG BEACH NEW LIFE FELLOWSHIP', 'pastors' => 'Afeleti & Rachael Pedro', 'address' => '4684 Long Beach Blvd', 'city' => 'Long Beach', 'state' => 'CA', 'zip' => '90805', 'phone' => '', 'website' => '', 'complete' => true ),
			array( 'title' => 'MORENO VALLEY SAOG', 'pastors' => 'Pesaleli & Meki Logovii', 'address' => '12880 Heacock St', 'city' => 'Moreno Valley', 'state' => 'CA', 'zip' => '92553', 'phone' => '(657) 262-4447', 'website' => '', 'complete' => true ),
			array( 'title' => 'NEW LIFE CHRISTIAN CHURCH IN CERRITOS', 'pastors' => 'Iasoni Ma’a Se’ei', 'address' => '17409 Woodruff Ave', 'city' => 'Bellflower', 'state' => 'CA', 'zip' => '90706', 'phone' => '', 'website' => '', 'complete' => true ),
			array( 'title' => 'NEW LIFE SAOG - Oxnard', 'pastors' => 'Tomi & Mauelua Asoau', 'address' => '800 Hobson Way', 'city' => 'Oxnard', 'state' => 'CA', 'zip' => '93030', 'phone' => '(619) 991-1439', 'website' => '', 'complete' => true ),
			array( 'title' => 'REVIVED INTERNATIONAL MINISTRY SAOG', 'pastors' => 'Taima Keila', 'address' => '1660 S Street', 'city' => 'Bakersfield', 'state' => 'CA', 'zip' => '93301', 'phone' => '(661) 748-9298', 'website' => '', 'complete' => true ),
			array( 'title' => 'RIVER OF LIFE SAOG - 29 Palms', 'pastors' => 'Tuaoloina & Jacinta Saunoa', 'address' => '73331 Sullivan Rd', 'city' => 'Twentynine Palms', 'state' => 'CA', 'zip' => '92277', 'phone' => '(760) 694-3073', 'website' => 'https://www.rol29palms.com', 'complete' => true ),
			array( 'title' => 'STAND IN FAITH - Las Vegas', 'pastors' => '', 'address' => '', 'city' => 'Las Vegas', 'state' => 'NV', 'zip' => '', 'phone' => '', 'website' => '', 'complete' => false ),
			array( 'title' => 'SAN DIEGO FIRST SAOG', 'pastors' => 'Logotasi & Fofoainu’uese Uini', 'address' => '8404 Phyllis Place', 'city' => 'San Diego', 'state' => 'CA', 'zip' => '92123', 'phone' => '(714) 561-0909', 'website' => '', 'complete' => true ),
			array( 'title' => 'SON-RISE OUTREACH MINISTRIES - Indiana', 'pastors' => 'Iata & Isadora Ugaitafa', 'address' => '308 N Emerson Ave', 'city' => 'Indianapolis', 'state' => 'IN', 'zip' => '46219', 'phone' => '(562) 507-4559', 'website' => '', 'complete' => true ),
			array( 'title' => 'VICTORVILLE FIRST SAOG', 'pastors' => 'Mark Malepeai', 'address' => '14933 Wakita Blvd', 'city' => 'Apple Valley', 'state' => 'CA', 'zip' => '92306', 'phone' => '', 'website' => '', 'complete' => true ),
			array( 'title' => 'LEMON GROVE - San Diego', 'pastors' => '', 'address' => '', 'city' => 'San Diego', 'state' => 'CA', 'zip' => '', 'phone' => '', 'website' => '', 'complete' => false ),
			array( 'title' => 'NEW MANNA PENTECOSTAL SAOG - Arizona', 'pastors' => '', 'address' => '', 'city' => '', 'state' => 'AZ', 'zip' => '', 'phone' => '', 'website' => '', 'complete' => false ),
		);
	}
}
