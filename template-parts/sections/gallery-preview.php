<?php
/**
 * Homepage gallery preview section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$images = array();

for ( $index = 1; $index <= 10; $index++ ) {
	$attachment_id = (int) get_theme_mod( "scng_community_image_{$index}", 0 );
	if ( $attachment_id ) {
		$images[] = $attachment_id;
	}
}

?>
<section class="bg-white py-8">
	<div class="scng-container">
		<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
			<h2 class="scng-section-heading"><?php esc_html_e( 'From Our Community', 'socalnextgen' ); ?></h2>
			<a class="scng-link-cta" href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">
				<?php esc_html_e( 'View Gallery', 'socalnextgen' ); ?>
				<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'arrow-right', 'class' => 'h-4 w-4' ) ); ?>
			</a>
		</div>
		<?php if ( $images ) : ?>
			<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
				<?php foreach ( $images as $attachment_id ) : ?>
					<figure class="aspect-[16/9] overflow-hidden rounded-lg bg-slate-100">
						<?php echo wp_get_attachment_image( $attachment_id, 'medium_large', false, array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="rounded-lg border border-brand-line bg-slate-50 p-6 text-brand-navy">
				<?php esc_html_e( 'Community photos can be added in Customize → SocalNextGen Theme Options → From Our Community.', 'socalnextgen' ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
