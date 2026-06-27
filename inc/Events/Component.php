<?php
/**
 * WP_Rig\WP_Rig\Events Component
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Events;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function register_post_type;
use function register_taxonomy;
use function esc_html__;

/**
 * Class for Events component.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'events';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'init', array( $this, 'action_register_event_post_type' ) );
		add_action( 'init', array( $this, 'action_register_event_taxonomy' ) );
	}

	/**
	 * Registers the ministry event custom post type.
	 */
	public function action_register_event_post_type() {
		register_post_type(
			'scng_event',
			array(
				'labels'       => array(
					'name'                  => esc_html__( 'Events', 'socalnextgen' ),
					'singular_name'         => esc_html__( 'Event', 'socalnextgen' ),
					'add_new_item'          => esc_html__( 'Add New Event', 'socalnextgen' ),
					'edit_item'             => esc_html__( 'Edit Event', 'socalnextgen' ),
					'new_item'              => esc_html__( 'New Event', 'socalnextgen' ),
					'view_item'             => esc_html__( 'View Event', 'socalnextgen' ),
					'search_items'          => esc_html__( 'Search Events', 'socalnextgen' ),
					'not_found'             => esc_html__( 'No events found.', 'socalnextgen' ),
					'not_found_in_trash'    => esc_html__( 'No events found in Trash.', 'socalnextgen' ),
					'all_items'             => esc_html__( 'All Events', 'socalnextgen' ),
					'archives'              => esc_html__( 'Event Archives', 'socalnextgen' ),
					'featured_image'        => esc_html__( 'Event Image', 'socalnextgen' ),
					'set_featured_image'    => esc_html__( 'Set event image', 'socalnextgen' ),
					'remove_featured_image' => esc_html__( 'Remove event image', 'socalnextgen' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => 'dashicons-calendar-alt',
				'rewrite'      => array(
					'slug' => 'events',
				),
				'show_in_rest' => true,
				'supports'     => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
					'custom-fields',
					'revisions',
				),
			)
		);
	}

	/**
	 * Registers a simple event category taxonomy.
	 */
	public function action_register_event_taxonomy() {
		register_taxonomy(
			'scng_event_type',
			'scng_event',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Event Types', 'socalnextgen' ),
					'singular_name' => esc_html__( 'Event Type', 'socalnextgen' ),
				),
				'hierarchical' => true,
				'rewrite'      => array(
					'slug' => 'event-type',
				),
				'show_in_rest' => true,
			)
		);
	}
}
