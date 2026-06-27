<?php
/**
 * Template part for displaying the footer info
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$facebook_url  = wp_rig()->get_setting( 'scng_facebook_url', 'https://www.facebook.com/socalnextgenyouthministries' );
$instagram_url = wp_rig()->get_setting( 'scng_instagram_url' );
$youtube_url   = wp_rig()->get_setting( 'scng_youtube_url' );
$footer_email  = wp_rig()->get_setting( 'scng_footer_email', 'info@socalnextgenym.com' );

?>

<div class="site-info">
	<div class="scng-container py-10">
		<div class="grid gap-8 md:grid-cols-[1.4fr_0.8fr_1fr_1fr]">
			<div>
				<a class="scng-brand mb-4" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="scng-brand__mark" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="<?php esc_attr_e( 'SoCal NextGen Youth Ministries', 'socalnextgen' ); ?>">
					<span class="scng-brand__text">
						<span class="scng-brand__name text-white"><?php esc_html_e( 'So Cal NextGen', 'socalnextgen' ); ?></span>
						<span class="scng-brand__tagline text-white/80"><?php esc_html_e( 'Youth Ministries', 'socalnextgen' ); ?></span>
					</span>
				</a>
				<p class="max-w-xs text-sm leading-6 text-white/75"><?php esc_html_e( 'Building strong believers today to create a strong church tomorrow.', 'socalnextgen' ); ?></p>
				<div class="mt-5 flex gap-3">
					<?php if ( $facebook_url ) : ?>
						<a class="flex h-9 w-9 items-center justify-center rounded-full border border-white/35 text-sm font-bold text-white no-underline hover:border-brand-gold hover:text-brand-gold" href="<?php echo esc_url( $facebook_url ); ?>" aria-label="<?php esc_attr_e( 'SoCal NextGen on Facebook', 'socalnextgen' ); ?>">f</a>
					<?php endif; ?>
					<?php if ( $instagram_url ) : ?>
						<a class="flex h-9 w-9 items-center justify-center rounded-full border border-white/35 text-sm font-bold text-white no-underline hover:border-brand-gold hover:text-brand-gold" href="<?php echo esc_url( $instagram_url ); ?>" aria-label="<?php esc_attr_e( 'SoCal NextGen on Instagram', 'socalnextgen' ); ?>">ig</a>
					<?php endif; ?>
					<?php if ( $youtube_url ) : ?>
						<a class="flex h-9 w-9 items-center justify-center rounded-full border border-white/35 text-sm font-bold text-white no-underline hover:border-brand-gold hover:text-brand-gold" href="<?php echo esc_url( $youtube_url ); ?>" aria-label="<?php esc_attr_e( 'SoCal NextGen on YouTube', 'socalnextgen' ); ?>">yt</a>
					<?php endif; ?>
					<?php if ( $footer_email ) : ?>
						<a class="flex h-9 w-9 items-center justify-center rounded-full border border-white/35 text-sm font-bold text-white no-underline hover:border-brand-gold hover:text-brand-gold" href="<?php echo esc_url( 'mailto:' . $footer_email ); ?>" aria-label="<?php esc_attr_e( 'Email SoCal NextGen', 'socalnextgen' ); ?>">@</a>
					<?php endif; ?>
				</div>
			</div>

			<nav aria-label="<?php esc_attr_e( 'Footer quick links', 'socalnextgen' ); ?>">
				<h2 class="mb-3 text-sm text-white"><?php esc_html_e( 'Quick Links', 'socalnextgen' ); ?></h2>
				<?php
				if ( has_nav_menu( 'footer_quick_links' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer_quick_links',
							'menu_class'     => 'space-y-1 text-sm text-white/75',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul class="space-y-1 text-sm text-white/75">
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'socalnextgen' ); ?></a></li>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'Events', 'socalnextgen' ); ?></a></li>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/leadership-hub/' ) ); ?>"><?php esc_html_e( 'Leadership Hub', 'socalnextgen' ); ?></a></li>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/fine-arts/' ) ); ?>"><?php esc_html_e( 'Fine Arts', 'socalnextgen' ); ?></a></li>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/scholarships/' ) ); ?>"><?php esc_html_e( 'Scholarships', 'socalnextgen' ); ?></a></li>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'socalnextgen' ); ?></a></li>
					</ul>
					<?php
				}
				?>
			</nav>

			<div>
				<h2 class="mb-3 text-sm text-white"><?php esc_html_e( 'Upcoming Event', 'socalnextgen' ); ?></h2>
				<div class="flex gap-3">
					<img class="h-16 w-20 rounded object-cover" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/placeholder-ministry.svg' ) ); ?>" alt="">
					<div>
						<p class="font-display text-sm font-bold uppercase text-white"><?php esc_html_e( 'NextGen Rally / FAF', 'socalnextgen' ); ?></p>
						<p class="text-xs text-white/70"><?php esc_html_e( 'March 6-7, 2026', 'socalnextgen' ); ?></p>
						<a class="scng-link-cta mt-2 text-brand-gold" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'View All Events', 'socalnextgen' ); ?></a>
					</div>
				</div>
			</div>

			<div>
				<h2 class="mb-3 text-sm text-white"><?php esc_html_e( 'Contact Us', 'socalnextgen' ); ?></h2>
				<ul class="mb-5 space-y-2 text-sm text-white/75">
					<li><?php esc_html_e( '(909) 123-4567', 'socalnextgen' ); ?></li>
					<?php if ( $footer_email ) : ?>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( 'mailto:' . $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a></li>
					<?php endif; ?>
					<li><?php esc_html_e( 'Southern California', 'socalnextgen' ); ?></li>
				</ul>
				<?php
				get_template_part(
					'template-parts/components/button',
					null,
					array(
						'url'   => home_url( '/contact/' ),
						'label' => __( 'Stay Connected', 'socalnextgen' ),
					)
				);
				?>
			</div>
		</div>
	</div>
	<div class="border-t border-white/10 py-4">
		<div class="scng-container flex flex-col gap-2 text-xs text-white/60 sm:flex-row sm:items-center sm:justify-between">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'SoCal NextGen Youth Ministries. All Rights Reserved.', 'socalnextgen' ); ?></p>
			<div class="flex gap-4">
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '' );
				}
				?>
				<a class="hover:text-brand-gold" href="<?php echo esc_url( home_url( '/terms-of-use/' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'socalnextgen' ); ?></a>
			</div>
		</div>
	</div>
</div><!-- .site-info -->
