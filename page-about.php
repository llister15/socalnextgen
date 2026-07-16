<?php
/**
 * Template Name: About
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
			'eyebrow' => __( 'About', 'socalnextgen' ),
			'title'   => __( 'Back To Heart. Back To Basics. Back To The Call.', 'socalnextgen' ),
			'intro'   => __( 'Socal NextGen exists to equip leaders, empower students, and partner with churches across Southern California.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Use this page to share the story, mission, values, and leadership of Socal NextGen Youth Ministries.', 'socalnextgen' ),
		)
	);
	get_template_part( 'template-parts/sections/pillars' );
	?>
</main>
<?php
get_footer();
