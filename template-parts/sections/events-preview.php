<?php
/**
 * Homepage upcoming events section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$event_post_type = post_type_exists( 'tribe_events' ) ? 'tribe_events' : 'scng_event';
$event_meta_key  = 'tribe_events' === $event_post_type ? '_EventStartDate' : 'scng_event_date';

$events = new \WP_Query(
	array(
		'post_type'      => $event_post_type,
		'posts_per_page' => 4,
		'post_status'    => 'publish',
		'meta_key'       => $event_meta_key,
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
	)
);

$fallback_events = array(
	array(
		'title'       => __( 'Youth Leaders Workshop', 'socalnextgen' ),
		'description' => __( 'Equip. Empower. Lead.', 'socalnextgen' ),
		'month'       => __( 'Jan', 'socalnextgen' ),
		'date'        => __( '24-31', 'socalnextgen' ),
	),
	array(
		'title'       => __( 'NextGen Rally / FAF', 'socalnextgen' ),
		'description' => __( 'Faith. Worship. Unity.', 'socalnextgen' ),
		'month'       => __( 'Mar', 'socalnextgen' ),
		'date'        => __( '6-7', 'socalnextgen' ),
	),
	array(
		'title'       => __( 'SDC Youth Conference', 'socalnextgen' ),
		'description' => __( 'Encounter. Grow. Go.', 'socalnextgen' ),
		'month'       => __( 'Apr', 'socalnextgen' ),
		'date'        => __( '24-25', 'socalnextgen' ),
	),
	array(
		'title'       => __( 'NextGen Camp', 'socalnextgen' ),
		'description' => __( 'Unplug. Connect. Encounter.', 'socalnextgen' ),
		'month'       => __( 'Aug', 'socalnextgen' ),
		'date'        => __( '7-9', 'socalnextgen' ),
	),
);

?>
<section id="events" class="scng-section scng-page-band">
	<div class="scng-container">
		<div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
			<h2 class="scng-section-heading"><?php esc_html_e( 'Upcoming Events', 'socalnextgen' ); ?></h2>
			<a class="scng-link-cta" href="<?php echo esc_url( home_url( '/events/' ) ); ?>">
				<?php esc_html_e( 'View Full Calendar', 'socalnextgen' ); ?>
				<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'arrow-right', 'class' => 'h-4 w-4' ) ); ?>
			</a>
		</div>
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<?php
			if ( $events->have_posts() ) :
				while ( $events->have_posts() ) :
					$events->the_post();
					$post_type  = get_post_type( get_the_ID() );
					$event_date = 'tribe_events' === $post_type ? get_post_meta( get_the_ID(), '_EventStartDate', true ) : get_post_meta( get_the_ID(), 'scng_event_date', true );
					$timestamp  = $event_date ? strtotime( $event_date ) : false;
					$location   = get_post_meta( get_the_ID(), 'scng_event_location', true );

					if ( 'tribe_events' === $post_type ) {
						$venue_id = (int) get_post_meta( get_the_ID(), '_EventVenueID', true );
						$location = $venue_id ? get_the_title( $venue_id ) : get_post_meta( get_the_ID(), '_EventVenue', true );
					}

					get_template_part(
						'template-parts/cards/event-card',
						null,
						array(
							'title'       => get_the_title(),
							'description' => get_the_excerpt() ?: __( 'Gather with SoCal NextGen.', 'socalnextgen' ),
							'url'         => get_permalink(),
							'month'       => $timestamp ? gmdate( 'M', $timestamp ) : __( 'Soon', 'socalnextgen' ),
							'date'        => $timestamp ? gmdate( 'j', $timestamp ) : __( 'TBD', 'socalnextgen' ),
							'location'    => $location ?: __( 'TBD', 'socalnextgen' ),
							'image'       => get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ),
						)
					);
				endwhile;
				wp_reset_postdata();
			else :
				foreach ( $fallback_events as $event ) {
					get_template_part(
						'template-parts/cards/event-card',
						null,
						array_merge(
							$event,
							array(
								'url'      => home_url( '/events/' ),
								'location' => __( 'TBD', 'socalnextgen' ),
							)
						)
					);
				}
			endif;
			?>
		</div>
	</div>
</section>
