<?php
/**
 * Youth Group directory card.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$post_id  = (int) ( $args['post_id'] ?? 0 );
$pastors  = get_post_meta( $post_id, 'scng_youth_group_pastors', true );
$address  = get_post_meta( $post_id, 'scng_youth_group_address', true );
$city     = get_post_meta( $post_id, 'scng_youth_group_city', true );
$state    = get_post_meta( $post_id, 'scng_youth_group_state', true );
$zip      = get_post_meta( $post_id, 'scng_youth_group_zip', true );
$phone    = get_post_meta( $post_id, 'scng_youth_group_phone', true );
$website  = get_post_meta( $post_id, 'scng_youth_group_website', true );
$complete = (bool) get_post_meta( $post_id, 'scng_youth_group_complete', true );
$locality = trim( implode( ', ', array_filter( array( $city, trim( $state . ' ' . $zip ) ) ) ) );

?>
<article class="scng-card flex h-full flex-col p-5">
	<div class="mb-4 flex items-start gap-4">
		<img class="h-14 w-14 flex-none object-contain" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="" loading="lazy" decoding="async">
		<div>
			<h4 class="text-xl leading-tight"><?php echo esc_html( get_the_title( $post_id ) ); ?></h4>
			<?php if ( $locality ) : ?>
				<p class="mt-1 text-sm font-bold uppercase text-brand-orange"><?php echo esc_html( $locality ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div class="flex-1 space-y-2 text-sm leading-6 text-brand-navy">
		<?php if ( $pastors ) : ?>
			<p><strong><?php esc_html_e( 'Lead Pastor:', 'socalnextgen' ); ?></strong> <?php echo esc_html( $pastors ); ?></p>
		<?php endif; ?>
		<?php if ( $address ) : ?>
			<address class="not-italic"><?php echo esc_html( $address ); ?><br><?php echo esc_html( $locality ); ?></address>
		<?php endif; ?>
		<?php if ( $phone ) : ?>
			<p><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
		<?php endif; ?>
		<?php if ( ! $complete ) : ?>
			<p class="font-bold text-brand-orange"><?php esc_html_e( 'Details coming soon.', 'socalnextgen' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( $website ) : ?>
		<a class="scng-link-cta mt-4" href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Website', 'socalnextgen' ); ?></a>
	<?php endif; ?>
</article>
