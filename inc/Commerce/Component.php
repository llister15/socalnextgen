<?php
/**
 * WooCommerce integration for SocalNextGen.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Commerce;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;

/** Theme support, assets, header fragments and asynchronous product forms. */
class Component implements Component_Interface, Templating_Component_Interface {
	/** @return string Component slug. */
	public function get_slug(): string {
		return 'commerce';
	}

	/** Register integration hooks. */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'support' ) );
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		add_filter( 'wp_rig_css_files', array( $this, 'styles' ) );
		add_filter( 'wp_rig_js_files', array( $this, 'scripts' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'fragments' ) );
		add_filter( 'woocommerce_get_script_data', array( $this, 'script_data' ), 10, 2 );
		add_filter( 'pre_option_woocommerce_enable_ajax_add_to_cart', array( $this, 'enable_ajax' ) );
		add_action( 'wc_ajax_scng_add_to_cart', array( $this, 'add_to_cart' ) );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_end' ), 10 );
	}

	/** @return array Template callbacks. */
	public function template_tags(): array {
		return array( 'commerce_actions' => array( $this, 'actions' ) );
	}

	/** Declare support without requiring the plugin to be active. */
	public function support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/** @param array $files Styles. @return array */
	public function styles( $files ) {
		$files['scng-commerce'] = array( 'file' => 'commerce.min.css', 'global' => true, 'deps' => array( 'wp-rig-global' ) );
		return $files;
	}

	/** @param array $files Scripts. @return array */
	public function scripts( $files ) {
		$files['scng-commerce'] = array(
			'file'     => 'commerce.min.js',
			'global'   => true,
			'footer'   => true,
			'deps'     => array( 'jquery', 'wc-add-to-cart', 'wc-cart-fragments', 'wp-data' ),
			'localize' => array(
				'scngCommerce' => array(
					'endpoint' => \WC_AJAX::get_endpoint( 'scng_add_to_cart' ),
					'error'    => __( 'Unable to confirm the addition. Check your cart before trying again.', 'socalnextgen' ),
					'added'    => __( 'Added to cart.', 'socalnextgen' ),
				),
			),
		);
		return $files;
	}

	/** Keep archive AJAX on the current page without changing stored settings.
	 * @param array  $data Script data.
	 * @param string $handle Script handle.
	 * @return array
	 */
	public function script_data( $data, $handle ) {
		if ( 'wc-add-to-cart' === $handle && is_array( $data ) ) {
			$data['cart_redirect_after_add'] = 'no';
		}
		return $data;
	}

	/** Render plugin-dependent header actions. */
	public function actions() {
		if ( ! function_exists( 'WC' ) ) {
			return;
		}
		get_template_part( 'template-parts/components/commerce-actions', null, array( 'cart' => $this->cart_link() ) );
	}

	/** @return string Escaped cart link, replaced as a single fragment. */
	public function cart_link() {
		$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
		/* translators: %s: Cart item quantity. */
		$label = sprintf( _n( 'Cart: %s item', 'Cart: %s items', $count, 'socalnextgen' ), number_format_i18n( $count ) );
		return '<a class="scng-commerce-cart scng-commerce-icon" href="' . esc_url( wc_get_cart_url() ) . '" aria-label="' . esc_attr( $label ) . '"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M2 3h3l3 12h11l3-9H6M9 20h.01M18 20h.01"/></svg><span class="scng-commerce-count" aria-hidden="true">' . esc_html( $count ) . '</span></a>';
	}

	/** @param array $fragments Cart fragments. @return array */
	public function fragments( $fragments ) {
		$fragments['a.scng-commerce-cart'] = $this->cart_link();
		return $fragments;
	}

	/** Open the theme's main shop container. */
	public function wrapper_start() {
		echo '<main id="primary" class="site-main scng-shop">';
	}

	/** Close the shop container. */
	public function wrapper_end() {
		echo '</main>';
	}

	/** Process a public cart addition using WooCommerce's own form validation. */
	public function add_to_cart() {
		// Like WooCommerce's public add_to_cart endpoint, this changes only the visitor's cart.
		// Rename the product field in transit so wp_loaded cannot process it a second time.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$product_id = isset( $_POST['scng_product_id'] ) ? absint( $_POST['scng_product_id'] ) : 0;
		$product    = wc_get_product( $product_id );
		if ( ! $product || ! $product->is_type( array( 'simple', 'variable' ) ) ) {
			wp_send_json_error( array( 'message' => __( 'Please open the product page to choose this item.', 'socalnextgen' ) ), 400 );
		}
		$_REQUEST['add-to-cart'] = $product_id;
		$_POST['add-to-cart']    = $product_id;
		add_filter( 'woocommerce_add_to_cart_redirect', '__return_false', PHP_INT_MAX );
		add_filter( 'pre_option_woocommerce_cart_redirect_after_add', array( $this, 'no_redirect' ) );
		$before = WC()->cart->get_cart_hash();
		\WC_Form_Handler::add_to_cart_action();
		$added = $before !== WC()->cart->get_cart_hash();
		$error = wc_notice_count( 'error' ) > 0 || ! $added;
		if ( $error && 0 === wc_notice_count( 'error' ) ) {
			wc_add_notice( __( 'This item could not be added. Please check your selection.', 'socalnextgen' ), 'error' );
		}
		$notices = wc_print_notices( true );
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();
		wp_send_json(
			array(
				'error'     => $error,
				'notices'   => $notices,
				'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array( 'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>' ) ),
				'cart_hash' => WC()->cart->get_cart_hash(),
			)
		);
	}

	/** @return string|false Enable frontend archive AJAX, preserving the admin setting. */
	public function enable_ajax() {
		return is_admin() ? false : 'yes';
	}

	/** @return string Disable redirect only during our AJAX request. */
	public function no_redirect() {
		return 'no';
	}
}
