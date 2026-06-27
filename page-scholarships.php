<?php
/**
 * Template Name: Scholarships
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
			'eyebrow' => __( 'Scholarships', 'socalnextgen' ),
			'title'   => __( 'Supporting Students With Purpose', 'socalnextgen' ),
			'intro'   => __( 'Helping graduating seniors pursue the next step in their God-given calling.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Add scholarship eligibility, deadlines, application links, and award information here.', 'socalnextgen' ),
		)
	);
	?>
</main>
<?php
get_footer();
