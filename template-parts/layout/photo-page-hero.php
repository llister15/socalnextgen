<?php
/**
 * Photography-led page hero.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$post_id  = (int) ( $args['post_id'] ?? get_queried_object_id() );
$eyebrow  = $args['eyebrow'] ?? __( 'Socal NextGen', 'socalnextgen' );
$title    = $args['title'] ?? get_the_title( $post_id );
$image_id = (int) ( $args['image_id'] ?? get_post_thumbnail_id( $post_id ) );
$style    = '';

if ( $image_id ) {
	$image_url = wp_get_attachment_image_url( $image_id, 'full' );
	$style     = $image_url ? 'background-image: url(\'' . esc_url_raw( $image_url ) . '\');' : '';
}

?>
<section class="scng-photo-hero"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
	<div class="scng-photo-hero__overlay"></div>
	<div class="scng-container scng-photo-hero__content">
		<p class="scng-eyebrow text-brand-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<h1 class="mt-3 text-5xl leading-none text-white md:text-7xl"><?php echo esc_html( $title ); ?></h1>
	</div>
</section>
