<?php
/**
 * Homepage gallery preview section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$facebook_url    = 'https://www.facebook.com/socalnextgenyouthministries';
$facebook_images = array();
$images          = get_attached_media( 'image', get_queried_object_id() );
$images          = array_slice( array_values( $images ), 0, 5 );

if ( ! $images && defined( 'SCNG_FACEBOOK_PAGE_ID' ) && defined( 'SCNG_FACEBOOK_ACCESS_TOKEN' ) ) {
	$facebook_page_id      = constant( 'SCNG_FACEBOOK_PAGE_ID' );
	$facebook_access_token = constant( 'SCNG_FACEBOOK_ACCESS_TOKEN' );
	$transient_key   = 'scng_facebook_gallery_images';
	$facebook_images = get_transient( $transient_key );

	if ( false === $facebook_images ) {
		$request_url = add_query_arg(
			array(
				'fields'       => 'images,link,name',
				'limit'        => 5,
				'access_token' => $facebook_access_token,
			),
			'https://graph.facebook.com/' . rawurlencode( $facebook_page_id ) . '/photos'
		);

		$response        = wp_remote_get( $request_url );
		$facebook_images = array();

		if ( ! is_wp_error( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! empty( $body['data'] ) && is_array( $body['data'] ) ) {
				foreach ( $body['data'] as $photo ) {
					$sources = $photo['images'] ?? array();
					$source  = $sources[0]['source'] ?? '';

					if ( $source ) {
						$facebook_images[] = array(
							'src'  => $source,
							'link' => $photo['link'] ?? $facebook_url,
							'alt'  => $photo['name'] ?? __( 'SoCal NextGen Facebook photo', 'socalnextgen' ),
						);
					}
				}
			}
		}

		set_transient( $transient_key, $facebook_images, defined( 'HOUR_IN_SECONDS' ) ? constant( 'HOUR_IN_SECONDS' ) : 3600 );
	}
}

?>
<section class="bg-white py-8">
	<div class="scng-container">
		<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
			<h2 class="scng-section-heading"><?php esc_html_e( 'From Our Community', 'socalnextgen' ); ?></h2>
			<a class="scng-link-cta" href="<?php echo esc_url( $facebook_url ); ?>">
				<?php esc_html_e( 'View Gallery', 'socalnextgen' ); ?>
				<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'arrow-right', 'class' => 'h-4 w-4' ) ); ?>
			</a>
		</div>
		<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
			<?php if ( $images ) : ?>
				<?php foreach ( $images as $image ) : ?>
					<figure class="aspect-[16/9] overflow-hidden rounded-lg bg-slate-100">
						<?php echo wp_get_attachment_image( $image->ID, 'medium_large', false, array( 'class' => 'h-full w-full object-cover' ) ); ?>
					</figure>
				<?php endforeach; ?>
			<?php elseif ( $facebook_images ) : ?>
				<?php foreach ( $facebook_images as $image ) : ?>
					<figure class="aspect-[16/9] overflow-hidden rounded-lg bg-slate-100">
						<a href="<?php echo esc_url( $image['link'] ); ?>">
							<img class="h-full w-full object-cover" src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
						</a>
					</figure>
				<?php endforeach; ?>
			<?php else : ?>
				<?php for ( $i = 0; $i < 5; $i++ ) : ?>
					<figure class="aspect-[16/9] overflow-hidden rounded-lg bg-slate-100">
						<img class="h-full w-full object-cover" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/placeholder-ministry.svg' ) ); ?>" alt="">
					</figure>
				<?php endfor; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
