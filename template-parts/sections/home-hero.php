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
$hero_video_id     = (int) get_theme_mod( 'scng_hero_video', 0 );
$hero_video_url    = '';
$hero_poster_url   = $hero_slides ? wp_get_attachment_image_url( $hero_slides[0]['attachment_id'], 'full' ) : '';

if ( $hero_video_id && 'video/mp4' === get_post_mime_type( $hero_video_id ) ) {
	$hero_video_url = wp_get_attachment_url( $hero_video_id );
}
?>
<section class="relative overflow-hidden bg-white">
	<?php if ( $hero_video_url ) : ?>
		<div class="scng-hero-video" aria-hidden="true">
			<?php if ( $hero_poster_url ) : ?>
				<div class="scng-hero-video__poster" style="background-image: url('<?php echo esc_url( $hero_poster_url ); ?>');"></div>
			<?php endif; ?>
			<video class="scng-hero-video__media" autoplay muted loop playsinline preload="metadata"<?php echo $hero_poster_url ? ' poster="' . esc_url( $hero_poster_url ) . '"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<source src="<?php echo esc_url( $hero_video_url ); ?>" type="video/mp4">
			</video>
		</div>
	<?php elseif ( $hero_slides ) : ?>
		<div class="scng-hero-slider" aria-hidden="true">
			<?php foreach ( $hero_slides as $index => $slide ) : ?>
				<div class="scng-hero-slide" style="<?php echo esc_attr( 0 === $index ? 'animation-delay: 0s;' : '' ); ?>">
					<?php
					$image_attributes = array(
						'class'    => 'h-full w-full object-cover',
						'decoding' => 'async',
						'loading'  => 0 === $index ? 'eager' : 'lazy',
					);

					if ( 0 === $index ) {
						$image_attributes['fetchpriority'] = 'high';
					}

					echo wp_get_attachment_image( $slide['attachment_id'], 'full', false, $image_attributes );
					?>
				</div>
			<?php endforeach; ?>
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
						'url'     => home_url( '/nextgen-locator/' ),
						'label'   => __( 'NextGen Locator', 'socalnextgen' ),
						'variant' => 'secondary',
						'icon'    => 'users',
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
