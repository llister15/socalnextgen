<?php
/**
 * Single event template.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();
?>
<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		$event_date = get_post_meta( get_the_ID(), 'scng_event_date', true );
		$timestamp  = $event_date ? strtotime( $event_date ) : false;
		$location   = get_post_meta( get_the_ID(), 'scng_event_location', true );
		?>
		<section class="bg-brand-navy py-14 text-white">
			<div class="scng-container max-w-4xl">
				<p class="scng-eyebrow text-brand-gold"><?php echo esc_html( $timestamp ? gmdate( 'F j, Y', $timestamp ) : __( 'Event', 'socalnextgen' ) ); ?></p>
				<h1 class="mt-2 text-4xl leading-none text-white md:text-6xl"><?php the_title(); ?></h1>
				<?php if ( $location ) : ?>
					<p class="mt-5 text-lg text-white/80"><?php echo esc_html( $location ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<section class="scng-section bg-white">
			<div class="scng-container grid gap-8 lg:grid-cols-[0.7fr_0.3fr]">
				<article class="prose max-w-none text-brand-navy">
					<?php the_content(); ?>
				</article>
				<aside class="rounded-lg border border-brand-line bg-slate-50 p-6">
					<h2 class="mb-4 text-2xl"><?php esc_html_e( 'Event Details', 'socalnextgen' ); ?></h2>
					<ul class="space-y-3 text-sm text-brand-navy">
						<li><strong><?php esc_html_e( 'Date:', 'socalnextgen' ); ?></strong> <?php echo esc_html( $timestamp ? gmdate( 'F j, Y', $timestamp ) : __( 'TBD', 'socalnextgen' ) ); ?></li>
						<li><strong><?php esc_html_e( 'Location:', 'socalnextgen' ); ?></strong> <?php echo esc_html( $location ?: __( 'TBD', 'socalnextgen' ) ); ?></li>
					</ul>
				</aside>
			</div>
		</section>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
