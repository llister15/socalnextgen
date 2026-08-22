<?php
/**
 * Displays a weekly service card.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$post_id      = $args['post_id'] ?? get_the_ID();
$service_name = get_post_meta( $post_id, 'scng_service_name', true ) ?: get_the_title( $post_id );
$description  = get_post_meta( $post_id, 'scng_service_short_description', true ) ?: get_the_excerpt( $post_id );
$day          = get_post_meta( $post_id, 'scng_service_day', true );
$time_display = get_post_meta( $post_id, 'scng_service_time_display', true );
$start_time   = get_post_meta( $post_id, 'scng_service_start_time', true );
$end_time     = get_post_meta( $post_id, 'scng_service_end_time', true );
$campus       = get_post_meta( $post_id, 'scng_service_campus', true );
$building     = get_post_meta( $post_id, 'scng_service_building', true );
$room         = get_post_meta( $post_id, 'scng_service_room', true );
$pastor       = get_post_meta( $post_id, 'scng_service_pastor_name', true );
$primary_text = get_post_meta( $post_id, 'scng_service_primary_button_text', true ) ?: __( 'Plan Your Visit', 'socalnextgen' );
$primary_url  = get_post_meta( $post_id, 'scng_service_primary_button_link', true ) ?: home_url( '/contact/' );
$watch_text   = get_post_meta( $post_id, 'scng_service_secondary_button_text', true ) ?: get_post_meta( $post_id, 'scng_service_watch_button_text', true ) ?: __( 'Watch Live', 'socalnextgen' );
$watch_url    = get_post_meta( $post_id, 'scng_service_secondary_button_link', true ) ?: get_post_meta( $post_id, 'scng_service_livestream_url', true );
$features     = array(
	'scng_service_children_ministry'       => __( 'Kids Ministry', 'socalnextgen' ),
	'scng_service_childcare_available'     => __( 'Nursery Available', 'socalnextgen' ),
	'scng_service_livestream_available'    => __( 'Livestream Available', 'socalnextgen' ),
	'scng_service_youth_ministry'          => __( 'Youth Ministry', 'socalnextgen' ),
	'scng_service_asl_available'           => __( 'ASL Available', 'socalnextgen' ),
	'scng_service_spanish_translation'     => __( 'Spanish Translation', 'socalnextgen' ),
);

if ( ! $time_display && $start_time ) {
	$time_display = $start_time . ( $end_time ? ' - ' . $end_time : '' );
}

$location = trim( implode( ' ', array_filter( array( $campus, $building, $room ) ) ) );

?>
<article class="scng-card flex h-full flex-col">
	<?php if ( has_post_thumbnail( $post_id ) ) : ?>
		<a class="block aspect-[16/9] overflow-hidden bg-slate-100" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php echo get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="flex flex-1 flex-col p-6">
		<h3 class="mb-3 text-2xl leading-tight"><?php echo esc_html( $service_name ); ?></h3>
		<?php if ( $description ) : ?>
			<p class="mb-4 text-sm leading-6 text-brand-muted"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
		<div class="mb-4 space-y-1 font-display text-lg font-bold uppercase text-brand-navy">
			<?php if ( $day ) : ?>
				<p><?php echo esc_html( $day ); ?></p>
			<?php endif; ?>
			<?php if ( $time_display ) : ?>
				<p class="text-brand-orange"><?php echo esc_html( $time_display ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( $location ) : ?>
			<p class="mb-3 text-sm text-brand-navy"><?php echo esc_html( '📍 ' . $location ); ?></p>
		<?php endif; ?>
		<?php if ( $pastor ) : ?>
			<p class="mb-4 text-sm font-bold text-brand-navy"><?php echo esc_html( $pastor ); ?></p>
		<?php endif; ?>
		<ul class="mb-6 space-y-1 text-sm text-brand-navy">
			<?php foreach ( $features as $key => $label ) : ?>
				<?php if ( get_post_meta( $post_id, $key, true ) ) : ?>
					<li><?php echo esc_html( '✓ ' . $label ); ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<div class="mt-auto flex flex-col gap-3 sm:flex-row">
			<?php
			get_template_part(
				'template-parts/components/button',
				null,
				array(
					'url'   => $primary_url,
					'label' => $primary_text,
				)
			);
			if ( $watch_url ) {
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'url'     => $watch_url,
						'label'   => $watch_text,
						'variant' => 'secondary',
					)
				);
			}
			?>
		</div>
	</div>
</article>
