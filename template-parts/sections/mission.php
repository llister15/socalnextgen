<?php
/**
 * Homepage mission section.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<section class="border-y border-brand-line bg-white py-8">
	<div class="scng-container grid items-center gap-8 md:grid-cols-[120px_1fr_1fr]">
		<div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full border-2 border-brand-orange text-brand-navy">
			<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'users', 'class' => 'h-14 w-14' ) ); ?>
		</div>
		<h2 class="text-2xl leading-tight md:text-3xl">
			<?php esc_html_e( "Building today's generation", 'socalnextgen' ); ?>
			<span class="block text-brand-orange"><?php esc_html_e( 'to create a stronger tomorrow.', 'socalnextgen' ); ?></span>
		</h2>
		<div class="border-brand-orange text-base leading-7 text-brand-navy md:border-l md:pl-8">
			<?php
			if ( is_singular() && trim( get_the_content() ) ) {
				the_content();
			} else {
				?>
				<p><?php esc_html_e( 'Socal NextGen equips and connects young people, leaders, and communities to build a hopeful, purpose-filled future together.', 'socalnextgen' ); ?></p>
				<?php
			}
			?>
		</div>
	</div>
</section>
