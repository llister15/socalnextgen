# Page Loader, Slider Startup, and Image Loading Specification

Status: Approved  
Date: 2026-08-16

## Mission Statement

Eliminate the homepage slider’s stacked-image startup flash, provide a branded site-wide loading transition, and improve image-loading behavior without delaying critical above-the-fold imagery.

## Context Assessment

- Context completeness: 100%.
- Implementation confidence: 97%.
- Confirmed loader scope: every front-end page.
- Confirmed loader design: SocalNextGen logo with a small loading indicator.
- Confirmed lifecycle: release on `window.load` with a safety timeout, then fade out.
- Confirmed motion behavior: retain the fade-out for users who prefer reduced motion.
- Confirmed image strategy: header logo and first hero image load eagerly; the first hero image receives high fetch priority; later hero and below-the-fold theme images lazy-load.
- Confirmed content-image strategy: preserve WordPress core’s native loading optimization for editor-authored images.
- Root cause identified: slider positioning and opacity depend on the asynchronously built stylesheet, allowing raw slide markup to briefly participate in normal document flow before those rules apply.

## Design Compliance

This feature follows [`.ai/STYLE-GUIDE.md`](../../STYLE-GUIDE.md) by using the existing logo, navy/white/orange palette, and hero behavior. The style guide will be updated to document the branded loader, slider startup state, and critical-versus-deferred image policy.

The loader must:

- Cover the viewport without layout shift.
- Keep its logo centered and visually clear.
- Sit above the sticky header and page content.
- Fade out quickly without blocking interaction after removal.
- Never trap a visitor if an asset or event fails.
- Avoid adding announcements or focusable controls because it is a decorative transient state.

## Architectural Fit

- Theme type: classic WP Rig theme, per `config/config.json`.
- Critical startup layer: `header.php` establishes the JavaScript-enabled document state and includes the minimal loader/slider rules required before asynchronous CSS is ready.
- Loader markup: a reusable template part under `template-parts/components/` is rendered immediately after `wp_body_open()`.
- Loader behavior: `assets/js/src/global.ts` handles `window.load`, already-complete documents, the safety timeout, fade completion, and DOM removal/state cleanup.
- Loader and slider presentation: source rules live in the existing global Tailwind input/design layer and are rebuilt through WP Rig’s CSS pipeline; only essential anti-flash rules remain critical inline CSS.
- Slider markup: `template-parts/sections/home-hero.php` assigns loading priority based on slide index.
- Theme image markup: existing PHP template parts receive explicit `loading`/`decoding` attributes where appropriate; critical header/hero imagery is explicitly eager.
- Existing WordPress attachment API output remains responsive and benefits from core lazy-loading heuristics unless an explicit critical-image override is required.
- New WP Rig PHP component or content type: none required.
- Hooks/filters: no new global image filter is planned because forcing lazy loading indiscriminately would harm critical images and override WordPress’s context-aware behavior.
- Relevant guidance: [Feature Planning](../../skills/feature-planning/SKILL.md), [Architecture](../../skills/architecture/SKILL.md), [Web Designer](../../skills/web-designer/SKILL.md), and [Styles](../../skills/styles/SKILL.md).

## User Stories

- As a homepage visitor, I want to see one clean hero image during startup instead of stacked slides.
- As a visitor, I want a branded loading state so that incomplete layouts are not briefly exposed.
- As a visitor on a slow connection, I must always regain access to the page even if an asset fails.
- As a visitor, I want critical visible images to appear quickly while offscreen images do not compete for bandwidth.
- As a keyboard or assistive-technology user, I want the loader to remain decorative and never capture focus or block the page after loading.

## Success Metrics

- Before compiled CSS loads, slider slides are layered and only the first slide is visible.
- The loader appears on every JavaScript-enabled front-end page immediately after the body opens.
- The loader displays the SocalNextGen logo, exits at `window.load`, and is forcibly released by a bounded safety timeout.
- Fade completion removes or fully disables the overlay so it cannot intercept pointer or keyboard interaction.
- The loader remains hidden when JavaScript is unavailable, preventing a permanent overlay.
- The first hero image uses `loading="eager"`, `fetchpriority="high"`, and asynchronous decoding; later hero slides use lazy loading.
- The header logo remains eager; clearly below-the-fold theme images use lazy loading and asynchronous decoding.
- WordPress editor images retain core-managed loading behavior.
- No new layout shift, nested interaction, inaccessible status announcement, or uncaught JavaScript error is introduced.
- PHP syntax, TypeScript/JavaScript build, CSS build/lint, focused code checks, screenshot verification when available, and `npm run ai:check` are run; unrelated or environmental failures are documented.

## Technical Contract

### Implementation

1. Add a loader template part containing decorative, non-focusable overlay markup and the existing SocalNextGen logo asset.
2. Render it directly after `wp_body_open()` in `header.php`.
3. Add the smallest possible head-level JavaScript-enabled marker and critical CSS needed to prevent both loader and slider startup flashes. Ensure no-JavaScript visitors never receive a blocking overlay.
4. Add full loader presentation and exit-state rules to the existing global CSS source, including fixed viewport coverage, stacking, centered logo/indicator, opacity transition, and pointer-event release.
5. Add an idempotent loader lifecycle to `assets/js/src/global.ts`: listen for `window.load`, handle scripts executing after load, schedule a bounded fallback, enter the exit state once, and remove the loader after the fade.
6. Update `template-parts/sections/home-hero.php` so the first slide is eager/high-priority and all subsequent slides are lazy. Preserve the current CSS-only animation and reduced-motion behavior.
7. Audit hardcoded and attachment-generated theme images. Explicitly keep branding/first-viewport images eager and add lazy/asynchronous attributes to unambiguously below-the-fold images without overriding WordPress editor-content heuristics.
8. Update `.ai/STYLE-GUIDE.md` with loader, slider startup, and image-priority rules.
9. Rebuild generated JavaScript and CSS assets using the existing WP Rig scripts.

### Verification

1. Run PHP syntax checks on every modified PHP file.
2. Run TypeScript/JavaScript and CSS builds plus relevant linters.
3. Inspect generated markup or source attributes to confirm critical and deferred image priorities.
4. Test loader release for normal `window.load`, already-complete document state, missing loader markup, repeated release calls, and safety-timeout fallback.
5. Capture or inspect the homepage before/after startup state and verify no slide stacking if the development server is available.
6. Verify the loader cannot intercept input after exit and remains non-blocking without JavaScript.
7. Run `git diff --check` on changed files.
8. Run the mandatory `npm run ai:check` pre-flight validation.

## Out of Scope

- Replacing the CSS-only hero slider with a JavaScript carousel or adding navigation controls.
- Lazy-loading the first hero image, header brand, CSS background images, video poster, or other likely Largest Contentful Paint content.
- Overriding WordPress core to force `loading="lazy"` on every editor image regardless of viewport context.
- Adding a progress percentage, network-status messaging, or loader settings UI.
- Redesigning existing images, slider timing, hero copy, or video behavior.
