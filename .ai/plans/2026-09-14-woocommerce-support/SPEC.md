# WooCommerce theme support

## Mission and authorization
Implement the user's requested WooCommerce support, utility-bar account/cart/search icons, live quantity badge, theme buttons, and AJAX additions without document navigation. User authorized implementation on 2026-09-14 under the updated planning workflow.

## Defaults
Cart icon links to the configured cart page; account links to My Account; search opens a product-only GET form. Keep commerce controls visible on mobile. Variable product listing links continue to select options on the product page; selected variations and simple products add asynchronously. External/custom product types retain their plugin behavior.

## Architecture and design
Use `npm run create-rig-component "Commerce" --templating` and the automatically registered inc/Commerce/Component.php. Expose header controls through a template tag and template-parts/components/commerce-actions.php, called by template-parts/header/utility-bar.php. Declare WooCommerce and gallery support on after_setup_theme; use WooCommerce wrapper hooks for the theme main container. Preserve editor-owned cart/checkout/account content. Register commerce CSS/JS through wp_rig_css_files and wp_rig_js_files. Use WooCommerce native archive AJAX, a wc-ajax endpoint backed by the native form handler for single products, and WooCommerce fragments for the badge. Load assets only when WooCommerce is active. Do not change database options.

Follow .ai/STYLE-GUIDE.md Colors, Typography, Components, Responsive Behavior, and Accessibility: orange uppercase buttons, navy utility bar, white SVG controls, gold focus/hover, orange count badge. Add these commerce patterns to the style guide. Files: assets/css/src/commerce.css, assets/js/src/commerce.js, component/template above, and existing utility bar/header styles.

## Acceptance and validation
- Account/cart links use configured WooCommerce URLs; search works with keyboard and without JS.
- Simple listing additions and single simple/selected-variable additions update cart count without navigation or page loader; repeated clicks are guarded; stock/variation errors stay visible.
- Preserve WooCommerce validation and extension hooks; no automatic retry after ambiguous network failures.
- Update badge after classic cart events, WooCommerce block events, cache restores and cross-tab cart changes.
- Buttons match on catalog, products, account, classic and block cart/checkout, with visible focus/disabled/loading states.
- Theme remains functional with WooCommerce disabled.
- Build CSS/JS, PHP syntax checks, focused interaction tests, and npm run ai:check. Record unavailable environment prerequisites honestly.

## Relevant skills
[Architecture](../../skills/architecture/SKILL.md), [Components](../../skills/create-component/SKILL.md), [Styles](../../skills/styles/SKILL.md), [Web Designer](../../skills/web-designer/SKILL.md), [E2E](../../skills/e2e-testing/SKILL.md).

## Implementation and verification results
- Implemented Commerce component, template tag, shop wrappers, gallery support, native archive AJAX enablement, and native form-handler delegation for simple/variable product forms. The transported product ID is renamed to avoid the early wp_loaded handler adding an item twice.
- Compiled assets with `npm run build:js` and `node build-css.js` (using the existing generated Tailwind partial).
- PHP syntax checks and targeted ESLint/Stylelint pass. A jsdom interaction harness using the local WordPress jQuery verified variation/quantity payloads, no navigation, repeated submission suppression, returned badge fragments, stock-error focus, no network retry, archive duplicate guard, search Escape/focus, and debounced block cart quantity refresh.
- `npm run ai:check` and `npm run build:css` cannot complete because the pre-existing build references an absent `tailwind.config.js`. No build configuration was changed for this feature.
- Live WooCommerce integration and visual review remain unverified: this local plugins directory contains only index.php, the HTTP server is offline, and browser discovery returned no available browsers.
- Implementation references: [WooCommerce form handler](https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/includes/class-wc-form-handler.php), [native add-to-cart script](https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/client/legacy/js/frontend/add-to-cart.js), [block cart data store](https://developer.woocommerce.com/docs/block-development/reference/data-store/cart/).

- Full CSS lint passes. Full JS lint reports 180 existing errors in other source files; the new commerce script passes its targeted lint check.
