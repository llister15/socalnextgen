<?php
/**
 * Displays the decorative site-wide page loader.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<div class="scng-page-loader" aria-hidden="true">
	<div class="scng-page-loader__inner">
		<img class="scng-page-loader__logo" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="" loading="eager" decoding="async">
		<span class="scng-page-loader__spinner"></span>
	</div>
</div>
