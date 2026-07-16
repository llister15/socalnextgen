<?php
/**
 * Homepage upcoming events section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$events = null;

if ( post_type_exists( 'tribe_events' ) ) {
	$events = new \WP_Query(
		array(
			'post_type'      => 'tribe_events',
			'posts_per_page' => 4,
			'post_status'    => 'publish',
			'meta_key'       => '_EventStartDate',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_EventStartDate',
					'value'   => current_time( 'mysql' ),
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
		)
	);
}

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
			if ( $events && $events->have_posts() ) :
				while ( $events->have_posts() ) :
					$events->the_post();
					$event_date = get_post_meta( get_the_ID(), '_EventStartDate', true );
					$timestamp  = $event_date ? strtotime( $event_date ) : false;
					$venue_id   = (int) get_post_meta( get_the_ID(), '_EventVenueID', true );
					$location   = $venue_id ? get_the_title( $venue_id ) : get_post_meta( get_the_ID(), '_EventVenue', true );

					get_template_part(
						'template-parts/cards/event-card',
						null,
						array(
							'title'       => get_the_title(),
							'description' => get_the_excerpt() ?: __( 'Gather with Socal NextGen.', 'socalnextgen' ),
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
				?>
				<p class="text-brand-navy sm:col-span-2 lg:col-span-4">
					<?php esc_html_e( 'Upcoming events will appear here when they are available.', 'socalnextgen' ); ?>
				</p>
				<?php
			endif;
			?>
		</div>
	</div>
</section>
