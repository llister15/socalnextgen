<?php
/**
 * Template Name: Giving
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();
?>
<main id="primary" class="site-main">
	<?php
	get_template_part(
		'template-parts/layout/page-hero',
		null,
		array(
			'eyebrow' => __( 'Giving / Donate', 'socalnextgen' ),
			'title'   => __( 'Invest In The Next Generation', 'socalnextgen' ),
			'intro'   => __( 'Partner with Socal NextGen to support ministry, outreach, and opportunities for young people.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array( 'fallback' => __( 'Add giving options and an online giving link from the WordPress editor.', 'socalnextgen' ) )
	);
	?>
</main>
<?php
get_footer();
