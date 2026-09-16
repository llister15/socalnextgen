# Back to Top, Link Clarity, and Locator Ordering Specification

Status: Approved  
Date: 2026-08-16

## Mission Statement

Improve site navigation and content clarity by adding a global back-to-top control, making ordinary inline links visually identifiable in every state, and ensuring NextGen Locator groups are alphabetized within their existing geographic organization.

## Context Assessment

- Context completeness: 100%.
- Implementation confidence: 98%.
- Confirmed back-to-top placement: fixed bottom-right on every front-end page.
- Confirmed visibility: hidden near the top and revealed after the visitor scrolls down.
- Confirmed motion: smooth scrolling normally, with an instant accessibility fallback for reduced-motion visitors.
- Confirmed link scope: underline ordinary content links while preserving the current appearance of navigation, buttons, cards, CTAs, and other designed components.
- Confirmed Locator structure: retain state and city headings and sort group titles A–Z within each city.
- Existing Locator context: the base query already requests title ascending, but explicit per-city sorting will guarantee deterministic order after records are grouped.
- Existing link issue: `--color-link-visited` currently matches the navy body text, and ordinary links do not consistently receive a persistent underline.

## Design Compliance

This work follows [`.ai/STYLE-GUIDE.md`](../../STYLE-GUIDE.md) by using the SocalNextGen palette, the existing SVG icon system, persistent focus states, and explicit component scoping. The style guide will be updated with the back-to-top pattern, ordinary-link affordance, visited-link treatment, and Locator ordering rule.

The back-to-top control must:

- Use the existing orange/navy visual language.
- Meet a minimum comfortable pointer target size.
- Provide an accessible name while the arrow SVG remains decorative.
- Be operable by keyboard and display a visible focus state.
- Never cover important footer content unnecessarily.
- Respect reduced-motion preferences.

Ordinary text links must remain recognizable without relying on color alone. Persistent underlining provides the non-color affordance; visited color remains distinct and contrast-compliant.

## Architectural Fit

- Theme type: classic WP Rig theme, per `config/config.json`.
- Global markup: a small reusable back-to-top component is rendered from `footer.php`, making it available across front-end templates.
- Icon system: `template-parts/components/icon.php` receives an `arrow-up` path rather than duplicating SVG markup.
- Global behavior: `assets/js/src/global.ts` handles scroll-based visibility and activation.
- Global component presentation: `assets/css/src/_tailwind-input.css` owns button positioning, transitions, hidden/visible states, and responsive offsets.
- Link presentation: `assets/css/src/_links.css` owns ordinary unvisited/visited/hover link colors and scoped underlines. Selectors exclude existing component/navigation treatments.
- Color tokens: `assets/css/src/_custom-properties.css` supplies a distinct visited-link color using the established palette.
- Locator ordering: `archive-youth-group.php` explicitly sorts each grouped city’s record array by post title after filtering/grouping.
- New WP Rig PHP component, hooks, filters, or content types: none required.
- Relevant guidance: [Feature Planning](../../skills/feature-planning/SKILL.md), [Architecture](../../skills/architecture/SKILL.md), [Web Designer](../../skills/web-designer/SKILL.md), and [Styles](../../skills/styles/SKILL.md).

## User Stories

- As a visitor on a long page, I want a visible back-to-top arrow after scrolling so that I can return to the header quickly.
- As a keyboard user, I want the control to have a clear accessible name and focus state.
- As a reader, I want ordinary links to be identifiable without guessing from color alone.
- As a returning visitor, I want visited links to remain visibly links while differing from unvisited links.
- As a Locator user, I want ministry names listed alphabetically within each city so that records are predictable and easy to scan.

## Success Metrics

- A back-to-top button exists on every front-end page and remains hidden until a meaningful scroll threshold is crossed.
- The button becomes non-interactive while hidden and interactive while visible.
- Clicking or keyboard-activating it returns the document to the top smoothly unless reduced motion is preferred.
- The arrow uses the existing icon template and the control has an accessible text label.
- Ordinary inline content links have a persistent underline in unvisited and visited states.
- Visited ordinary links use a distinct, readable palette color instead of blending into body text.
- Navigation, button, CTA, card, brand, social, footer-navigation, and other established component link appearances remain unchanged.
- Locator state/city grouping remains unchanged and group names are explicitly sorted A–Z within every city after filters are applied.
- PHP syntax, JavaScript and CSS builds/linters, focused diff checks, available visual verification, and `npm run ai:check` are run; unrelated or environmental failures are documented.

## Technical Contract

### Implementation

1. Add `arrow-up` to `template-parts/components/icon.php`.
2. Add a reusable back-to-top button template containing a screen-reader label and decorative arrow icon.
3. Render the component near the end of `footer.php` so all front-end pages receive it.
4. Extend `assets/js/src/global.ts` with an idempotent initialization that toggles visibility after a practical scroll threshold and scrolls to the document top on activation. Use passive scroll observation and reduced-motion-aware behavior.
5. Add global source styles in `assets/css/src/_tailwind-input.css` for fixed placement, adequate target size, hidden/visible states, transitions, hover, visited-independent button appearance, and focus visibility.
6. Update `assets/css/src/_links.css` and the visited-link token so ordinary textual links are underlined and visited links are distinct, using selector scoping that does not override designed link components.
7. In `archive-youth-group.php`, sort each city’s `$groups` array by post title with a case-insensitive natural comparison before rendering.
8. Update `.ai/STYLE-GUIDE.md` with the approved interaction, link, and ordering patterns.
9. Rebuild generated JavaScript and CSS assets.

### Verification

1. Run PHP syntax checks for all modified PHP files.
2. Run the JavaScript build and focused lint for `global.ts`.
3. Run the CSS build and lint.
4. Inspect generated assets for the back-to-top visibility logic and scoped link selectors.
5. Verify the hidden control cannot intercept clicks or keyboard focus and the visible control has an accessible name/focus state.
6. Verify ordinary links are underlined while navigation/buttons/cards retain their designed styles.
7. Verify Locator output sorting using mixed-case and numeric-like names where possible.
8. Run `git diff --check` on changed files.
9. Run the mandatory `npm run ai:check` pre-flight validation.

## Out of Scope

- Removing Locator state/city grouping or changing its filters/cards.
- Redesigning navigation, buttons, cards, CTAs, footer menus, or social links.
- Adding scroll progress, sticky table-of-contents navigation, or a back-to-top settings UI.
- Changing link text or URLs authored in WordPress.
