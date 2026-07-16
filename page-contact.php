<?php
/**
 * Template Name: Contact
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
			'eyebrow' => __( 'Contact', 'socalnextgen' ),
			'title'   => __( 'Stay Connected', 'socalnextgen' ),
			'intro'   => __( 'Connect with Socal NextGen for events, resources, leadership support, and ministry opportunities.', 'socalnextgen' ),
		)
	);
	?>
	<section class="scng-section bg-white">
		<div class="scng-container grid gap-8 text-center md:grid-cols-2 md:text-left">
			<div>
				<h2 class="mb-4 text-3xl"><?php esc_html_e( 'Contact Us', 'socalnextgen' ); ?></h2>
				<ul class="space-y-3 text-brand-navy">
					<li><strong><?php esc_html_e( 'Phone:', 'socalnextgen' ); ?></strong> <?php esc_html_e( '(909) 123-4567', 'socalnextgen' ); ?></li>
					<li><strong><?php esc_html_e( 'Email:', 'socalnextgen' ); ?></strong> <a href="mailto:info@socalnextgenym.com">info@socalnextgenym.com</a></li>
					<li><strong><?php esc_html_e( 'Location:', 'socalnextgen' ); ?></strong> <?php esc_html_e( 'Southern California', 'socalnextgen' ); ?></li>
					<li><strong><?php esc_html_e( 'Facebook:', 'socalnextgen' ); ?></strong> <a href="https://www.facebook.com/socalnextgenyouthministries">facebook.com/socalnextgenyouthministries</a></li>
				</ul>
			</div>
			<div class="rounded-lg border border-brand-line bg-slate-50 p-6">
				<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();

						if ( trim( get_the_content() ) ) {
							the_content();
						} else {
							echo '<p>' . esc_html__( 'Add contact instructions, office hours, or future form plugin shortcode here.', 'socalnextgen' ) . '</p>';
						}
					}
				}
				?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
