<?php
/**
 * Template Name: Initiatives
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
			'eyebrow' => __( 'Initiatives', 'socalnextgen' ),
			'title'   => __( 'Equipping The Next Generation', 'socalnextgen' ),
			'intro'   => __( 'Discover opportunities that help young people grow, create, serve, and lead.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array( 'fallback' => __( 'Add Initiative information from the WordPress editor.', 'socalnextgen' ) )
	);
	?>
</main>
<?php
get_footer();
