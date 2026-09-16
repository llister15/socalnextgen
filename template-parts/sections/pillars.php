<?php
/**
 * Homepage four pillars section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$pillars = array(
	array(
		'icon'        => 'prayer',
		'title'       => __( 'Prayer', 'socalnextgen' ),
		'description' => __( "We believe in the power of prayer and pursuing God's presence.", 'socalnextgen' ),
		'tone'        => 'orange',
	),
	array(
		'icon'        => 'spark',
		'title'       => __( 'Word', 'socalnextgen' ),
		'description' => __( 'The Word of God is the foundation of our faith, the source of who we are, and the standard by which we live.', 'socalnextgen' ),
		'tone'        => 'blue',
	),
	array(
		'icon'        => 'users',
		'title'       => __( 'Fellowship', 'socalnextgen' ),
		'description' => __( 'We value authentic relationships and doing life together.', 'socalnextgen' ),
		'tone'        => 'green',
	),
	array(
		'icon'        => 'heart',
		'title'       => __( 'Service', 'socalnextgen' ),
		'description' => __( 'We live to serve others and make an eternal impact.', 'socalnextgen' ),
		'tone'        => 'gold',
	),
);

?>
<section class="scng-section bg-brand-navy text-white">
	<div class="scng-container">
		<div class="mb-10 text-center">
			<p class="scng-eyebrow text-brand-gold"><?php esc_html_e( 'Our Culture', 'socalnextgen' ); ?></p>
			<h2 class="scng-section-heading text-white"><?php esc_html_e( 'The Four Pillars', 'socalnextgen' ); ?></h2>
		</div>
		<div class="grid gap-8 md:grid-cols-4 md:gap-0">
			<?php
			foreach ( $pillars as $pillar ) {
				get_template_part( 'template-parts/cards/pillar-card', null, $pillar );
			}
			?>
		</div>
	</div>
</section>
