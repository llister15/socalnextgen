<?php
/**
 * Homepage hero section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$hero_slides = array();

for ( $index = 1; $index <= 5; $index++ ) {
	$attachment_id = (int) get_theme_mod( "scng_hero_slide_{$index}_image", 0 );
	if ( $attachment_id ) {
		$hero_slides[] = array( 'attachment_id' => $attachment_id );
	}
}

$hero_slides       = array_slice( $hero_slides, 0, 5 );
$hero_layout_class = 'scng-container relative grid min-h-[560px] items-center py-14';

if ( $hero_slides ) {
	$hero_layout_class .= ' lg:grid-cols-[0.9fr_1.1fr]';
}
?>
<section class="relative overflow-hidden bg-white">
	<?php if ( $hero_slides ) : ?>
		<div class="scng-hero-slider" aria-hidden="true">
			<?php foreach ( $hero_slides as $index => $slide ) : ?>
				<div class="scng-hero-slide" style="<?php echo esc_attr( 0 === $index ? 'animation-delay: 0s;' : '' ); ?>">
					<?php echo wp_get_attachment_image( $slide['attachment_id'], 'full', false, array( 'class' => 'h-full w-full object-cover' ) ); ?>
				</div>
			<?php endforeach; ?>
			<div class="scng-hero-overlay"></div>
		</div>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $hero_layout_class ); ?>">
		<div class="max-w-xl">
			<p class="sr-only"><?php esc_html_e( 'Socal NextGen Youth Ministries', 'socalnextgen' ); ?></p>
			<h1 class="mb-5 text-5xl leading-[0.88] md:text-7xl lg:text-8xl">
				<span class="block"><?php esc_html_e( 'Socal', 'socalnextgen' ); ?></span>
				<span class="block"><?php esc_html_e( 'Next', 'socalnextgen' ); ?><span class="text-brand-orange"><?php esc_html_e( 'Gen', 'socalnextgen' ); ?></span></span>
				<span class="mt-3 block border-y-2 border-brand-orange py-2 text-xl tracking-[0.28em] md:text-2xl"><?php esc_html_e( 'Youth Ministries', 'socalnextgen' ); ?></span>
			</h1>

			<div class="mb-8 space-y-1 text-2xl leading-tight md:text-3xl">
				<p><?php esc_html_e( 'Back to', 'socalnextgen' ); ?> <span class="font-script text-4xl text-brand-orange"><?php esc_html_e( 'Heart.', 'socalnextgen' ); ?></span></p>
				<p><?php esc_html_e( 'Back to', 'socalnextgen' ); ?> <span class="font-script text-4xl text-brand-orange"><?php esc_html_e( 'Basics.', 'socalnextgen' ); ?></span></p>
				<p><?php esc_html_e( 'Back to the', 'socalnextgen' ); ?> <span class="font-script text-4xl text-brand-orange"><?php esc_html_e( 'Call.', 'socalnextgen' ); ?></span></p>
			</div>

			<div class="flex flex-col gap-3 sm:flex-row">
				<?php
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'url'   => home_url( '/events/' ),
						'label' => __( 'View Upcoming Events', 'socalnextgen' ),
						'icon'  => 'calendar',
					)
				);
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'url'     => home_url( '/contact/' ),
						'label'   => __( 'Stay Connected', 'socalnextgen' ),
						'variant' => 'secondary',
						'icon'    => 'users',
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
