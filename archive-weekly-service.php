<?php
/**
 * Weekly services archive template.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$services = new \WP_Query(
	array(
		'post_type'      => 'weekly-service',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'   => 'scng_service_active',
				'value' => 1,
			),
		),
		'meta_key'       => 'scng_service_display_order',
		'orderby'        => 'meta_value_num',
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
			'eyebrow' => __( 'Weekly Services', 'socalnextgen' ),
			'title'   => __( 'Gather With Us', 'socalnextgen' ),
			'intro'   => __( 'Find recurring worship, prayer, Bible study, youth, children, and midweek services.', 'socalnextgen' ),
		)
	);
	?>
	<section class="scng-section bg-white">
		<div class="scng-container">
			<?php if ( $services->have_posts() ) : ?>
				<div class="grid gap-6 lg:grid-cols-3">
					<?php
					while ( $services->have_posts() ) :
						$services->the_post();
						get_template_part( 'template-parts/cards/service-card', null, array( 'post_id' => get_the_ID() ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<p class="text-center text-brand-navy"><?php esc_html_e( 'Weekly services will appear here after they are added in WordPress.', 'socalnextgen' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
