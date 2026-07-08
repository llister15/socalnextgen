# Layout Fixes: Sticky Footer And Admin Bar Header Offset

Status: Approved and implemented
Date: 2026-07-08

## Mission Statement

Fix two global layout bugs in the SoCalNextGen classic WP Rig theme:

- Keep the footer visually pinned to the bottom of the viewport on pages with little or no content.
- Offset the sticky site header below the WordPress admin bar when a logged-in user is viewing the frontend.
- Stop the header primary menu wrapper from growing beyond the header and pushing page content past the footer.

## Clarifications

Documented decisions and assumptions:

1. The footer should remain in normal document flow, not become `position: fixed`, so it does not cover content.
2. The header should stay sticky and should move below the WordPress admin bar only when WordPress outputs the admin bar.
3. The fix should be theme-level layout CSS, not WordPress admin content changes.
4. The existing header/footer visual design should remain unchanged apart from corrected positioning.
5. The `primary-menu-container flex-grow` class is currently suspect because it applies a generic grow utility to a header wrapper and can stretch layout unexpectedly.

Questions for approval:

1. Should the footer behavior use a flex-column page layout where `#page` fills the viewport and `main.site-main` grows to consume empty space? Recommended: yes.
2. Should the admin bar offset support both standard desktop admin bar height (`32px`) and narrow/mobile admin bar height (`46px`)? Recommended: yes.
3. Should this be scoped to frontend logged-in views via WordPress' `body.admin-bar` class? Recommended: yes.
4. Should the header navigation wrapper stop using the generic `flex-grow` utility and instead rely on header-specific CSS? Recommended: yes.

## Design Compliance

Relevant `.ai/STYLE-GUIDE.md` sections:

- Layout: global body/page/content backgrounds remain white or light.
- Responsive Behavior: compact header on mobile.
- Accessibility: preserve skip link, source order, and normal document flow.

No style guide update is required because this fixes expected global layout behavior without introducing a new visual pattern.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`.

Files expected to change after approval:

- `template-parts/header/navigation.php`
- `assets/css/src/_elements.css`
- `assets/css/src/_header.css`
- `assets/css/src/_navigation.css`

Possible generated files after build/check:

- `assets/css/global.min.css`
- Any WP Rig-generated CSS artifacts required by the build pipeline.

No PHP component or new template is required.

## User Stories

- As a visitor on a short page, I want the footer to sit at the bottom of the browser window so the page does not look unfinished.
- As a logged-in WordPress editor, I want the sticky site header to appear below the admin bar so navigation remains visible and usable.
- As a mobile logged-in editor, I want the header offset to match the taller mobile admin bar.

## Success Metrics

- Short-content pages show the footer at the viewport bottom without adding fake bottom padding.
- Normal long pages still scroll naturally and the footer appears after content.
- Logged-in frontend views with the admin bar show the sticky header below the admin bar at desktop and mobile widths.
- Logged-out frontend views keep the header at the top of the viewport.
- The header navigation container no longer forces excess vertical page height or pushes content past the footer.
- `npm run ai:check` passes.

## Technical Plan

1. Add global min-height/flex layout:
   - Set `html` and `body` to `min-height: 100%`.
   - Set `body` to `min-height: 100vh`.
   - Set `#page.site` to `display: flex`, `flex-direction: column`, and `min-height: 100vh`.
   - Set `#primary.site-main` or `.site-main` to `flex: 1 0 auto`.
   - Set `.site-footer` to `flex-shrink: 0` if needed.

2. Add WordPress admin bar sticky header offset:
   - Keep `.site-header { position: sticky; top: 0; }`.
   - Add `body.admin-bar .site-header { top: 32px; }`.
   - Add mobile override at `max-width: 782px` with `top: 46px`.

3. Fix header navigation growth:
   - Remove the generic `flex-grow` class from `template-parts/header/navigation.php`.
   - Keep `.primary-menu-container` sizing controlled by header/navigation CSS.
   - Ensure desktop header nav can occupy available horizontal space without adding vertical page height.
   - Preserve mobile overlay behavior and scrollable mobile navigation.

4. Verify:
   - Run `npm run ai:check`.
   - If the check does not rebuild CSS artifacts, run the project’s CSS build script according to package scripts and re-check.

## Approval Gate

Implementation confidence: 98%.

This spec needs user approval before source files are modified.
