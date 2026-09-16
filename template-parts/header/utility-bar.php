<?php
/**
 * Displays the compact utility bar above the primary header.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<div class="scng-utility-bar">
	<div class="scng-utility-bar__inner">
		<a class="scng-utility-bar__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Socal NextGen', 'socalnextgen' ); ?></a>

		<?php
		get_template_part(
			'template-parts/components/social-links',
			null,
			array(
				'class'      => 'scng-social-links scng-utility-bar__socials',
				'link_class' => 'scng-social-link',
			)
		);
		?>

		<div class="scng-utility-bar__actions">
			<?php if ( has_nav_menu( 'utility' ) ) : ?>
				<nav class="scng-utility-nav" aria-label="<?php esc_attr_e( 'Utility menu', 'socalnextgen' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'utility',
							'menu_class'     => 'scng-utility-nav__menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>
			<?php wp_rig()->commerce_actions(); ?>
		</div>
	</div>
</div>
