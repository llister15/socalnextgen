<?php
/**
 * Displays a small inline icon.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$name  = $args['name'] ?? 'spark';
$class = $args['class'] ?? 'h-6 w-6';

$paths = array(
	'calendar'     => '<path d="M8 2v4M16 2v4M3 10h18M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"/>',
	'users'        => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
	'book'         => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"/>',
	'heart'        => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>',
	'palette'      => '<path d="M12 22a10 10 0 1 1 10-10c0 2.2-1.8 4-4 4h-1.5a1.5 1.5 0 0 0 0 3H17a5 5 0 0 1-5 3z"/><circle cx="7.5" cy="10.5" r="1"/><circle cx="10.5" cy="7.5" r="1"/><circle cx="14.5" cy="7.5" r="1"/><circle cx="16.5" cy="11.5" r="1"/>',
	'cap'          => '<path d="m22 10-10-5-10 5 10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/><path d="M22 10v6"/>',
	'map-pin'      => '<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
	'arrow-right'  => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
	'arrow-up'     => '<path d="M12 19V5"/><path d="m5 12 7-7 7 7"/>',
	'prayer'       => '<path d="M8 11V5a2 2 0 0 1 4 0v6"/><path d="M12 11V4a2 2 0 0 1 4 0v10"/><path d="M8 11 5.5 8.5a2 2 0 0 0-3 2.7L9 20h7a4 4 0 0 0 4-4v-2"/>',
	'spark'        => '<path d="M12 2 9 9l-7 3 7 3 3 7 3-7 7-3-7-3-3-7z"/>',
	'facebook'     => '<path d="M13.5 22v-9h3l.5-3.5h-3.5V7.25c0-1.01.28-1.7 1.75-1.7H17V2.42c-.3-.04-1.35-.13-2.57-.13-2.55 0-4.3 1.56-4.3 4.42V9.5H7.25V13h2.88v9h3.37z"/>',
	'instagram'    => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".75" fill="currentColor" stroke="none"/>',
	'x'            => '<path d="M18.9 2H22l-6.78 7.75L23.2 22h-6.25l-4.9-6.4L6.45 22H3.34l7.25-8.29L2.94 2h6.41l4.43 5.86L18.9 2zm-1.1 17.84h1.72L8.41 4.05H6.57L17.8 19.84z"/>',
	'youtube'      => '<rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10 9 5 3-5 3z"/>',
	'email'        => '<rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3.5 6 8.5 7 8.5-7"/>',
);

$filled_icons = array( 'facebook', 'x' );
$is_filled    = in_array( $name, $filled_icons, true );

?>
<svg class="<?php echo esc_attr( $class ); ?>" aria-hidden="true" fill="<?php echo $is_filled ? 'currentColor' : 'none'; ?>" stroke="<?php echo $is_filled ? 'none' : 'currentColor'; ?>" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
	<?php echo $paths[ $name ] ?? $paths['spark']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</svg>
