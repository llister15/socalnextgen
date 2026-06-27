<?php
/**
 * Displays a SoCal NextGen button.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$url     = $args['url'] ?? '#';
$label   = $args['label'] ?? '';
$variant = $args['variant'] ?? 'primary';
$icon    = $args['icon'] ?? '';

$classes = 'scng-button ';
$classes .= 'secondary' === $variant ? 'scng-button-secondary' : 'scng-button-primary';

?>
<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $url ); ?>">
	<?php if ( $icon ) : ?>
		<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => $icon, 'class' => 'h-5 w-5' ) ); ?>
	<?php endif; ?>
	<span><?php echo esc_html( $label ); ?></span>
</a>
