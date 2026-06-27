<?php
/**
 * WP_Rig\WP_Rig\Starter_Content Component
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Starter_Content;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function get_option;
use function get_page_by_path;
use function get_theme_mod;
use function is_wp_error;
use function set_theme_mod;
use function update_option;
use function update_post_meta;
use function wp_create_nav_menu;
use function wp_get_nav_menu_object;
use function wp_insert_post;
use function wp_update_nav_menu_item;

/**
 * Class for Starter Content component.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'starter-content';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'admin_init', array( $this, 'action_maybe_create_starter_content' ) );
		add_action( 'after_switch_theme', array( $this, 'action_create_starter_content' ) );
	}

	/**
	 * Creates starter content once from wp-admin for already-active development installs.
	 */
	public function action_maybe_create_starter_content() {
		if ( get_option( 'scng_starter_content_created' ) ) {
			return;
		}

		$this->action_create_starter_content();
	}

	/**
	 * Creates required pages and navigation menus after theme activation.
	 */
	public function action_create_starter_content() {
		$pages = $this->get_pages();
		$ids   = array();

		foreach ( $pages as $slug => $page ) {
			$existing = get_page_by_path( $slug );

			if ( $existing ) {
				$ids[ $slug ] = (int) $existing->ID;
				continue;
			}

			$page_id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $page['title'],
					'post_name'    => $slug,
					'post_content' => $page['content'],
				)
			);

			if ( ! is_wp_error( $page_id ) ) {
				$ids[ $slug ] = (int) $page_id;

				if ( ! empty( $page['template'] ) ) {
					update_post_meta( $page_id, '_wp_page_template', $page['template'] );
				}
			}
		}

		if ( ! empty( $ids['home'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $ids['home'] );
		}

		$this->create_menu(
			'SoCal NextGen Primary',
			'primary',
			array( 'home', 'about', 'events', 'leadership-hub', 'fine-arts', 'scholarships', 'resources', 'contact' ),
			$ids
		);

		$this->create_menu(
			'SoCal NextGen Footer Quick Links',
			'footer_quick_links',
			array( 'about', 'events', 'leadership-hub', 'fine-arts', 'scholarships', 'resources', 'contact' ),
			$ids
		);

		update_option( 'scng_starter_content_created', 1 );
	}

	/**
	 * Gets starter pages.
	 *
	 * @return array
	 */
	private function get_pages(): array {
		return array(
			'home'           => array(
				'title'    => __( 'Home', 'socalnextgen' ),
				'template' => 'front-page.php',
				'content'  => __( 'SoCal NextGen exists to equip youth leaders, empower students, and partner with local churches to fulfill the call of God on the next generation.', 'socalnextgen' ),
			),
			'about'          => array(
				'title'    => __( 'About', 'socalnextgen' ),
				'template' => 'page-about.php',
				'content'  => __( 'Learn more about the heart, mission, and leadership of SoCal NextGen Youth Ministries.', 'socalnextgen' ),
			),
			'events'         => array(
				'title'    => __( 'Events', 'socalnextgen' ),
				'template' => 'page-events.php',
				'content'  => __( 'Discover upcoming gatherings, rallies, conferences, camps, and leadership moments.', 'socalnextgen' ),
			),
			'leadership-hub' => array(
				'title'    => __( 'Leadership Hub', 'socalnextgen' ),
				'template' => 'page-leadership-hub.php',
				'content'  => __( 'Resources, training, and encouragement for youth leaders and churches.', 'socalnextgen' ),
			),
			'fine-arts'      => array(
				'title'    => __( 'Fine Arts', 'socalnextgen' ),
				'template' => 'page-fine-arts.php',
				'content'  => __( 'Develop God-given gifts through art, music, drama, dance, and creative ministry.', 'socalnextgen' ),
			),
			'scholarships'   => array(
				'title'    => __( 'Scholarships', 'socalnextgen' ),
				'template' => 'page-scholarships.php',
				'content'  => __( 'Supporting graduating high school seniors as they pursue their God-given purpose.', 'socalnextgen' ),
			),
			'resources'      => array(
				'title'    => __( 'Resources', 'socalnextgen' ),
				'template' => 'page-resources.php',
				'content'  => __( 'Helpful ministry tools, next steps, links, and downloads for leaders and students.', 'socalnextgen' ),
			),
			'gallery'        => array(
				'title'    => __( 'Gallery', 'socalnextgen' ),
				'template' => 'page-gallery.php',
				'content'  => __( 'Photos and moments from the SoCal NextGen community.', 'socalnextgen' ),
			),
			'contact'        => array(
				'title'    => __( 'Contact', 'socalnextgen' ),
				'template' => 'page-contact.php',
				'content'  => __( 'Stay connected with SoCal NextGen Youth Ministries.', 'socalnextgen' ),
			),
		);
	}

	/**
	 * Creates and assigns a nav menu if needed.
	 *
	 * @param string $menu_name Menu name.
	 * @param string $location  Theme location.
	 * @param array  $slugs     Page slugs.
	 * @param array  $ids       Page IDs keyed by slug.
	 */
	private function create_menu( string $menu_name, string $location, array $slugs, array $ids ) {
		$locations = get_theme_mod( 'nav_menu_locations', array() );

		if ( ! empty( $locations[ $location ] ) ) {
			return;
		}

		$menu = wp_get_nav_menu_object( $menu_name );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $menu_name );

			if ( is_wp_error( $menu_id ) ) {
				return;
			}

			foreach ( $slugs as $slug ) {
				if ( empty( $ids[ $slug ] ) ) {
					continue;
				}

				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-object-id' => $ids[ $slug ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
		} else {
			$menu_id = (int) $menu->term_id;
		}

		$locations[ $location ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
