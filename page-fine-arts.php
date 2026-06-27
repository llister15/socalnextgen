<?php
/**
 * Template Name: Fine Arts
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
			'eyebrow' => __( 'Fine Arts', 'socalnextgen' ),
			'title'   => __( 'Develop God-Given Creative Gifts', 'socalnextgen' ),
			'intro'   => __( 'Fine Arts helps students discover, develop, and deploy their gifts for ministry.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Add Fine Arts categories, dates, registration details, and student resources here.', 'socalnextgen' ),
		)
	);
	?>
</main>
<?php
get_footer();
