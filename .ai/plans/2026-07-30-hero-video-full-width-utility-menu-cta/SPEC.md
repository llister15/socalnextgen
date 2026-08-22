# Hero Video, Full-Width Utility Content, And Menu-Managed CTA

Status: Approved and implemented
Date: 2026-07-30

## Mission Statement

Extend the approved SocalNextGen header and homepage hero so the utility-bar content spans the browser width, the hero supports either an MP4 background or its existing image slider, and the header CTA is fully editable through the Primary WordPress menu.

## Clarifications And Approved Decisions

1. A selected MP4 replaces the image slider; video and images do not rotate together.
2. When no MP4 is selected, the existing image slider remains active.
3. The video autoplays muted, loops continuously, and uses inline playback without visible controls.
4. The first configured slider image is the video poster and fallback.
5. Reduced-motion users receive the poster image instead of autoplaying video.
6. The hardcoded header “Stay Connected” anchor is removed.
7. A Primary menu item with the Navigation Label “Stay Connected” receives the orange CTA treatment.
8. The menu-managed CTA retains normal WordPress menu controls for label, URL, order, and target.
9. The utility-bar background remains edge-to-edge.
10. Utility-bar content is no longer constrained to the 1180px content container; it uses the same responsive horizontal padding as the main header.
11. The requested About, Contact, Giving, NextGen Locator, and Youth Ministries work is deferred to separately planned phases after this contract is complete.

Clarification confidence progression:

- Video replaces slider: 78%.
- Autoplay, looping, inline playback, poster, and reduced-motion fallback: 86%.
- Menu-managed CTA architecture: 92%.
- Full-width utility content behavior: 98%.

## Design Compliance

Relevant `.ai/STYLE-GUIDE.md` sections:

- Layout: full-width bands and responsive horizontal spacing.
- Components: compact utility bar, orange primary CTA, and lightweight hero media.
- Responsive Behavior: compact header and mobile navigation.
- Accessibility: reduced motion, visible focus states, and readable text over media.

The style guide is updated alongside this specification to document:

- Edge-to-edge utility-bar content spacing.
- MP4-or-image hero media priority.
- Required poster, muted autoplay, inline playback, and reduced-motion fallback behavior.
- Primary-menu ownership of the header CTA.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`; theme-scoped Gutenberg blocks are disabled.

Expected source files after approval:

- `inc/Customizer/Component.php`
- `template-parts/sections/home-hero.php`
- `header.php`
- `inc/Nav_Menus/Component.php`
- `assets/css/src/_header.css`
- `assets/css/src/_navigation.css`
- `assets/css/src/_tailwind-input.css`
- `.ai/STYLE-GUIDE.md`

Expected generated artifacts:

- `assets/css/src/_tailwind.css`
- Compiled/minified CSS artifacts produced by the standard WP Rig build.

No new PHP component or front-end JavaScript dependency is required:

- The existing Customizer component owns the MP4 media setting.
- Native HTML video attributes provide muted, looping, inline autoplay.
- The existing Nav Menus component can add a dedicated class to the matching Primary menu item through `nav_menu_css_class`.
- Existing header, navigation, and hero CSS pipelines own the presentation.

## User Stories

- As a site editor, I want to select an MP4 from the Media Library for the homepage hero.
- As a site editor, I want the image slider to remain available whenever no video is selected.
- As a visitor, I want hero media to load without obscuring the headline and calls to action.
- As a visitor who prefers reduced motion, I want a static poster rather than an autoplaying background video.
- As a site editor, I want to change the header CTA label and destination through the Primary menu.
- As a visitor, I want the compact utility-bar content to use the full browser width consistently with the main header.

## Success Metrics

- The utility-bar content aligns with the main header’s responsive side padding at desktop widths.
- The navy utility background remains edge-to-edge.
- The Hero Slider Customizer section accepts an MP4 attachment from the Media Library.
- A valid selected MP4 renders as a decorative background video with `autoplay`, `muted`, `loop`, and `playsinline`.
- The first configured slider image supplies the poster URL.
- The image slider is rendered when no valid MP4 is configured.
- Reduced-motion CSS hides/stops the video presentation and exposes the poster fallback without requiring JavaScript.
- Hero text and buttons remain above the media and readable.
- The hardcoded header CTA no longer exists.
- A Primary menu item labeled “Stay Connected” is rendered with the orange CTA style on desktop and remains usable in the mobile menu.
- Changing that menu item’s URL, order, or target in WordPress is reflected without source edits.
- Existing dropdown/menu behavior is not changed for unrelated Primary items.
- PHP syntax checks, CSS build, CSS lint, visual browser checks, and `git diff --check` pass.
- The mandatory `npm run ai:check` is executed, with any pre-existing environment failures reported separately.

## Technical Plan

1. Capture/inspect the current desktop, mobile, and open-mobile-menu states.
2. Add a sanitized Customizer media setting and MP4-only Media Library control to the existing Hero Slider section.
3. Resolve the selected attachment ID through WordPress attachment APIs and verify its MIME type is `video/mp4`.
4. Update the hero template:
   - Render the video branch when a valid MP4 exists.
   - Apply native muted autoplay, loop, and inline playback attributes.
   - Use the first configured slider image as the poster.
   - Preserve the current image-slider branch when no valid MP4 exists.
5. Add a static poster layer that is available when video playback is unavailable or motion is reduced.
6. Update hero CSS so video and fallback imagery use identical full-width `object-cover` framing and uniform opacity.
7. Update reduced-motion CSS to suppress the video and retain the static poster.
8. Replace the utility bar’s constrained `.scng-container` wrapper behavior with full-width responsive padding matching the main header.
9. Remove the hardcoded CTA from `header.php`.
10. Add a narrowly scoped Primary-menu class filter that marks the “Stay Connected” item for CTA presentation.
11. Update navigation CSS so the marked menu item matches the orange header button on desktop while remaining a normal, accessible link in the mobile menu.
12. Ensure a Stay Connected item exists in the local Primary menu and preserve all other existing menu items.
13. Rebuild Tailwind and compiled CSS.
14. Verify desktop and mobile hero branches, reduced-motion rendering, full-width utility alignment, editable menu CTA behavior, keyboard focus, and mobile navigation.
15. Run the mandatory `npm run ai:check`.

## Implementation Constraints

- Follow:
  - `.ai/skills/architecture/SKILL.md`
  - `.ai/skills/styles/SKILL.md`
  - `.ai/skills/web-designer/SKILL.md`
  - `.ai/skills/feature-planning/SKILL.md`
- Do not add a third-party video player or icon/media dependency.
- Do not autoplay video with sound.
- Do not render video controls for decorative background media.
- Do not combine video and images into one rotating playlist.
- Do not hardcode the CTA destination in a PHP template.
- Preserve unrelated working-tree and menu changes.

## Approval Gate

Context completeness score: 99%.

Implementation confidence score: 98%.

Approved by the user on 2026-07-30.

## Implementation Result

- Utility-bar content now spans the viewport and uses the same responsive horizontal padding as the primary header.
- The Hero Slider Customizer section now accepts a background video selection; only valid MP4 attachments replace the image slider.
- The video branch uses muted autoplay, looping, inline playback, no controls, and the first slider image as its poster/fallback.
- Reduced-motion presentation hides the video and retains the poster.
- The hardcoded header CTA was removed.
- A Primary menu item marked with `scng-menu-cta` receives the desktop orange CTA treatment while remaining a normal mobile menu link.
- The local Primary menu now contains an editable Stay Connected item pointing initially to `/contact/`.
- The existing image-slider branch, MP4 branch, reduced-motion poster, utility alignment, desktop CTA, and mobile CTA were verified in installed Chrome.
- A temporary generated MP4 used for end-to-end testing was removed and the original slider setting restored.
- PHP syntax checks, CSS build, CSS lint, and `git diff --check` pass.
- The mandatory `npm run ai:check` was run but cannot proceed because the repository's configured Playwright web server exits before tests begin.
