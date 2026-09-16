# Full-Width Hero, Utility Bar, And Social Icons

Status: Approved and implemented
Date: 2026-07-30

## Mission Statement

Refine the SocalNextGen homepage and global navigation by making rotating hero photography span the full hero width at reduced opacity, adding a compact brand-aligned utility bar, and replacing text-based social abbreviations with accessible inline SVG icons that remain visible on dark surfaces.

## Clarifications And Approved Decisions

1. The visual reference is the utility bar at [AG Youth](https://agyouth.org/): organization identity at left, social links near the center, and secondary links at right.
2. The utility bar identity reads “Socal NextGen.”
3. Social destinations are Facebook, Instagram, X, YouTube, and email, managed through the WordPress Customizer.
4. Secondary links begin with News, Events, and Store and are managed through a dedicated WordPress menu location so labels, URLs, and order remain editable.
5. The existing hero rotation/crossfade remains.
6. Hero images span the complete hero width; the directional white fade/gradient is removed.
7. Hero image opacity starts at approximately 35%, subject to visual and text-contrast verification.
8. The utility bar uses the SocalNextGen palette: deep navy background, white text, muted-white icons, and gold interactive accents.
9. The utility bar is approximately 36–40px tall on desktop.
10. On mobile, “Socal NextGen” remains in the slim bar while social and secondary navigation links move into the existing mobile navigation experience.
11. Recognizable inline SVG icons replace `f`, `ig`, `yt`, and `@` abbreviations in the footer and are reused in the utility bar.
12. Visited-state overrides apply only on dark surfaces such as the utility bar and footer. Normal content links retain the existing global visited color.

Clarification confidence progression:

- Reference supplied: 76%.
- Utility content defined: 82%.
- Editable secondary menu approved: 88%.
- Full-width hero with retained rotation confirmed: 92%.
- Mobile behavior confirmed: 94%.
- Palette and height confirmed: 97%.
- Dark-surface visited scope and real icon treatment confirmed: 98%.

## Design Compliance

Relevant `.ai/STYLE-GUIDE.md` sections:

- Colors: deep navy structure, white-on-dark text, and gold interactive accents.
- Layout: full-width bands with constrained inner content.
- Components: compact utility bar and recognizable inline SVG social icons.
- Responsive Behavior: compact mobile header with nonessential utility actions placed in the existing mobile navigation.
- Accessibility: visible focus states, adequate contrast, accessible link labels, and reduced-motion support.

The style guide is updated alongside this specification to document:

- Full-width, uniformly subdued hero photography without a directional gradient.
- The compact utility-bar pattern.
- Reusable social-icon and dark-surface link behavior.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`. Theme-scoped Gutenberg blocks are disabled, so this work uses the existing classic templates, Customizer component, menu component, icon partial, and CSS sources.

Expected source files after approval:

- `template-parts/sections/home-hero.php`
- `header.php`
- `template-parts/header/navigation.php`
- A reusable header utility/social template part under `template-parts/header/`
- `template-parts/footer/info.php`
- `template-parts/components/icon.php`
- `inc/Customizer/Component.php`
- `inc/Nav_Menus/Component.php`
- `inc/Starter_Content/Component.php` only if required to seed the new menu for development/demo content
- `assets/css/src/_header.css`
- `assets/css/src/_navigation.css`
- `assets/css/src/_links.css`
- `assets/css/src/_tailwind-input.css`
- `.ai/STYLE-GUIDE.md`

Expected generated artifacts:

- `assets/css/src/_tailwind.css`
- Compiled/minified CSS artifacts produced by the standard WP Rig build.

No new PHP component is required. The existing `Customizer` and `Nav_Menus` components own the added settings and menu location. The existing global/header CSS pipeline owns the styling, so no new enqueue hook is required.

## User Stories

- As a visitor, I want the hero photography to fill the entire hero so the homepage feels immersive and balanced.
- As a visitor, I want hero text to remain readable while the background images continue rotating.
- As a visitor, I want quick access to SocalNextGen social channels and utility pages.
- As a site editor, I want to manage social destinations in the Customizer.
- As a site editor, I want to manage the News, Events, and Store links as a normal WordPress menu.
- As a mobile visitor, I want the header to remain compact while all utility links remain accessible.
- As a visitor, I want social icons to remain recognizable and visible before and after I visit their destinations.

## Success Metrics

- Hero images visually cover the complete hero bounds on desktop and mobile with no directional white gradient.
- Hero text and controls remain readable over every configured slide.
- Existing slide timing, crossfade, and reduced-motion behavior remain functional.
- The desktop utility bar stays within the agreed 36–40px range and uses SocalNextGen colors.
- Facebook, Instagram, X, YouTube, and email render as recognizable inline SVG icons with accessible names.
- Social values come from sanitized Customizer settings; the existing Facebook, Instagram, YouTube, and email values remain compatible.
- News, Events, and Store can be assigned and reordered through a dedicated WordPress menu location.
- Mobile users can reach social and secondary links through the existing navigation without horizontal overflow.
- Dark-surface links retain a visible white/muted-white visited state and gold hover/focus state.
- Keyboard focus is clearly visible, icon-only links have meaningful accessible labels, and touch targets remain usable.
- No unrelated user changes are overwritten.
- `npm run ai:check` passes.

## Technical Plan

1. Capture baseline screenshots of the homepage hero, site header, and footer social area using the existing Playwright screenshot workflow.
2. Extend the existing menu component with a dedicated utility/secondary menu location.
3. Extend the existing Contact & Social Customizer section with an X URL while preserving the existing Facebook, Instagram, YouTube, and email setting IDs.
4. Extend the reusable inline icon partial with brand-recognizable Facebook, Instagram, X, YouTube, and email SVG paths.
5. Create a reusable utility-bar template part that:
   - Renders “Socal NextGen” as the home link.
   - Renders configured social destinations.
   - Renders the assigned secondary menu.
   - Omits unset social destinations safely.
6. Place the utility bar before the main header navigation while preserving the current sticky-header/admin-bar behavior.
7. Integrate the social and secondary actions with the current mobile menu at the narrow breakpoint, avoiding a second menu-toggle system.
8. Update the footer social markup to use the same icon partial and explicit component classes.
9. Update dark-surface link styles so `:visited` cannot override the intended footer/utility colors; preserve gold hover/focus styling and visible focus outlines.
10. Update hero layout and styles:
    - Make the slider cover the full hero section at all relevant widths.
    - Remove the directional overlay.
    - Apply approximately 35% uniform image opacity without reducing the opacity of hero text or buttons.
    - Preserve slide crossfade timing and `prefers-reduced-motion` behavior.
11. Rebuild Tailwind and CSS through the project scripts.
12. Verify desktop, tablet, and mobile screenshots plus keyboard navigation, visited states, menu assignment/fallback behavior, and text contrast.
13. Run the mandatory `npm run ai:check` pre-flight validation.

## Implementation Constraints

- Follow the recipes in:
  - `.ai/skills/architecture/SKILL.md`
  - `.ai/skills/styles/SKILL.md`
  - `.ai/skills/web-designer/SKILL.md`
- Prefer existing components and template parts; do not scaffold a new `inc/` component.
- Do not add a third-party icon font or JavaScript icon dependency.
- Do not hardcode the secondary menu URLs into the header.
- Keep page/post content ownership unchanged.
- Preserve unrelated working-tree changes.

## Approval Gate

Context completeness score: 99%.

Implementation confidence score: 98%.

Approved by the user on 2026-07-30.

## Implementation Result

- Full-width hero imagery, uniform 35% image opacity, rotation, and reduced-motion behavior are implemented.
- The responsive SocalNextGen utility bar and editable Header Utility Links menu location are implemented.
- The local WordPress site has an assigned utility menu with News, Events, and Store.
- Facebook, Instagram, X, YouTube, and email use the shared inline SVG social component in the utility bar, mobile menu, and footer.
- Dark-surface visited, hover, and focus colors are explicitly preserved.
- Desktop, mobile, and open-mobile-menu states were verified in installed Chrome against a temporary local WordPress server.
- PHP syntax checks, the CSS build, CSS lint, and `git diff --check` pass.
- The mandatory `npm run ai:check` was run but cannot complete because the repository's configured Playwright web server exits before tests begin. The independent JavaScript lint also reports 183 pre-existing errors in untouched JS/TS files.
