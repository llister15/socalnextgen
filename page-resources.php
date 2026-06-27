<?php
/**
 * Template Name: Resources
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
			'eyebrow' => __( 'Resources', 'socalnextgen' ),
			'title'   => __( 'Tools For Students And Leaders', 'socalnextgen' ),
			'intro'   => __( 'A central place for links, downloads, next steps, and ministry support.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Add resource links, downloads, forms, and helpful next steps here.', 'socalnextgen' ),
		)
	);
	?>
</main>
<?php
get_footer();
