<?php
/**
 * Displays a homepage pillar card.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$icon        = $args['icon'] ?? 'spark';
$title       = $args['title'] ?? '';
$description = $args['description'] ?? '';
$tone        = $args['tone'] ?? 'orange';
$tone_class  = array(
	'blue'   => 'bg-blue-700',
	'green'  => 'bg-brand-green',
	'gold'   => 'bg-brand-gold',
	'orange' => 'bg-brand-orange',
)[ $tone ] ?? 'bg-brand-orange';

?>
<article class="px-6 py-3 text-center md:border-r md:border-white/20 last:md:border-r-0">
	<div class="<?php echo esc_attr( $tone_class ); ?> mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full text-white">
		<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => $icon, 'class' => 'h-11 w-11' ) ); ?>
	</div>
	<h3 class="mb-2 text-xl leading-none text-white"><?php echo esc_html( $title ); ?></h3>
	<p class="mx-auto max-w-48 text-sm leading-6 text-white/80"><?php echo esc_html( $description ); ?></p>
</article>
