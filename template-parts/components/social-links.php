<?php
/**
 * Displays configured SocalNextGen social links.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$legacy_settings = get_option( 'wp_rig_theme_settings', array() );
$legacy_settings = is_array( $legacy_settings ) ? $legacy_settings : array();
$class           = $args['class'] ?? 'scng-social-links';
$link_class      = $args['link_class'] ?? 'scng-social-link';
$footer_email    = get_theme_mod( 'scng_footer_email', $legacy_settings['scng_footer_email'] ?? '' );
$links           = array(
	'facebook'  => array(
		'url'   => get_theme_mod( 'scng_facebook_url', $legacy_settings['scng_facebook_url'] ?? '' ),
		'label' => __( 'Socal NextGen on Facebook', 'socalnextgen' ),
	),
	'instagram' => array(
		'url'   => get_theme_mod( 'scng_instagram_url', $legacy_settings['scng_instagram_url'] ?? '' ),
		'label' => __( 'Socal NextGen on Instagram', 'socalnextgen' ),
	),
	'x'         => array(
		'url'   => get_theme_mod( 'scng_x_url', $legacy_settings['scng_x_url'] ?? '' ),
		'label' => __( 'Socal NextGen on X', 'socalnextgen' ),
	),
	'youtube'   => array(
		'url'   => get_theme_mod( 'scng_youtube_url', $legacy_settings['scng_youtube_url'] ?? '' ),
		'label' => __( 'Socal NextGen on YouTube', 'socalnextgen' ),
	),
	'email'     => array(
		'url'   => $footer_email ? 'mailto:' . $footer_email : '',
		'label' => __( 'Email Socal NextGen', 'socalnextgen' ),
	),
);

?>
<div class="<?php echo esc_attr( $class ); ?>">
	<?php foreach ( $links as $icon => $social_link ) : ?>
		<?php if ( $social_link['url'] ) : ?>
			<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $social_link['url'] ); ?>" aria-label="<?php echo esc_attr( $social_link['label'] ); ?>">
				<?php
				get_template_part(
					'template-parts/components/icon',
					null,
					array(
						'name'  => $icon,
						'class' => 'scng-social-link__icon',
					)
				);
				?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
