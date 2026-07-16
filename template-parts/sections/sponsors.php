<?php
/**
 * Homepage sponsor logo section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$sponsors = array();

for ( $index = 1; $index <= 12; $index++ ) {
	$prefix  = "scng_sponsor_{$index}";
	$logo_id = (int) get_theme_mod( "{$prefix}_logo", 0 );
	$visible = (bool) get_theme_mod( "{$prefix}_visible", true );

	if ( ! $logo_id || ! $visible ) {
		continue;
	}

	$sponsors[] = array(
		'logo_id' => $logo_id,
		'name'    => get_theme_mod( "{$prefix}_name", '' ) ?: get_the_title( $logo_id ),
		'url'     => get_theme_mod( "{$prefix}_url", '' ),
	);
}

if ( ! $sponsors ) {
	return;
}

$is_scrolling = count( $sponsors ) >= 4;
$copies       = $is_scrolling ? 2 : 1;

?>
<section class="scng-sponsors border-y border-brand-line bg-slate-50 py-10" aria-labelledby="scng-sponsors-title">
	<div class="scng-container">
		<h2 id="scng-sponsors-title" class="scng-section-heading mb-7 text-center"><?php esc_html_e( 'Our Sponsors', 'socalnextgen' ); ?></h2>
		<div class="scng-sponsors__viewport<?php echo $is_scrolling ? '' : ' scng-sponsors__viewport--static'; ?>"<?php echo $is_scrolling ? ' tabindex="0"' : ''; ?> aria-label="<?php esc_attr_e( 'Sponsor logos', 'socalnextgen' ); ?>">
			<div class="scng-sponsors__track<?php echo $is_scrolling ? '' : ' scng-sponsors__track--static'; ?>">
				<?php for ( $copy = 0; $copy < $copies; $copy++ ) : ?>
					<div class="scng-sponsors__group<?php echo $is_scrolling ? '' : ' scng-sponsors__group--static'; ?>"<?php echo 1 === $copy ? ' aria-hidden="true"' : ''; ?>>
						<?php foreach ( $sponsors as $sponsor ) : ?>
							<?php if ( $sponsor['url'] ) : ?>
								<a class="scng-sponsor" href="<?php echo esc_url( $sponsor['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s', 'socalnextgen' ), $sponsor['name'] ) ); ?>">
									<?php
									echo wp_get_attachment_image(
										$sponsor['logo_id'],
										'medium',
										false,
										array(
											'class' => 'scng-sponsor__logo',
											'alt'   => $sponsor['name'],
										)
									);
									?>
								</a>
							<?php else : ?>
								<div class="scng-sponsor">
									<?php
									echo wp_get_attachment_image(
										$sponsor['logo_id'],
										'medium',
										false,
										array(
											'class' => 'scng-sponsor__logo',
											'alt'   => $sponsor['name'],
										)
									);
									?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>
