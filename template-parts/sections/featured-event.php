<?php
/**
 * Next upcoming event promotion.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

if ( ! post_type_exists( 'tribe_events' ) ) {
	return;
}

$upcoming_events = new \WP_Query(
	array(
		'post_type'      => 'tribe_events',
		'posts_per_page' => 1,
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

if ( ! $upcoming_events->have_posts() ) {
	return;
}

$upcoming_events->the_post();

$event_id    = get_the_ID();
$event_url   = get_permalink( $event_id );
$event_date  = get_post_meta( $event_id, '_EventStartDate', true );
$venue_id    = (int) get_post_meta( $event_id, '_EventVenueID', true );
$location    = $venue_id ? get_the_title( $venue_id ) : get_post_meta( $event_id, '_EventVenue', true );
$description = get_the_excerpt( $event_id );

if ( function_exists( 'tribe_get_start_date' ) ) {
	$formatted_date = tribe_get_start_date( $event_id, false, 'F j, Y' );
} else {
	$formatted_date = $event_date ? mysql2date( 'F j, Y', $event_date ) : '';
}

?>
<section class="scng-featured-event" aria-labelledby="scng-upcoming-event-title">
	<a class="scng-featured-event__link" href="<?php echo esc_url( $event_url ); ?>">
		<div class="scng-featured-event__content">
			<p class="scng-eyebrow"><?php esc_html_e( 'Upcoming Event', 'socalnextgen' ); ?></p>
			<h2 id="scng-upcoming-event-title" class="mt-2 text-4xl leading-none md:text-5xl"><?php echo esc_html( get_the_title( $event_id ) ); ?></h2>
			<div class="mt-6 flex flex-wrap gap-x-8 gap-y-2 font-display text-lg font-bold uppercase text-brand-orange">
				<?php if ( $formatted_date ) : ?>
					<p><?php echo esc_html( $formatted_date ); ?></p>
				<?php endif; ?>
				<?php if ( $location ) : ?>
					<p><?php echo esc_html( $location ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $description ) : ?>
				<p class="mt-5 max-w-3xl text-lg leading-7 text-brand-navy"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
			<p class="scng-featured-event__cta mt-7 font-display font-bold uppercase text-brand-orange">
				<?php esc_html_e( 'View Event', 'socalnextgen' ); ?>
				<span aria-hidden="true">→</span>
			</p>
		</div>
		<div class="<?php echo esc_attr( has_post_thumbnail( $event_id ) ? 'scng-featured-event__image' : 'scng-featured-event__image scng-featured-event__image--fallback' ); ?>">
			<?php
			if ( has_post_thumbnail( $event_id ) ) {
				echo get_the_post_thumbnail( $event_id, 'large', array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async' ) );
			} else {
				?>
				<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="<?php esc_attr_e( 'Socal NextGen Youth Ministries', 'socalnextgen' ); ?>" loading="lazy" decoding="async">
				<?php
			}
			?>
		</div>
	</a>
</section>
<?php
wp_reset_postdata();
