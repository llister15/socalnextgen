<?php
/**
 * Single weekly service template.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();
?>
<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part(
			'template-parts/layout/page-hero',
			null,
			array(
				'eyebrow' => __( 'Weekly Service', 'socalnextgen' ),
				'title'   => get_post_meta( get_the_ID(), 'scng_service_name', true ) ?: get_the_title(),
				'intro'   => get_post_meta( get_the_ID(), 'scng_service_short_description', true ) ?: get_the_excerpt(),
			)
		);
		?>
		<section class="scng-section bg-white">
			<div class="scng-container grid gap-8 lg:grid-cols-[0.6fr_0.4fr]">
				<article class="text-brand-navy">
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="mb-8 overflow-hidden rounded-lg">
							<?php the_post_thumbnail( 'large', array( 'class' => 'w-full object-cover' ) ); ?>
						</figure>
					<?php endif; ?>
					<div class="mx-auto max-w-site text-center lg:text-left">
						<?php the_content(); ?>
					</div>
				</article>
				<aside>
					<?php get_template_part( 'template-parts/cards/service-card', null, array( 'post_id' => get_the_ID() ) ); ?>
				</aside>
			</div>
		</section>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
