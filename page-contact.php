<?php
/**
 * Template Name: Contact
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$contact_phone    = get_theme_mod( 'scng_contact_phone', '760-625-2910' );
$contact_email    = get_theme_mod( 'scng_footer_email', 'socalngym@gmail.com' );
$contact_location = get_theme_mod( 'scng_contact_location', 'Southern California' );

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
			'intro'   => __( 'Connect with SoCal NextGen YM for events, resources, leadership support, partnerships, and ministry opportunities.', 'socalnextgen' ),
		)
	);
	?>
	<section class="scng-section bg-white">
		<div class="scng-container grid gap-8 md:grid-cols-2">
			<div>
				<h2 class="mb-4 text-3xl"><?php esc_html_e( 'Contact Us', 'socalnextgen' ); ?></h2>
				<ul class="space-y-3 text-brand-navy">
					<li><strong><?php esc_html_e( 'Phone:', 'socalnextgen' ); ?></strong> <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a></li>
					<li><strong><?php esc_html_e( 'Email:', 'socalnextgen' ); ?></strong> <a href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></li>
					<li><strong><?php esc_html_e( 'Location:', 'socalnextgen' ); ?></strong> <?php echo esc_html( $contact_location ); ?></li>
					<li><strong><?php esc_html_e( 'Facebook:', 'socalnextgen' ); ?></strong> <a target="_blank" href="https://www.facebook.com/socalnextgenyouthministries">facebook.com/socalnextgenyouthministries</a></li>
					<li><strong><?php esc_html_e( 'Instagram:', 'socalnextgen' ); ?></strong> <a target="_blank" href="https://www.instagram.com/socal_nextgen_ym/">instagram.com/socalnextgen</a></li>
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
