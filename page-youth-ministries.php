<?php
/**
 * Template Name: Youth Ministries
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

if ( have_posts() ) {
	the_post();
}

$post_id = get_the_ID();
?>
<main id="primary" class="site-main">
	<?php
	get_template_part(
		'template-parts/layout/photo-page-hero',
		null,
		array(
			'post_id' => $post_id,
			'eyebrow' => __( 'Socal NextGen', 'socalnextgen' ),
			'title'   => __( 'Youth Ministries', 'socalnextgen' ),
		)
	);
	?>

	<?php if ( trim( get_the_content() ) ) : ?>
		<section class="scng-section bg-white">
			<div class="scng-container">
				<div class="entry-content mx-auto max-w-4xl"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>

	<section class="scng-section bg-brand-navy text-center text-white">
		<div class="scng-container">
			<p class="scng-eyebrow text-brand-gold"><?php esc_html_e( 'Find Your Community', 'socalnextgen' ); ?></p>
			<h2 class="mx-auto mt-3 max-w-4xl text-4xl leading-none text-white md:text-5xl"><?php esc_html_e( 'Find the NextGen Youth Group Near You', 'socalnextgen' ); ?></h2>
			<a class="scng-button scng-button-primary mt-8" href="<?php echo esc_url( get_post_type_archive_link( 'youth-group' ) ); ?>"><?php esc_html_e( 'NextGen Locator', 'socalnextgen' ); ?></a>
		</div>
	</section>
</main>
<?php
get_footer();
