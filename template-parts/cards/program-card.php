<?php
/**
 * Displays a program preview card.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$icon        = $args['icon'] ?? 'spark';
$title       = $args['title'] ?? '';
$description = $args['description'] ?? '';
$url         = $args['url'] ?? '#';
$label       = $args['label'] ?? __( 'Learn More', 'socalnextgen' );
$tone        = $args['tone'] ?? 'navy';
$tone_class  = array(
	'navy'   => 'bg-brand-navy',
	'purple' => 'bg-brand-purple',
	'green'  => 'bg-brand-green',
)[ $tone ] ?? 'bg-brand-navy';

?>
<article class="<?php echo esc_attr( $tone_class ); ?> rounded-lg p-7 text-white shadow-card">
	<div class="mb-5 flex items-center gap-4">
		<div class="flex h-14 w-14 items-center justify-center rounded-full border border-white/60">
			<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => $icon, 'class' => 'h-8 w-8' ) ); ?>
		</div>
		<h3 class="text-2xl leading-none text-white"><?php echo esc_html( $title ); ?></h3>
	</div>
	<p class="mb-6 max-w-sm text-sm leading-6 text-white/90"><?php echo esc_html( $description ); ?></p>
	<a class="scng-program-card__cta inline-flex items-center gap-2 rounded border border-white/70 px-4 py-2 font-display text-sm font-bold uppercase no-underline hover:bg-white" href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html( $label ); ?>
		<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'arrow-right', 'class' => 'h-4 w-4' ) ); ?>
	</a>
</article>
