<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script>document.documentElement.classList.add('scng-js');</script>
	<style id="scng-critical-startup">
		.scng-page-loader{display:none}.scng-js .scng-page-loader{position:fixed;inset:0;z-index:99999;display:grid;place-items:center;background:#071b3a;opacity:1;transition:opacity .32s}.scng-page-loader.is-exiting{pointer-events:none;opacity:0}.scng-page-loader__inner{display:flex;flex-direction:column;align-items:center;gap:1.5rem}.scng-page-loader__logo{width:11rem;height:auto}.scng-page-loader__spinner{width:2rem;height:2rem;border:2px solid rgb(255 255 255/.3);border-top-color:#ff6a00;border-radius:50%;animation:scng-critical-spin .8s linear infinite}@keyframes scng-critical-spin{to{transform:rotate(360deg)}}@media(prefers-reduced-motion:reduce){.scng-page-loader__spinner{animation:none}}.scng-hero-slider,.scng-hero-slide{position:absolute;inset:0;width:100%;height:100%}.scng-hero-slide{opacity:0}.scng-hero-slide:first-child{opacity:1}.scng-hero-slide img{width:100%;height:100%;object-fit:cover}
	</style>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/components/page-loader' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wp-rig' ); ?></a>

	<div class="scng-header-stack">
		<?php get_template_part( 'template-parts/header/utility-bar' ); ?>

		<header id="masthead" class="site-header flex">
			<?php get_template_part( 'template-parts/header/custom_header' ); ?>

			<?php get_template_part( 'template-parts/header/mobile-menu-toggle' ); ?>

			<?php get_template_part( 'template-parts/header/branding' ); ?>

			<?php get_template_part( 'template-parts/header/navigation' ); ?>
		</header><!-- #masthead -->
	</div>
