<?php
/**
 * Homepage weekly services preview.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$services = new \WP_Query(
	array(
		'post_type'      => 'weekly-service',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'   => 'scng_service_active',
				'value' => 1,
			),
			array(
				'key'   => 'scng_service_featured',
				'value' => 1,
			),
		),
		'meta_key'       => 'scng_service_display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	)
);

if ( ! $services->have_posts() ) {
	return;
}

?>
<section class="scng-section bg-white">
	<div class="scng-container">
		<div class="mb-8 text-center">
			<p class="scng-eyebrow"><?php esc_html_e( 'Weekly Services', 'socalnextgen' ); ?></p>
			<h2 class="scng-section-heading"><?php esc_html_e( 'Gather With Us', 'socalnextgen' ); ?></h2>
		</div>
		<div class="grid gap-6 lg:grid-cols-3">
			<?php
			while ( $services->have_posts() ) :
				$services->the_post();
				get_template_part( 'template-parts/cards/service-card', null, array( 'post_id' => get_the_ID() ) );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
