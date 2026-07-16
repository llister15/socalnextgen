<?php
/**
 * The front page template for Socal NextGen.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/sections/home-hero' );
	get_template_part( 'template-parts/sections/mission' );
	get_template_part( 'template-parts/sections/weekly-services-preview' );
	get_template_part( 'template-parts/sections/pillars' );
	get_template_part( 'template-parts/sections/events-preview' );
	get_template_part( 'template-parts/sections/program-cards' );
	get_template_part( 'template-parts/sections/gallery-preview' );
	get_template_part( 'template-parts/sections/sponsors' );
	get_template_part( 'template-parts/sections/final-cta' );
	?>
</main><!-- #primary -->

<?php
get_footer();
