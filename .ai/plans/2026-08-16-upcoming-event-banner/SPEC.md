# Dynamic Upcoming Event Banner Specification

Status: Approved  
Date: 2026-08-16

## Mission Statement

Replace the static National Youth Conference promotion on the About page with a full-browser-width, automatically populated banner for the next upcoming event managed by The Events Calendar.

## Context Assessment

- Context completeness: 100%.
- Implementation confidence: 97%.
- Confirmed quantity: one event—the next published future event ordered by start date.
- Confirmed interaction: the entire banner links to the event detail page.
- Confirmed empty state: render nothing when no future event exists or the `tribe_events` post type is unavailable.
- Confirmed media fallback: use the event featured image, then the SocalNextGen logo.
- Confirmed administration: remove the obsolete featured-event Customizer controls and retain the About story-image control.

## Design Compliance

The banner follows [`.ai/STYLE-GUIDE.md`](../../STYLE-GUIDE.md) by using a full-width content band, established SocalNextGen colors and typography, event photography, responsive stacked/two-column presentation, and the approved logo fallback. Implementation will update the style guide’s Featured Event component entry from an optional Customizer promotion to an automatic upcoming-event banner.

The linked banner must have an obvious hover state and a keyboard-visible `:focus-visible` treatment. Content contrast, image cropping, mobile stacking, and readable fallback presentation must be preserved.

## Architectural Fit

- Theme type: classic WP Rig theme, per `config/config.json`.
- Event source: The Events Calendar’s native `tribe_events` post type and event metadata/helpers.
- Existing template part: `template-parts/sections/featured-event.php` remains the About-page integration point but changes from Customizer-owned content to a dynamic query.
- Existing component: `inc/Customizer/Component.php` removes only `scng_featured_event_*` settings and controls.
- Existing stylesheet: `assets/css/src/_socal-pages.css` owns the banner’s BEM styles and full-width responsive behavior.
- Existing About template: `page-about.php` continues calling the same template part and needs no event-query logic.
- Hooks/filters: none required.
- Scaffolding: none required because this revises existing theme files and introduces no new component or content type.
- Relevant guidance: [Feature Planning](../../skills/feature-planning/SKILL.md), [Architecture](../../skills/architecture/SKILL.md), [Web Designer](../../skills/web-designer/SKILL.md), and [Styles](../../skills/styles/SKILL.md).

## User Stories

- As a visitor, I want the About page to promote the next real event so that the information stays current automatically.
- As a visitor, I want the whole banner to open the event detail page so that it is easy to activate by mouse, touch, or keyboard.
- As an editor, I want the banner to use The Events Calendar content so that I do not maintain duplicate event settings.
- As a visitor, I should not see a stale promotion or empty placeholder when no future event is scheduled.

## Success Metrics

- The hardcoded “National Youth Conference 2026” content no longer appears in the banner template or Customizer defaults.
- The query requests one published `tribe_events` item whose `_EventStartDate` is at or after the current WordPress time, ordered ascending.
- The banner shows the event title, formatted date, venue/location, excerpt when present, and event featured image or logo fallback.
- One semantic link covers the complete banner without nested interactive elements and has a visible keyboard focus state.
- The banner spans the browser width and remains legible and balanced on mobile and desktop.
- The template exits without markup when the plugin/post type or qualifying event is unavailable.
- Query state is reset after event rendering.
- Only the About story-image control remains in the About Customizer section.
- PHP syntax, relevant coding standards, CSS lint/build, and `npm run ai:check` are run; unrelated or environment failures are documented.

## Technical Contract

### Implementation

1. Refactor `template-parts/sections/featured-event.php` to guard on `post_type_exists( 'tribe_events' )`, query the next future event, and return without output if none exists.
2. Read the event title, permalink, excerpt, start date, venue/location, and featured image from the event record. Prefer The Events Calendar date helpers when available and use event metadata as a safe fallback.
3. Render the entire promotion as one escaped event-detail link containing the content and image regions; include no nested link or button.
4. Render the SocalNextGen logo in the media region when the event lacks a featured image.
5. Reset post data after rendering.
6. Update `assets/css/src/_socal-pages.css` so the banner is truly full viewport width, responsive, and clearly interactive through hover and focus-visible states.
7. Remove all `scng_featured_event_*` settings and controls from `inc/Customizer/Component.php`; rename the remaining About section label as appropriate for its story-image-only responsibility.
8. Update `.ai/STYLE-GUIDE.md` to document the automatic next-event source, full-width linked interaction, image fallback, and hidden empty state.

### Verification

1. Run PHP syntax checks on both modified PHP files.
2. Run focused PHPCS checks and inspect the diff for escaping, query reset, and unrelated changes.
3. Build/lint CSS and verify the generated CSS when the project workflow requires it.
4. Run the visual screenshot workflow for the About-page banner if the configured development server is available.
5. Run the mandatory `npm run ai:check` pre-flight validation.

## Out of Scope

- Changing the homepage events grid, footer upcoming-event teaser, or plugin event templates.
- Adding a carousel, multiple events, a manual event selector, or a “No upcoming events” message.
- Retaining manual title, date, location, descriptions, CTA, image, or enable/disable controls for this banner.
- Modifying event records or plugin configuration.
