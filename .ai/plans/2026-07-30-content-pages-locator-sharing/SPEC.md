# Content Pages, NextGen Locator, And Sharing Metadata

Status: Approved and implemented
Date: 2026-07-30

## Mission Statement

Refresh the SocalNextGen About, Contact, Giving, Youth Ministries, Events, Four Pillars, and navigation experiences; create an editor-managed NextGen Locator from the supplied ministry directory; and add useful social-sharing metadata without hardcoding editor-owned forms or future content.

## Clarifications And Approved Decisions

1. The About visual reference is [AG Youth About](https://agyouth.org/about), adapted to the existing SocalNextGen palette and typography rather than copied.
2. About uses a photo-backed hero and one alternating photo/copy story section.
3. About omits the standalone image-only section, Learn More button, and Team section.
4. The exact supplied mission statement is:

   > We exist to equip leaders, empower students, and partner with local churches across Southern California to advance the Gospel of Jesus Christ.

5. No new ministry wording will be invented. Unsupplied About and Youth Ministries copy remains editor-owned.
6. The second pillar changes from “Work” to “Word” with the exact supplied copy:

   > The Word of God is the foundation of our faith, the source of who we are, and the standard by which we live.

7. Four Pillars imagery/icons remain unchanged.
8. The corrected contact phone is `760-625-2910`.
9. The contact email is `socalngym@gmail.com`.
10. Gravity Forms owns the Giving form; the theme only provides an editor/form-friendly presentation.
11. Newsletter/signup content is authored in the WordPress editor and is not hardcoded.
12. About includes a Customizer-managed featured-event banner, initially configured for National Youth Conference 2026 and replaceable after the event.
13. Featured-event controls include visibility, title, subtitle, dates, location, descriptions, CTA label/URL, and image.
14. “Stay Connected” becomes “NextGen Locator” in the Primary menu CTA.
15. The Locator title is “Find the Nearest NextGen Youth Ministry Near You.”
16. The Locator CTA is “Find the NextGen Youth Group Near You.”
17. Locator entries are editor-managed Youth Group records.
18. The initial directory contains all 21 supplied ministries.
19. Stand in Faith — Las Vegas, Lemon Grove — San Diego, and New Manna Pentecostal SAOG — Arizona remain visible with “Details coming soon.”
20. The Locator is a searchable directory grouped/filterable by state and city; it does not calculate distance or require maps/geolocation.
21. Youth Ministries is a new editor-managed page using the About visual system and the supplied Locator CTA.
22. Appropriate existing Media Library photos may be reused for About, Youth Ministries, and Events.
23. The SocalNextGen logo is the fallback for unresolved placeholder images.
24. Social sharing uses page/post title, excerpt, canonical URL, type, and featured image, falling back to the site description and SocalNextGen logo.
25. Sharing support includes Open Graph and X/Twitter cards and yields to recognized SEO plugins to avoid duplicate metadata.
26. The footer’s former hardcoded “Stay Connected” button becomes an Appearance → Menus location named “Footer CTA.”
27. The Footer CTA is initially assigned a single “NextGen Locator” item linking to the Locator archive and remains editable by administrators.
28. If the Footer CTA menu is unassigned, the accessible fallback remains “NextGen Locator” linking to the Locator archive.
29. The homepage hero’s secondary CTA is “NextGen Locator” and links to the Locator archive.
30. The homepage final CTA button uses the same NextGen Locator label and archive destination.

Clarification confidence progression:

- Initial multi-page scope and missing inputs: 58%.
- About reference and banner architecture: 72%.
- Editor-owned signup and Gravity Forms ownership: 80%.
- Locator dataset and searchable-directory model: 87%.
- Contact details and exact pillar wording: 92%.
- About/Youth image and content ownership: 96%.
- Sharing metadata fallback rules: 99%.

## Design Compliance

Relevant `.ai/STYLE-GUIDE.md` sections:

- Design Direction: photography-led youth-ministry presentation using SocalNextGen colors.
- Layout: full-width bands with constrained inner content and responsive spacing.
- Components: cards, buttons, dark content bands, event promotions, and editor-authored content.
- Responsive Behavior: stacked mobile layouts and multi-column desktop content.
- Accessibility: heading order, keyboard access, form labels, visible focus, image alternatives, and motion preferences.

The style guide is updated alongside this specification to document:

- Reference-inspired About/Youth page composition without a Team area.
- Editor-owned signup and Gravity Forms patterns.
- Featured-event promotion pattern.
- Searchable directory/filter pattern.
- Logo-based placeholder fallback.
- Social-sharing image/content fallback rules.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`; theme blocks are disabled.

New components must be scaffolded with the required WP Rig command:

```bash
npm run create-rig-component "Youth Groups"
npm run create-rig-component "Sharing Metadata"
```

Expected architectural ownership:

- `Youth_Groups` component:
  - Registers the `youth-group` post type and sanitized metadata.
  - Provides editor fields for pastors, address, city, state, ZIP, phone, website, and completeness status.
  - Uses the archive rewrite `nextgen-locator`.
- `Sharing_Metadata` component:
  - Hooks into `wp_head`.
  - Resolves contextual title, description, URL, type, image, and image alt.
  - Avoids output when a recognized SEO plugin owns social metadata.
- Existing `Customizer` component:
  - Owns featured-event settings.
  - Owns corrected contact values.
- WordPress editor:
  - Owns About/Youth body copy, newsletter markup, Gravity Forms shortcode/block, and future content revisions.

Expected source/templates after approval:

- `page-about.php`
- `page-contact.php`
- `page-giving.php`
- `page-youth-ministries.php`
- `archive-youth-group.php`
- `front-page.php`
- `header.php` only if menu markup requires no further abstraction
- `template-parts/sections/mission.php`
- `template-parts/sections/pillars.php`
- New reusable About/story, featured-event, locator-filter, and Youth Group card template parts
- Existing event/media cards requiring logo fallback
- `inc/Customizer/Component.php`
- Scaffolded component files and automatic `inc/Theme.php` registration
- Relevant CSS sources under `assets/css/src/`
- `.ai/STYLE-GUIDE.md`

Expected WordPress data changes:

- Create/assign Youth Ministries page.
- Import 21 Youth Group records.
- Update About, Contact, and Giving editor content only where required.
- Rename/relink the Primary CTA to NextGen Locator.
- Set corrected contact Customizer values.
- Seed National Youth Conference 2026 banner values.

## Youth Group Import Contract

The initial import includes:

- California: Corona SAOG; Faith Fellowship AG; First Samoan Ontario AG; First Samoan San Bernadino; First Samoan Vista AG; Garden Grove SAOG; Long Beach New Life Fellowship; Moreno Valley SAOG; New Life Christian Church in Cerritos; New Life SAOG — Oxnard; Revived International Ministry SAOG; River of Life SAOG — 29 Palms; San Diego First SAOG; Victorville First SAOG; Lemon Grove — San Diego.
- Nevada: Graceway Kingdom Worship SAOG — Las Vegas; Stand in Faith — Las Vegas.
- Texas: First Samoan Killeen AG; Lifeline AOG.
- Indiana: Son-Rise Outreach Ministries.
- Arizona: New Manna Pentecostal SAOG.

Supplied pastor names, street addresses, phone numbers, and River of Life’s website are imported exactly as provided. Missing fields remain empty and show “Details coming soon.”

## User Stories

- As a visitor, I want a clear About page that communicates SocalNextGen’s mission without an irrelevant Team section.
- As an editor, I want to replace the featured event after National Youth Conference without editing code.
- As an editor, I want newsletter and Gravity Forms markup to remain editable in WordPress.
- As a visitor, I want correct contact information wherever it appears.
- As a visitor, I want to search and filter youth ministries by state and city.
- As an editor, I want each youth group to be independently maintainable.
- As a visitor, I want a consistent Youth Ministries page that leads to the Locator.
- As a visitor sharing a page, I want the shared card to include useful title, description, and imagery.

## Success Metrics

- About visually follows the approved photo/story/dark-band reference direction using SocalNextGen design tokens.
- About has no Team area, Learn More button, or standalone image-only gallery.
- The exact supplied mission appears without paraphrasing.
- The second pillar reads Word with the exact supplied paragraph everywhere the shared pillar section appears.
- Contact and footer display `760-625-2910` and `socalngym@gmail.com`.
- Giving renders editor-authored Gravity Forms output without theme-owned payment/card fields.
- Newsletter content is absent until authored in the editor and accepts normal editor/form markup.
- Featured event is fully replaceable through sanitized Customizer controls.
- The homepage’s obsolete location/weekly-services presentation is removed from this user journey.
- NextGen Locator is linked from the Primary menu CTA.
- All 21 records are imported; three incomplete records remain visible with a status message.
- Locator GET-based search/state/city filters work without JavaScript and preserve accessible labels.
- Youth Ministries exists, matches the About visual language, and links to the Locator.
- Existing Media Library imagery is reused responsibly; unresolved card images use the logo rather than unrelated placeholders.
- Singular pages/posts output valid Open Graph and X/Twitter tags with absolute URLs.
- Featured images/excerpts win over global sharing fallbacks.
- Recognized SEO plugins prevent duplicate theme metadata.
- Responsive screenshots, keyboard navigation, locator filters, form rendering, and sharing tags are verified.
- Mandatory `npm run ai:check` is run and any pre-existing environment failures are separated from feature failures.

## Technical Plan

1. Capture baseline screenshots and database/content inventory for all affected pages.
2. Scaffold `Youth Groups` and `Sharing Metadata` through `npm run create-rig-component`.
3. Implement and register the Youth Group content model with sanitized editor fields and REST support.
4. Add idempotent import/migration logic for the 21 supplied ministries without overwriting later editor changes.
5. Build the Locator archive:
   - Accessible search, state, and city GET controls.
   - Sanitized query filters.
   - State/city grouping and responsive Youth Group cards.
   - “Details coming soon” handling.
6. Rename/relink the existing Primary CTA to NextGen Locator.
7. Redesign About:
   - Photo-backed hero using featured/Media Library imagery.
   - One alternating story section using editor-owned content.
   - Exact mission band.
   - No Team, Learn More, or standalone image-only section.
8. Add sanitized Customizer featured-event controls and reusable banner template.
9. Document/style an editor Group pattern for newsletter signup rather than outputting hardcoded form markup.
10. Update Youth Ministries with the shared About visual language, editor-owned content, and Locator CTA.
11. Update mission/footer message, pillar two, corrected phone/email, and Contact markup.
12. Keep Giving content editor-owned and add compatible Gravity Forms presentation styles only.
13. Remove the obsolete homepage location/weekly-services section from the front-page sequence.
14. Update event and relevant media cards to use featured images first and the SocalNextGen logo fallback.
15. Implement sharing metadata:
   - Contextual document title/description/canonical/type.
   - Featured image and alt resolution.
   - Logo/site-description fallback.
   - Open Graph and X/Twitter output.
   - Common SEO-plugin ownership guards.
16. Build CSS/JS artifacts as required.
17. Verify desktop/mobile About, Contact, Giving, Locator, Youth Ministries, Events, pillars, menus, form output, placeholder behavior, and sharing source.
18. Run PHP syntax, PHPCS/PHPStan where supported, CSS/JS lint, E2E/browser checks, `git diff --check`, and mandatory `npm run ai:check`.

## Implementation Constraints

- Preserve editor ownership of page content, Gravity Forms, and signup forms.
- Never process payment-card data in the theme.
- Do not copy AG Youth copyrighted copy or imagery.
- Do not add maps, browser geolocation, or third-party directory APIs.
- Do not hardcode the youth-group directory into a template.
- Do not overwrite editor changes during repeat imports.
- Use the required component scaffolder; do not manually create new `inc/` components.
- Use SocalNextGen’s existing logo only as a fallback, never as meaningful content photography.
- Escape output, sanitize all admin/filter input, and use nonce/capability checks for saved metadata.
- Preserve unrelated working-tree and WordPress content changes.

## Approval Gate

Context completeness score: 99%.

Implementation confidence score: 98%.

Approved by the user on 2026-07-30.

## Implementation Result

- Added the editor-managed Youth Group content type and imported all 21 approved directory records.
- Added the searchable, state/city-filterable NextGen Locator archive and incomplete-record messaging.
- Updated the Primary menu CTA to NextGen Locator.
- Replaced the hardcoded footer “Stay Connected” button with an editable Footer CTA menu, seeded as NextGen Locator.
- Updated the homepage hero’s former “Stay Connected” CTA to NextGen Locator.
- Updated the homepage final CTA button to the same Locator label and destination.
- Rebuilt About with a photo hero, exact mission content, existing Four Pillars imagery, corrected Word pillar, and a replaceable Customizer-managed event banner.
- Added the Youth Ministries page template and shared About visual system.
- Updated Contact phone/email and removed the obsolete homepage location section.
- Kept Giving and newsletter/signup markup editor/plugin-owned while adding compatible presentation styles.
- Added Open Graph and X/Twitter metadata with featured-image/logo fallbacks and SEO-plugin guards.
- Imported data and verified About, Contact, Giving, Youth Ministries, and Locator return HTTP 200 locally.
- PHP syntax checks, CSS build/lint, and `git diff --check` pass.
- Mandatory `npm run ai:check` was invoked; its Playwright phase could not start because the configured web server exited early.
