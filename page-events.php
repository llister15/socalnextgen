<?php
/**
 * Template Name: Events
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$event_post_type = post_type_exists( 'tribe_events' ) ? 'tribe_events' : 'scng_event';
$event_meta_key  = 'tribe_events' === $event_post_type ? '_EventStartDate' : 'scng_event_date';
$events          = new \WP_Query(
	array(
		'post_type'      => $event_post_type,
		'posts_per_page' => 12,
		'post_status'    => 'publish',
		'meta_key'       => $event_meta_key,
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
	)
);

get_header();
?>
<main id="primary" class="site-main">
	<?php
	get_template_part(
		'template-parts/layout/page-hero',
		null,
		array(
			'eyebrow' => __( 'Events', 'socalnextgen' ),
			'title'   => __( 'Upcoming Events', 'socalnextgen' ),
			'intro'   => __( 'Gather with SoCal NextGen for worship, leadership, service, and community moments across Southern California.', 'socalnextgen' ),
		)
	);
	?>
	<section class="scng-section bg-white">
		<div class="scng-container">
			<?php if ( $events->have_posts() ) : ?>
				<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
					<?php
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
					?>
				</div>
			<?php else : ?>
				<p class="text-brand-navy"><?php esc_html_e( 'Events will appear here after they are added in WordPress.', 'socalnextgen' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
