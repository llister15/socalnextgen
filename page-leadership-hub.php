<?php
/**
 * Template Name: Leadership Hub
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
			'eyebrow' => __( 'Leadership Hub', 'socalnextgen' ),
			'title'   => __( 'Resources For Leaders And Churches', 'socalnextgen' ),
			'intro'   => __( 'Training, encouragement, and practical tools for youth leaders serving the next generation.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Add leadership resources, downloads, devotionals, training videos, or links from the WordPress editor.', 'socalnextgen' ),
		)
	);
	?>
</main>
<?php
get_footer();
