<?php
/**
 * Template part for displaying the footer info
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$legacy_settings   = get_option( 'wp_rig_theme_settings', array() );
$legacy_settings   = is_array( $legacy_settings ) ? $legacy_settings : array();
$footer_email      = get_theme_mod( 'scng_footer_email', $legacy_settings['scng_footer_email'] ?? '' );
$contact_phone     = get_theme_mod( 'scng_contact_phone', '760-625-2910' );
$contact_location  = get_theme_mod( 'scng_contact_location', 'Southern California' );
$footer_credit     = get_theme_mod( 'scng_footer_credit', __( 'Created and designed by Mber Digital', 'socalnextgen' ) );
$footer_credit_url = get_theme_mod( 'scng_footer_credit_url', '' );
$next_event        = null;

if ( post_type_exists( 'tribe_events' ) ) {
	$next_events = get_posts(
		array(
			'post_type'      => 'tribe_events',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'meta_key'       => '_EventStartDate',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_EventStartDate',
					'value'   => current_time( 'mysql' ),
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
		)
	);
	$next_event  = $next_events[0] ?? null;
}

?>

<div class="site-info">
	<div class="scng-container py-10">
		<div class="grid gap-8 md:grid-cols-[1.4fr_0.8fr_1fr_1fr]">
			<div>
				<a class="scng-brand mb-4" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="scng-brand__mark" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/NextGenLogo.png' ) ); ?>" alt="<?php esc_attr_e( 'Socal NextGen Youth Ministries', 'socalnextgen' ); ?>" loading="lazy" decoding="async">
					<span class="scng-brand__text">
						<span class="scng-brand__name text-white"><?php esc_html_e( 'Socal NextGen', 'socalnextgen' ); ?></span>
						<span class="scng-brand__tagline text-white/80"><?php esc_html_e( 'Youth Ministries', 'socalnextgen' ); ?></span>
					</span>
				</a>
				<p class="max-w-xs text-sm leading-6 text-white/75"><?php esc_html_e( 'Building the generation of today to create a stronger tomorrow.', 'socalnextgen' ); ?></p>
				<?php
				get_template_part(
					'template-parts/components/social-links',
					null,
					array(
						'class'      => 'scng-social-links scng-social-links--footer',
						'link_class' => 'scng-social-link',
					)
				);
				?>
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
				<?php if ( $next_event ) : ?>
					<div class="flex gap-3">
						<?php if ( has_post_thumbnail( $next_event ) ) : ?>
							<a href="<?php echo esc_url( get_permalink( $next_event ) ); ?>" tabindex="-1" aria-hidden="true">
								<?php
								echo get_the_post_thumbnail(
									$next_event,
									'thumbnail',
									array(
										'class'    => 'h-16 w-20 rounded object-cover',
										'alt'      => '',
										'loading'  => 'lazy',
										'decoding' => 'async',
									)
								);
								?>
							</a>
						<?php endif; ?>
						<div>
							<p class="font-display text-sm font-bold uppercase text-white"><?php echo esc_html( get_the_title( $next_event ) ); ?></p>
							<p class="text-xs text-white/70">
								<?php
								if ( function_exists( 'tribe_get_start_date' ) ) {
									echo esc_html( tribe_get_start_date( $next_event->ID, false, 'F j, Y' ) );
								} else {
									echo esc_html( mysql2date( 'F j, Y', get_post_meta( $next_event->ID, '_EventStartDate', true ) ) );
								}
								?>
							</p>
							<a class="scng-link-cta mt-2 text-brand-gold" href="<?php echo esc_url( get_permalink( $next_event ) ); ?>"><?php esc_html_e( 'Event Details', 'socalnextgen' ); ?></a>
						</div>
					</div>
				<?php else : ?>
					<p class="text-sm text-white/70"><?php esc_html_e( 'No upcoming events are scheduled.', 'socalnextgen' ); ?></p>
				<?php endif; ?>
				<a class="mt-3 inline-block text-xs font-bold uppercase text-brand-gold" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'View All Events', 'socalnextgen' ); ?></a>
			</div>

			<div>
				<h2 class="mb-3 text-sm text-white"><?php esc_html_e( 'Contact Us', 'socalnextgen' ); ?></h2>
				<ul class="mb-5 space-y-2 text-sm text-white/75">
					<?php if ( $contact_phone ) : ?>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $footer_email ) : ?>
						<li><a class="hover:text-brand-gold" href="<?php echo esc_url( 'mailto:' . $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $contact_location ) : ?>
						<li><?php echo esc_html( $contact_location ); ?></li>
					<?php endif; ?>
				</ul>
				<?php
				if ( has_nav_menu( 'footer_cta' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer_cta',
							'menu_class'     => 'm-0 list-none p-0',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					get_template_part(
						'template-parts/components/button',
						null,
						array(
							'url'   => home_url( '/nextgen-locator/' ),
							'label' => __( 'NextGen Locator', 'socalnextgen' ),
						)
					);
				}
				?>
			</div>
		</div>
	</div>
	<div class="border-t border-white/10 py-4">
		<div class="scng-container flex flex-col gap-2 text-xs text-white/60 sm:flex-row sm:items-center sm:justify-between">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Socal NextGen Youth Ministries. All Rights Reserved.', 'socalnextgen' ); ?></p>
			<div class="flex flex-wrap gap-4 sm:justify-end">
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '' );
				}
				?>
				<?php if ( $footer_credit ) : ?>
					<?php if ( $footer_credit_url ) : ?>
						<a class="hover:text-brand-gold" href="<?php echo esc_url( $footer_credit_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $footer_credit ); ?></a>
					<?php else : ?>
						<span><?php echo esc_html( $footer_credit ); ?></span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div><!-- .site-info -->
