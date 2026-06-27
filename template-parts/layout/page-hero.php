<?php
/**
 * Displays a simple page hero.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$eyebrow = $args['eyebrow'] ?? __( 'SoCal NextGen', 'socalnextgen' );
$title   = $args['title'] ?? get_the_title();
$intro   = $args['intro'] ?? '';

?>
<section class="bg-brand-navy py-14 text-white">
	<div class="scng-container text-center">
		<p class="scng-eyebrow text-brand-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<h1 class="mx-auto mt-2 max-w-5xl text-4xl leading-none text-white md:text-6xl"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $intro ) : ?>
			<p class="mx-auto mt-5 max-w-3xl text-lg leading-8 text-white/80"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
	</div>
</section>
