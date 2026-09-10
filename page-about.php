<?php
/**
 * Template Name: About
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

if ( have_posts() ) {
	the_post();
}

$post_id        = get_the_ID();
$story_image_id = (int) get_theme_mod( 'scng_about_story_image', 0 );
$story_image_id = $story_image_id ?: get_post_thumbnail_id( $post_id );
$mission        = array(
	__( 'Our mission is to equip the next generation with the biblical foundation, practical tools, and spiritual guidance they need to live Christ-centered, purpose-driven lives. We believe in the transforming power of God\'s Word and the leading of the Holy Spirit to empower young people to discover their identity, fulfill their God-given purpose, and make a lasting impact in their homes, churches, communities, and beyond.', 'socalnextgen' ),
	__( 'Through leadership development, mentorship, discipleship, creative opportunities, and meaningful programs, we are committed to raising a generation of faithful leaders and world changers. We proudly partner with local churches and youth ministries, serving alongside them as a resource and support system to strengthen their efforts and expand their impact.', 'socalnextgen' ),
);
?>
<main id="primary" class="site-main">
	<?php
	get_template_part(
		'template-parts/layout/photo-page-hero',
		null,
		array(
			'post_id' => $post_id,
			'eyebrow' => __( 'What are we about', 'socalnextgen' ),
			'title'   => __( 'About', 'socalnextgen' ),
		)
	);
	?>

	<section class="scng-section bg-stone-50">
		<div class="scng-container grid items-center gap-10 lg:grid-cols-2">
			<div class="scng-story-image">
				<?php
				if ( $story_image_id ) {
					echo wp_get_attachment_image( $story_image_id, 'large', false, array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async' ) );
				} else {
					?>
					<img class="scng-story-image__fallback" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="<?php esc_attr_e( 'Socal NextGen Youth Ministries', 'socalnextgen' ); ?>" loading="lazy" decoding="async">
					<?php
				}
				?>
			</div>
			<div>
				<p class="scng-eyebrow"><?php esc_html_e( 'Our Mission', 'socalnextgen' ); ?></p>
				<h2 class="mt-3 text-4xl leading-none md:text-5xl"><?php esc_html_e( 'Equipping The Next Generation', 'socalnextgen' ); ?></h2>
				<?php foreach ( $mission as $index => $paragraph ) : ?>
					<p class="<?php echo esc_attr( 0 === $index ? 'mt-6' : 'mt-4' ); ?> text-xl leading-8 text-brand-navy"><?php echo esc_html( $paragraph ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/pillars' ); ?>
	<?php get_template_part( 'template-parts/sections/featured-event' ); ?>

	<?php if ( trim( get_the_content() ) ) : ?>
		<section class="scng-section bg-brand-gold">
			<div class="scng-container">
				<div class="scng-editor-banner-content entry-content"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php
get_footer();
