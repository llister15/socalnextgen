/* global jQuery, scngCommerce */
/**
 * WooCommerce product forms and utility-bar interactions.
 * @param {Function} $ jQuery instance.
 */
(function ($) {
	'use strict';

	const $body = $(document.body);
	const announce = (message) => {
		$('.scng-commerce-status').text(message);
	};
	let refreshTimer;
	const refresh = () => {
		window.clearTimeout(refreshTimer);
		refreshTimer = window.setTimeout(
			() => $body.trigger('wc_fragment_refresh'),
			150
		);
	};
	const broadcast = () => {
		try {
			window.localStorage.setItem(
				'scng-cart-updated',
				String(Date.now())
			);
		} catch {
			// Cart updates also work when browser storage is unavailable.
		}
	};

	// Stop rapid duplicate archive clicks before WooCommerce's delegated handler.
	document.addEventListener(
		'click',
		(event) => {
			const button = event.target.closest('a.ajax_add_to_cart');
			if (button && button.classList.contains('loading')) {
				event.preventDefault();
				event.stopImmediatePropagation();
			}
		},
		true
	);

	$body.on('added_to_cart removed_from_cart', () => {
		broadcast();
	});
	$body.on('added_to_cart', () => announce(scngCommerce.added));
	$body.on('updated_wc_div updated_cart_totals', refresh);
	$body.on('wc_fragments_refreshed wc_fragments_loaded', () => {
		const cart = document.querySelector('.scng-commerce-cart');
		if (cart) {
			announce(cart.getAttribute('aria-label'));
		}
	});
	['wc-blocks_added_to_cart', 'wc-blocks_removed_from_cart'].forEach(
		(name) => {
			document.body.addEventListener(name, () => {
				refresh();
				broadcast();
			});
		}
	);
	window.addEventListener('storage', (event) => {
		if (event.key === 'scng-cart-updated') {
			refresh();
		}
	});
	window.addEventListener('pageshow', (event) => {
		if (event.persisted) {
			refresh();
		}
	});

	// Block cart quantity edits update the data store without classic cart events.
	if (window.wp && window.wp.data) {
		let previousCount;
		window.wp.data.subscribe(() => {
			const cartStore = window.wp.data.select('wc/store/cart');
			if (!cartStore || !cartStore.getCartData) {
				return;
			}
			const count = cartStore.getCartData().itemsCount;
			if (typeof count === 'number' && count !== previousCount) {
				previousCount = count;
				refresh();
				broadcast();
			}
		});
	}

	document.querySelectorAll('.scng-commerce-search').forEach((details) => {
		const close = (restoreFocus = false) => {
			details.open = false;
			if (restoreFocus) {
				details.querySelector('summary').focus();
			}
		};
		details.addEventListener('toggle', () => {
			if (details.open) {
				details.querySelector('input[type="search"]').focus();
			}
		});
		details.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') {
				close(true);
			}
		});
		document.addEventListener('click', (event) => {
			if (!details.contains(event.target)) {
				close();
			}
		});
		details.addEventListener('focusout', (event) => {
			if (event.relatedTarget && !details.contains(event.relatedTarget)) {
				close();
			}
		});
	});

	$body.on(
		'submit',
		'.product-type-simple form.cart, .product-type-variable form.cart',
		function (event) {
			const form = this;
			const button = form.querySelector('.single_add_to_cart_button');
			if (!button || event.isDefaultPrevented()) {
				return;
			}
			event.preventDefault();
			if (
				form.dataset.scngBusy ||
				button.disabled ||
				button.classList.contains('disabled')
			) {
				return;
			}
			if (!form.reportValidity()) {
				return;
			}
			const data = new FormData(form);
			const productId = data.get('add-to-cart') || button.value;
			if (!productId) {
				return;
			}
			// The normal form handler runs before wc-ajax. Avoid processing twice.
			data.delete('add-to-cart');
			data.set('scng_product_id', productId);
			const $form = $(form);
			let $notices = $form.prev('.scng-commerce-notices');
			if (!$notices.length) {
				$notices = $(
					'<div class="scng-commerce-notices" tabindex="-1" role="region"></div>'
				);
				$form.before($notices);
			}
			$notices.empty();
			form.dataset.scngBusy = 'true';
			form.setAttribute('aria-busy', 'true');
			button.disabled = true;
			button.classList.add('loading');

			$.ajax({
				url: scngCommerce.endpoint,
				type: 'POST',
				data,
				processData: false,
				contentType: false,
				dataType: 'json',
				timeout: 30000,
			})
				.done((response) => {
					if (!response || !response.fragments) {
						$notices.text(scngCommerce.error).trigger('focus');
						refresh();
						return;
					}
					Object.entries(response.fragments).forEach(
						([selector, html]) => {
							$(selector).replaceWith(html);
						}
					);
					$notices.html(response.notices || '');
					if (response.error) {
						$notices.trigger('focus');
						refresh();
					} else {
						// Null button avoids adding an extra archive-style View Cart link to the form.
						$body.trigger('added_to_cart', [
							response.fragments,
							response.cart_hash,
							null,
						]);
					}
				})
				.fail(() => {
					$notices.text(scngCommerce.error).trigger('focus');
					// Never retry automatically: the server might already have added the item.
					refresh();
				})
				.always(() => {
					delete form.dataset.scngBusy;
					form.removeAttribute('aria-busy');
					button.disabled = false;
					button.classList.remove('loading');
				});
		}
	);
})(jQuery);
