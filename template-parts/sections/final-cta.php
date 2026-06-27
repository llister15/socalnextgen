<?php
/**
 * Homepage final CTA section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<section class="bg-brand-navy py-14 text-white">
	<div class="scng-container flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
		<div class="max-w-2xl">
			<p class="scng-eyebrow text-brand-gold"><?php esc_html_e( 'Ready To Connect?', 'socalnextgen' ); ?></p>
			<h2 class="mb-3 text-3xl leading-tight text-white md:text-5xl"><?php esc_html_e( 'Let us build the next generation together.', 'socalnextgen' ); ?></h2>
			<p class="text-white/80"><?php esc_html_e( 'Partner with SoCal NextGen for events, resources, leadership development, and ministry opportunities across Southern California.', 'socalnextgen' ); ?></p>
		</div>
		<?php
		get_template_part(
			'template-parts/components/button',
			null,
			array(
				'url'   => home_url( '/contact/' ),
				'label' => __( 'Stay Connected', 'socalnextgen' ),
				'icon'  => 'arrow-right',
			)
		);
		?>
	</div>
</section>
