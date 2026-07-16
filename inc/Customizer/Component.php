<?php
/**
 * WP_Rig\WP_Rig\Customizer\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Customizer;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Customize_Manager;

use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function bloginfo;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;

/**
 * Class for managing Customizer integration.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'customizer';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'customize_register', array( $this, 'action_customize_register' ) );
		add_action( 'customize_preview_init', array( $this, 'action_enqueue_customize_preview_js' ) );
	}

	/**
	 * Adds postMessage support for site title and description, plus a custom Theme Options section.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_customize_register( WP_Customize_Manager $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => function () {
						bloginfo( 'name' );
					},
				)
			);
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => function () {
						bloginfo( 'description' );
					},
				)
			);
		}

		$wp_customize->add_panel(
			'scng_theme_options',
			array(
				'title'       => __( 'SocalNextGen Theme Options', 'socalnextgen' ),
				'description' => __( 'Manage homepage images and sponsor content.', 'socalnextgen' ),
				'priority'    => 130,
			)
		);

		$this->add_hero_controls( $wp_customize );
		$this->add_community_controls( $wp_customize );
		$this->add_sponsor_controls( $wp_customize );
		$this->add_contact_social_controls( $wp_customize );
	}

	/**
	 * Adds Media Library controls for the homepage hero slider.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	private function add_hero_controls( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'scng_hero_slider',
			array(
				'title' => __( 'Hero Slider', 'socalnextgen' ),
				'panel' => 'scng_theme_options',
			)
		);

		for ( $index = 1; $index <= 5; $index++ ) {
			$setting_id = "scng_hero_slide_{$index}_image";
			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new \WP_Customize_Media_Control(
					$wp_customize,
					$setting_id,
					array(
						'label'     => sprintf( __( 'Slide %d Image', 'socalnextgen' ), $index ),
						'section'   => 'scng_hero_slider',
						'mime_type' => 'image',
					)
				)
			);
		}
	}

	/**
	 * Adds Media Library controls for From Our Community.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	private function add_community_controls( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'scng_community_gallery',
			array(
				'title'       => __( 'From Our Community', 'socalnextgen' ),
				'description' => __( 'Choose up to ten images for the homepage gallery.', 'socalnextgen' ),
				'panel'       => 'scng_theme_options',
			)
		);

		for ( $index = 1; $index <= 10; $index++ ) {
			$setting_id = "scng_community_image_{$index}";
			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new \WP_Customize_Media_Control(
					$wp_customize,
					$setting_id,
					array(
						'label'     => sprintf( __( 'Community Image %d', 'socalnextgen' ), $index ),
						'section'   => 'scng_community_gallery',
						'mime_type' => 'image',
					)
				)
			);
		}
	}

	/**
	 * Adds fixed sponsor logo, name, link, and visibility controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	private function add_sponsor_controls( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'scng_sponsors',
			array(
				'title'       => __( 'Sponsors', 'socalnextgen' ),
				'description' => __( 'Add up to twelve sponsor logos in display order.', 'socalnextgen' ),
				'panel'       => 'scng_theme_options',
			)
		);

		for ( $index = 1; $index <= 12; $index++ ) {
			$prefix = "scng_sponsor_{$index}";

			$wp_customize->add_setting(
				"{$prefix}_visible",
				array(
					'default'           => true,
					'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
				)
			);
			$wp_customize->add_control(
				"{$prefix}_visible",
				array(
					'label'   => sprintf( __( 'Show Sponsor %d', 'socalnextgen' ), $index ),
					'section' => 'scng_sponsors',
					'type'    => 'checkbox',
				)
			);

			$wp_customize->add_setting(
				"{$prefix}_name",
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				"{$prefix}_name",
				array(
					'label'   => sprintf( __( 'Sponsor %d Name', 'socalnextgen' ), $index ),
					'section' => 'scng_sponsors',
					'type'    => 'text',
				)
			);

			$wp_customize->add_setting(
				"{$prefix}_logo",
				array(
					'default'           => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new \WP_Customize_Media_Control(
					$wp_customize,
					"{$prefix}_logo",
					array(
						'label'     => sprintf( __( 'Sponsor %d Logo', 'socalnextgen' ), $index ),
						'section'   => 'scng_sponsors',
						'mime_type' => 'image',
					)
				)
			);

			$wp_customize->add_setting(
				"{$prefix}_url",
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				"{$prefix}_url",
				array(
					'label'   => sprintf( __( 'Sponsor %d Link', 'socalnextgen' ), $index ),
					'section' => 'scng_sponsors',
					'type'    => 'url',
				)
			);
		}
	}

	/**
	 * Adds footer contact and social settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	private function add_contact_social_controls( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'scng_contact_social',
			array(
				'title' => __( 'Contact & Social', 'socalnextgen' ),
				'panel' => 'scng_theme_options',
			)
		);

		$controls = array(
			'scng_contact_phone'     => array( __( 'Phone', 'socalnextgen' ), 'text', 'sanitize_text_field', '760-625-2910' ),
			'scng_contact_location'  => array( __( 'Location / State', 'socalnextgen' ), 'text', 'sanitize_text_field', 'Southern California' ),
			'scng_footer_email'      => array( __( 'Email', 'socalnextgen' ), 'email', 'sanitize_email', '' ),
			'scng_facebook_url'      => array( __( 'Facebook URL', 'socalnextgen' ), 'url', 'esc_url_raw', '' ),
			'scng_instagram_url'     => array( __( 'Instagram URL', 'socalnextgen' ), 'url', 'esc_url_raw', '' ),
			'scng_youtube_url'       => array( __( 'YouTube URL', 'socalnextgen' ), 'url', 'esc_url_raw', '' ),
			'scng_footer_credit'     => array( __( 'Footer Credit', 'socalnextgen' ), 'text', 'sanitize_text_field', __( 'Created and designed by Mber Digital', 'socalnextgen' ) ),
			'scng_footer_credit_url' => array( __( 'Footer Credit URL', 'socalnextgen' ), 'url', 'esc_url_raw', '' ),
		);

		foreach ( $controls as $setting_id => $control ) {
			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $control[3],
					'sanitize_callback' => $control[2],
				)
			);
			$wp_customize->add_control(
				$setting_id,
				array(
					'label'   => $control[0],
					'section' => 'scng_contact_social',
					'type'    => $control[1],
				)
			);
		}
	}

	/**
	 * Sanitizes Customizer checkboxes.
	 *
	 * @param mixed $checked Submitted checkbox value.
	 * @return bool
	 */
	public function sanitize_checkbox( $checked ): bool {
		return (bool) $checked;
	}

	/**
	 * Enqueues JavaScript to make Customizer preview reload changes asynchronously.
	 */
	public function action_enqueue_customize_preview_js() {
		wp_enqueue_script(
			'wp-rig-customizer',
			get_theme_file_uri( '/assets/js/customizer.min.js' ),
			array( 'customize-preview' ),
			wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/customizer.min.js' ) ),
			true
		);
	}
}
