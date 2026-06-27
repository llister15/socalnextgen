# SoCalNextGen Theme Specification

Status: Approved, implementation in progress
Date: 2026-06-27
Feature Slug: socalnextgen-theme

## Mission Statement

Rebrand the WP Rig theme as `SoCalNextGen` and build a custom classic WordPress theme for SoCal NextGen Youth Ministries. The attached light-theme mockup is the foundation for the actual homepage (`front-page.php`) and the visual system for the rest of the website.

The finished theme will use custom WordPress templates, reusable WP Rig template parts/components, and Tailwind CSS. It will not use page builders or Advanced Custom Fields.

The theme will create its required starter pages and menus on activation without overwriting existing content. It will also surface required-plugin notices in wp-admin for plugin-backed features.

## Current Project Context

- Required configuration check: `config/config.json` is not present in this checkout.
- Available configuration fallback: `config/config.default.json` already defines:
  - `theme.slug`: `socalnextgen`
  - `theme.name`: `SoCalNextGen`
  - `theme.themeType`: `classic`
  - `theme.enableBlocks`: `false`
- Current identity files already partially reflect SoCalNextGen:
  - `style.css`
  - `readme.txt`
  - `config/config.default.json`
- Root `front-page.php` does not currently exist.
- `screenshot.png` exists and is `1200 x 900`; it must be replaced with the logo-based theme screenshot after approval.
- Tailwind CSS is not currently installed/configured in `package.json`, and there is no `tailwind.config.*` file.
- Existing WP Rig CSS source files live in `assets/css/src/` and are compiled by `build-css.js`.
- Starter content is managed by `inc/Starter_Content/Component.php`.
- Required plugin notices are managed by `inc/Plugin_Dependencies/Component.php`.
- Hero slider image URLs and footer social links are managed through the React-based WP Rig Settings page.

## Clarifications Documented

The user has confirmed:

- The attached light-theme mockup should become the actual homepage, not only a style guide.
- The homepage should be the foundation for the design language of the entire site.
- The site should be a custom classic WordPress theme.
- No page builders.
- No ACF.
- Tailwind CSS should be used.
- The homepage should include:
  - Hero section
  - Mission statement
  - Four Pillars
  - Upcoming Events
  - Leadership Hub preview
  - Fine Arts preview
  - Scholarship preview
  - Gallery preview
  - Final Call-to-Action
  - Footer
- Remaining pages should each have custom templates:
  - About
  - Events
  - Event Details
  - Leadership Hub
  - Fine Arts
  - Scholarship
  - Gallery
  - Contact

## Open Approval Questions

These questions do not block drafting this spec, but they should be answered before implementation begins:

1. Events will be managed as a custom post type, with homepage preview compatibility for The Events Calendar when its `tribe_events` post type is available.
2. Gallery images will come from the WordPress Media Library/editor content first. Facebook page photo pulls are supported through the Graph API when `SCNG_FACEBOOK_PAGE_ID` and `SCNG_FACEBOOK_ACCESS_TOKEN` are defined; otherwise the gallery preview links to the Facebook page and uses placeholders if no local media exists.
3. Contact will start with a simple contact/info layout.
4. Homepage will be a hybrid: `front-page.php` controls the main section structure, with editable content areas where practical.
5. Navigation labels are: Home, About, Events, Leadership Hub, Fine Arts, Scholarships, Resources, Contact.
6. Use "Scholarships" plural for navigation and page/template naming.
7. The provided circular NextGen logo is the production logo for header branding and `screenshot.png`.
8. Do not add starter images unless they are clearly placeholders.

## Context Completeness And Confidence

- Context completeness score: 96%
- Implementation confidence score: 96%

Confidence rationale: the design intent, page list, theme type, styling technology, and implementation constraints are clear. Remaining questions are content/data-source decisions and naming details that can be resolved before coding individual templates.

## Design System

The theme will use the approved clean light homepage mockup as the visual source of truth. The target is the professional church/ministry layout with a white header, light hero, navy/orange typography, white and navy section alternation, restrained cards, and subtle shadows only where useful.

Do not use the later decorative promotional screenshot as the front-page target. Avoid blurred decorative lines, floating hero cards, excessive shadows, oversized header logos, random colored backgrounds, and overdone gradients.

Global body, page, and main content backgrounds must remain white or light. Do not apply automatic black/dark backgrounds from `prefers-color-scheme`; intentional navy brand sections such as the pillars, page hero bands, program cards, and footer are allowed.

### Brand Personality

- Youth ministry focused.
- Bright, warm, energetic, welcoming, and structured.
- Southern California visual cues: sunrise/sunset warmth, ocean blue, clean white space, palm/coastal imagery, and bold ministry/event typography.

### Color Palette

Tailwind tokens should be extended with semantic brand colors:

- `brand-navy`: deep navy for headings, navigation, footer, and high-contrast text.
- `brand-orange`: vivid orange for active navigation, primary CTAs, emphasis text, and date badges.
- `brand-gold`: warm gold/yellow for accents and icon backgrounds.
- `brand-sky`: bright coastal blue for wave/accent moments.
- `brand-green`: ministry/service accent used for scholarship/service cards.
- `brand-purple`: creative/fine-arts accent.
- `brand-white`: clean page background.
- `brand-muted`: soft gray-blue text and borders.

Suggested initial values:

```js
colors: {
  brand: {
    navy: '#071b3a',
    orange: '#ff6a00',
    gold: '#ffd23f',
    sky: '#15a9d6',
    green: '#067a3d',
    purple: '#32156b',
    white: '#ffffff',
    muted: '#64748b',
    line: '#d9e2ec'
  }
}
```

### Typography

- Headings: condensed, bold, uppercase display style similar to the mockup.
- Body: readable sans-serif for ministry information, cards, and long-form page text.
- Script accent: limited use for words like "Heart", "Basics", and "Call" in the hero.

Implementation approach:

- Prefer locally enqueued or self-hosted fonts if available.
- If remote fonts are used, they must be documented in the style guide and loaded through the existing `Fonts` component or a WP Rig-approved enqueue path.
- Use Tailwind `fontFamily` tokens:
  - `display`
  - `body`
  - `script`

### Spacing And Layout

- Maximum content width: approximately `1180px`.
- Subpage hero and editable content sections should use the full centered site container, not narrow left-aligned content columns.
- Section spacing:
  - Desktop: generous vertical rhythm, about `64px` to `96px`.
  - Tablet: about `48px` to `72px`.
  - Mobile: about `32px` to `48px`.
- Use full-width white or lightly tinted bands instead of nested decorative cards.
- Cards should use restrained radius, ideally `8px` or less, with subtle shadow and strong image/date composition where relevant.

### Buttons

Primary button:

- Orange background.
- White text.
- Bold uppercase label.
- Slight radius.
- Icon optional.
- Hover/focus state darkens orange and shows an accessible outline.

Secondary button:

- White or transparent background.
- Navy border.
- Navy text.
- Used for "Stay Connected" or lower-priority actions.

Text link CTA:

- Orange text.
- Arrow icon.
- Used for "View Full Calendar", "View Gallery", and similar section-level actions.

### Cards

Event card:

- Image header.
- Date badge in top-left or overlapping image.
- Title, short descriptor, and location.
- Compact, scannable layout.

Feature preview card:

- Strong colored background based on section identity.
- Icon at left or top.
- White text.
- Outline button for secondary navigation.

Pillar item:

- Circular icon badge.
- Short uppercase title.
- One concise supporting sentence.

### Icons

- Use an icon set already present or add a consistent lightweight icon strategy.
- Preferred approach: use inline SVG icons from a curated local set or a small package if approved during implementation.
- Icons needed:
  - Calendar
  - Users/community
  - Prayer/hands
  - Book/Bible
  - Fellowship/group
  - Service/heart
  - Leadership/network
  - Fine Arts/palette
  - Scholarship/graduation cap
  - Mail/phone/location/social

### Imagery

- Header logo should use the provided circular NextGen logo.
- `screenshot.png` should be replaced with a WordPress-compatible screenshot based on the logo/brand.
- Hero imagery uses a lightweight slider. Admins can set slide image URLs in WP Rig Settings with `scng_hero_slide_1_url`, `scng_hero_slide_2_url`, and `scng_hero_slide_3_url`. If settings are empty, the theme looks for files matching `assets/images/hero-slide-*.jpg`, `.jpeg`, `.png`, or `.webp`; `assets/images/HeroImage.jpg` is the final fallback. The overlay should remain subtle so more of the picture is visible while preserving readable text.
- Gallery/event imagery should use clear ministry/event photos, Facebook page photos when API credentials are configured, or generated placeholders approved by the user.

## Page Hierarchy

Primary navigation:

1. Home
2. About
3. Events
4. Leadership Hub
5. Fine Arts
6. Scholarships
7. Resources
8. Contact

Requested custom templates:

- Home (`front-page.php`)
- About (`page-about.php`)
- Events (`page-events.php`)
- Event Details (`single-scng_event.php` for the theme custom post type, with The Events Calendar template compatibility when the plugin is installed)
- Leadership Hub (`page-leadership-hub.php`)
- Fine Arts (`page-fine-arts.php`)
- Scholarships (`page-scholarships.php`)
- Gallery (`page-gallery.php`)
- Contact (`page-contact.php`)
- Weekly Services archive (`archive-weekly-service.php`)
- Weekly Service detail (`single-weekly-service.php`)

Weekly Services custom post type:

- Post type key: `weekly-service`
- Label: Weekly Services
- Supports: title, editor, featured image, excerpt, revisions, custom fields
- Meta groups: Service Information, Schedule, Location, Livestream, Pastor/Speaker, Ministry Information, Call to Action, Display Settings
- Featured active services can appear on the homepage through `template-parts/sections/weekly-services-preview.php`.

Resources uses `page-resources.php`.

On theme activation, create or reuse these pages by slug:

- `home`
- `about`
- `events`
- `leadership-hub`
- `fine-arts`
- `scholarships`
- `resources`
- `gallery`
- `contact`

Set `home` as the static front page and create/assign these menus if no menu is already assigned:

- `Primary`: Home, About, Events, Leadership Hub, Fine Arts, Scholarships, Resources, Contact
- `Footer Quick Links`: About, Events, Leadership Hub, Fine Arts, Scholarships, Resources, Contact

## Homepage Structure

`front-page.php` will include:

1. Hero
   - Header/navigation above.
   - Large So Cal NextGen Youth Ministries headline.
   - Tagline: "Back to Heart. Back to Basics. Back to the Call."
   - Primary CTA: View Upcoming Events.
   - Secondary CTA: Stay Connected.
   - Hero image with youth/cross/sunset visual.

2. Mission Statement
   - Icon badge.
   - Bold statement: "Building strong believers today to create a strong church tomorrow."
   - Supporting ministry paragraph.

3. Four Pillars
   - Prayer
   - Word
   - Fellowship
   - Service

4. Upcoming Events
   - Four event cards.
   - Section CTA to full calendar/events page.

5. Preview Cards
   - Leadership Hub
   - Fine Arts
   - Scholarship Program

6. Gallery Preview
   - Horizontal responsive image grid.
   - CTA to Gallery.

7. Final Call-to-Action
   - Strong invitation to connect, attend, or partner.
   - Primary CTA to Contact/Stay Connected.

8. Footer
   - Logo and summary.
   - Social links managed in WP Rig Settings: `scng_facebook_url`, `scng_instagram_url`, `scng_youtube_url`, and `scng_footer_email`.
   - Quick links from a WordPress-managed `Footer Quick Links` menu location.
   - Upcoming event teaser.
   - Contact details.
   - Social links.
   - Legal links.

## WordPress Template Architecture

The theme remains a classic WP Rig theme.

### Root Templates

Planned root templates:

- `front-page.php`
- `page-about.php`
- `page-events.php`
- `single-scng_event.php`
- `archive-scng_event.php`
- `page-leadership-hub.php`
- `page-fine-arts.php`
- `page-scholarships.php`
- `page-resources.php`
- `page-gallery.php`
- `page-contact.php`

### Template Parts

Use `template-parts/` for reusable sections instead of duplicating markup:

- `template-parts/layout/page-hero.php`
- `template-parts/sections/mission.php`
- `template-parts/sections/pillars.php`
- `template-parts/sections/events-preview.php`
- `template-parts/sections/program-cards.php`
- `template-parts/sections/gallery-preview.php`
- `template-parts/sections/final-cta.php`
- `template-parts/cards/event-card.php`
- `template-parts/cards/program-card.php`
- `template-parts/cards/pillar-card.php`
- `template-parts/components/button.php`
- `template-parts/components/icon.php`

### Components

New WP Rig PHP components should be scaffolded with `npm run create-rig-component` when they own behavior beyond template markup.

Likely components:

- `Events` if events are approved as a custom post type.
- `Starter_Content` to create required pages/menus on activation.
- `Plugin_Dependencies` to notify admins when required plugins are missing.

Required plugins:

- The Events Calendar (`the-events-calendar/the-events-calendar.php`) is required for the full calendar-management experience. The theme keeps the `scng_event` CPT fallback for resilience, but wp-admin should show an actionable notice until the plugin is installed and active.

Do not manually create files in `inc/` until the implementation plan confirms which components are needed and scaffolding is run through the WP Rig tool.

### Page Content Priority

WP editor content should remain available for page-specific body content where reasonable. The homepage and custom landing templates may include structured theme-controlled sections, but long-form content areas should call the page content when it supports maintainability.

Recommended hybrid:

- Use template-controlled hero/section structure for the designed experience.
- Use `the_content()` in page templates for editable introductory/body areas.
- Avoid ACF; if content needs structured editing later, prefer native blocks only if block support is enabled in a future phase, or use core WordPress data structures.

## Tailwind Component Organization

Tailwind must be integrated into the WP Rig build in a way that preserves existing scripts and validation.

### Planned Files

- `tailwind.config.js`
- PostCSS/Tailwind integration in the CSS build path, or a dedicated Tailwind input/output path documented during implementation.
- `assets/css/src/global.css` remains the global stylesheet entry.
- Existing partials may remain for WP Rig base styles while Tailwind utilities/components handle the new system.

### Tailwind Layers

Use Tailwind layers for project conventions:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  /* typography, body, headings, focus defaults */
}

@layer components {
  /* .scng-button, .scng-card, .scng-section, .scng-container */
}

@layer utilities {
  /* small brand-specific helpers only when needed */
}
```

### Naming Strategy

Reusable classes should use a clear project prefix:

- `.scng-container`
- `.scng-section`
- `.scng-button`
- `.scng-button-primary`
- `.scng-button-secondary`
- `.scng-card`
- `.scng-event-card`
- `.scng-program-card`
- `.scng-pillars-grid`
- `.scng-page-hero`

This keeps templates readable and avoids massive class strings in repeated PHP partials.

## Responsive Behavior

### Desktop

- Header: horizontal navigation with logo left and CTA right.
- Hero: text anchored left with large background/hero image extending right/full width.
- Mission: icon, statement, and paragraph in a horizontal layout.
- Pillars: four columns.
- Events: four-column card grid.
- Preview cards: three columns.
- Gallery: five-item horizontal grid.
- Footer: multi-column layout.

### Tablet

- Header: navigation may wrap or switch to mobile menu depending on available width.
- Hero: preserve image impact; text remains readable with a clean, subtle overlay as needed.
- Pillars: two-by-two grid.
- Events: two-column grid.
- Preview cards: stacked or two-column depending on width.
- Footer: two-column layout.

### Mobile

- Header: compact logo and mobile menu.
- Hero: stacked or background image with a clean readability overlay; CTA buttons stack.
- Typography scales down without viewport-based font sizing.
- Pillars: single column or two compact columns if readable.
- Events: single-column cards.
- Preview cards and gallery: single-column/scroll-safe layout.
- Footer: single column.

Accessibility requirements:

- All text/image overlays must meet WCAG contrast.
- All CTAs and nav controls need visible focus states.
- Skip link remains available.
- Images need meaningful alt text or empty alt when decorative.
- Reduced-motion preference must be honored for animations.

## Implementation Plan After Approval

1. Confirm open approval questions.
2. Update or create `.ai/STYLE-GUIDE.md` to match this design system.
3. Create `config/config.json` with project overrides if approved, rather than relying only on `config/config.default.json`.
4. Replace `screenshot.png` with a logo-based WordPress theme screenshot.
5. Install/configure Tailwind CSS inside the WP Rig build.
6. Add Tailwind tokens and component classes.
7. Build shared template parts.
8. Implement `front-page.php`.
9. Implement remaining templates page by page.
10. Add The Events Calendar compatibility where the plugin is active, while preserving the theme `scng_event` CPT fallback.
11. Configure Facebook Graph API credentials when page photo pulls are required in production.
12. Run builds and validation after each major phase.

## Verification Plan

Required before final submission:

- `npm run build`
- `npm run lint:css`
- `npm run lint:js`
- `npm run test:e2e`
- `npm run test:e2e:screenshot`
- `npm run ai:check`

Visual verification:

- Desktop homepage screenshot.
- Tablet viewport screenshot.
- Mobile viewport screenshot.
- Header/navigation interaction check.
- CTA focus/hover state check.

Bundle verification:

- Confirm `screenshot.png` is included by existing export settings.
- If new root-level production folders are added, update export config according to the Theme Bundling skill.

## Approved Implementation Updates

- Hero slider settings should use Media Library image pickers in WP Rig Settings. The settings continue storing image URLs for frontend simplicity, but editors choose or upload images through WordPress media controls instead of manually pasting URLs.

## Approval Gate

No source implementation should begin until this `SPEC.md` is approved by the user. Approval should explicitly confirm:

- Tailwind integration is acceptable.
- The homepage structure matches the mockup.
- The page/template list is correct.
- The remaining open approval questions have acceptable answers or approved assumptions.
