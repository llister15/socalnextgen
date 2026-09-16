<?php
/**
 * Accessible commerce actions in the utility bar.
 *
 * @package wp_rig
 */
namespace WP_Rig\WP_Rig;
?>
<div class="scng-commerce-actions">
	<a class="scng-commerce-icon" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'My account', 'socalnextgen' ); ?>">
		<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/></svg>
	</a>
	<?php echo $args['cart']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by the component. ?>
	<details class="scng-commerce-search">
		<summary class="scng-commerce-icon" aria-label="<?php esc_attr_e( 'Search products', 'socalnextgen' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10" cy="10" r="7"/><path d="m15 15 6 6"/></svg>
		</summary>
		<form role="search" method="get" class="scng-commerce-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="scng-product-search"><?php esc_html_e( 'Search products', 'socalnextgen' ); ?></label>
			<div class="scng-commerce-search__fields">
				<input type="search" id="scng-product-search" name="s" placeholder="<?php esc_attr_e( 'Find a product…', 'socalnextgen' ); ?>" required>
				<input type="hidden" name="post_type" value="product">
				<button type="submit"><?php esc_html_e( 'Search', 'socalnextgen' ); ?></button>
			</div>
		</form>
	</details>
	<span class="screen-reader-text scng-commerce-status" role="status" aria-live="polite" aria-atomic="true"></span>
</div>
