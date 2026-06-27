<?php
/**
 * Displays an event preview card.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$title       = $args['title'] ?? '';
$description = $args['description'] ?? '';
$url         = $args['url'] ?? '#';
$date        = $args['date'] ?? '';
$month       = $args['month'] ?? '';
$location    = $args['location'] ?? __( 'TBD', 'socalnextgen' );
$image       = $args['image'] ?? '';

?>
<article class="scng-card">
	<a class="block no-underline" href="<?php echo esc_url( $url ); ?>">
		<div class="relative aspect-[16/9] overflow-hidden bg-brand-navy">
			<?php if ( $image ) : ?>
				<img class="h-full w-full object-cover" src="<?php echo esc_url( $image ); ?>" alt="">
			<?php else : ?>
				<img class="h-full w-full object-cover" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/placeholder-ministry.svg' ) ); ?>" alt="">
			<?php endif; ?>
			<div class="absolute left-0 top-0 bg-brand-orange px-4 py-3 text-center font-display font-bold uppercase leading-none text-white">
				<span class="block text-xl"><?php echo esc_html( $month ); ?></span>
				<span class="block text-2xl"><?php echo esc_html( $date ); ?></span>
			</div>
		</div>
		<div class="p-4">
			<h3 class="mb-2 text-lg leading-tight"><?php echo esc_html( $title ); ?></h3>
			<p class="mb-3 text-sm leading-5 text-brand-navy"><?php echo esc_html( $description ); ?></p>
			<p class="flex items-center gap-2 text-xs font-bold uppercase text-brand-navy">
				<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'map-pin', 'class' => 'h-4 w-4 text-brand-orange' ) ); ?>
				<?php echo esc_html( $location ); ?>
			</p>
		</div>
	</a>
</article>
