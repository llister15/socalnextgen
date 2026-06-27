<?php
/**
 * Template Name: Gallery
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
			'eyebrow' => __( 'Gallery', 'socalnextgen' ),
			'title'   => __( 'From Our Community', 'socalnextgen' ),
			'intro'   => __( 'Photos and moments from SoCal NextGen gatherings, events, and ministry life.', 'socalnextgen' ),
		)
	);
	get_template_part(
		'template-parts/layout/page-content',
		null,
		array(
			'fallback' => __( 'Upload gallery images to this page or configure Facebook Graph API credentials to pull page photos.', 'socalnextgen' ),
		)
	);
	get_template_part( 'template-parts/sections/gallery-preview' );
	?>
</main>
<?php
get_footer();
