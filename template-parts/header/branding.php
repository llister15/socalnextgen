<?php
/**
 * Displays the site branding.
 *
 * @package WP_Rig
 */

namespace WP_Rig\WP_Rig;

?>
<div class="site-branding flex-1">

	<a class="scng-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img class="scng-brand__mark" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="<?php esc_attr_e( 'Socal NextGen Youth Ministries', 'socalnextgen' ); ?>" loading="eager" decoding="async">
		<span class="scng-brand__text">
			<span class="scng-brand__name"><?php esc_html_e( 'Socal NextGen', 'socalnextgen' ); ?></span>
			<span class="scng-brand__tagline"><?php esc_html_e( 'Youth Ministries', 'socalnextgen' ); ?></span>
		</span>
	</a>

	<?php
	// Check if the "Display Site Title and Tagline" customizer setting is checked.
	if ( false && get_theme_mod( 'display_header_text', true ) ) {
		?>

		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>

		<?php
		$wprig_description = get_bloginfo( 'description', 'display' );
		if ( $wprig_description || is_customize_preview() ) :
			?>
			<p class="site-description">
				<?php echo $wprig_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>
		<?php endif; ?>

	<?php } // End of the display_header_text check. ?>

</div>
