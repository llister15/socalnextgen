<?php
/**
 * Homepage hero section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$hero_slides = array_filter(
	array(
		wp_rig()->get_setting( 'scng_hero_slide_1_url' ),
		wp_rig()->get_setting( 'scng_hero_slide_2_url' ),
		wp_rig()->get_setting( 'scng_hero_slide_3_url' ),
	)
);

if ( ! $hero_slides ) {
	$hero_slide_files = glob( get_theme_file_path( '/assets/images/hero-slide-*.{jpg,jpeg,png,webp}' ), GLOB_BRACE );
	$hero_slides      = array_map(
		function ( $slide ) {
			return get_theme_file_uri( '/assets/images/' . basename( $slide ) );
		},
		$hero_slide_files ?: array()
	);
}

if ( ! $hero_slides ) {
	$hero_slides = array( get_theme_file_uri( '/assets/images/HeroImage.jpg' ) );
}

$hero_slides = array_slice( $hero_slides, 0, 3 );

if ( 2 === count( $hero_slides ) ) {
	$hero_slides[] = $hero_slides[0];
}
?>
<section class="relative overflow-hidden bg-white">
	<div class="scng-hero-slider" aria-hidden="true">
		<?php foreach ( $hero_slides as $index => $slide_uri ) : ?>
			<div class="scng-hero-slide" style="<?php echo esc_attr( 0 === $index ? 'animation-delay: 0s;' : '' ); ?>">
				<img src="<?php echo esc_url( $slide_uri ); ?>" alt="">
			</div>
		<?php endforeach; ?>
		<div class="scng-hero-overlay"></div>
	</div>

	<div class="scng-container relative grid min-h-[560px] items-center py-14 lg:grid-cols-[0.9fr_1.1fr]">
		<div class="max-w-xl">
			<p class="sr-only"><?php esc_html_e( 'SoCal NextGen Youth Ministries', 'socalnextgen' ); ?></p>
			<h1 class="mb-5 text-5xl leading-[0.88] md:text-7xl lg:text-8xl">
				<span class="block"><?php esc_html_e( 'So Cal', 'socalnextgen' ); ?></span>
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
