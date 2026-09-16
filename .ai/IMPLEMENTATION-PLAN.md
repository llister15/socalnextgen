# SocalNextGen Implementation Audit and Checklist

Status: Homepage Customizer media phase implemented; broader roadmap remains in progress
Date: 2026-07-16
Source contract: `.ai/plans/2026-06-27-socalnextgen-theme/SPEC.md`

## Audit Summary

The repository is a classic WP Rig theme with Tailwind CSS integrated. It already contains a custom homepage, shared template parts, starter-content behavior, The Events Calendar preview support, and several page templates. It is not yet aligned with the updated customer contract. The largest architectural gap is that the required native Customizer component exists but is not registered, while overlapping Socal settings currently live in the separate React Options component.

The source worktree was already dirty when this audit began. Existing modifications and deletions must be preserved and reviewed as part of each phase rather than overwritten.

Context completeness: 97%
Implementation confidence: 97%

Implementation must not continue until confidence exceeds 95% and the clarified contract is approved.

## Already Complete

- [x] Classic WP Rig architecture is active in `config/config.json`.
- [x] Theme-scoped blocks are disabled.
- [x] Tailwind CSS dependency, configuration, source input, and build scripts exist.
- [x] Brand design tokens exist for navy, orange, gold, sky, green, purple, muted, and line colors.
- [x] Reusable homepage and card template parts exist.
- [x] `front-page.php` uses template parts rather than one monolithic template.
- [x] The theme-owned `scng_event` component is no longer registered.
- [x] Obsolete `page-events.php`, `single-scng_event.php`, and `archive-scng_event.php` are removed in the current worktree.
- [x] Homepage events query only `tribe_events` and fail safely when it is unavailable.
- [x] The Events Calendar is installed in `wp-content/plugins/the-events-calendar`.
- [x] Existing About, Resources, Scholarships, Contact, and Gallery templates call editor-managed content directly or through `page-content.php`.
- [x] Final CTA heading is already “Let us build the next generation together.”
- [x] Program-card CTA contrast has been corrected in the current worktree.
- [x] Sticky-footer and admin-bar layout fixes are documented as implemented.

## Partially Implemented

- [ ] Hero displays up to three image URLs from the React Options system, but it is CSS-driven, not the required five-slide native Customizer implementation.
- [ ] `inc/Customizer/Component.php` exists, but `inc/Theme.php` does not register it and it contains only a basic section.
- [ ] `inc/EZ_Customizer/Component.php` and `inc/Options/Component.php` are registered, creating unresolved ownership overlap with the required native Customizer.
- [ ] Starter content safely reuses pages and avoids assigned-menu replacement, but still creates and links `leadership-hub` and `fine-arts`.
- [ ] Starter content does not yet create Initiatives, Giving, Merch, or Stay Connected.
- [ ] Desktop and mobile use the same WordPress menu, but the required menu contents and order are not generated yet.
- [ ] Header Stay Connected CTA exists but links to `/contact/` instead of `/stay-connected/`.
- [x] Mission section uses the approved statement and inclusive supporting copy.
- [x] Four Pillars uses the approved “Work” pillar.
- [ ] Homepage events show title, date, location, featured image, and detail link, but do not use official plugin helpers or a dedicated registration URL.
- [ ] Program preview cards still represent Leadership Hub, Fine Arts, and Scholarships rather than separate Initiatives, Resources, and Scholarships previews.
- [ ] Gallery preview exists, but it reads attachments from the currently queried page and contains a legacy Facebook Graph API path; it is not a reliable Gallery-page-managed source.
- [ ] Contact template contains a placeholder phone number and unverified hardcoded email/social values.
- [ ] Gallery and social URLs contain hardcoded public values that have not been customer-verified.
- [ ] Accessibility foundations exist, but slider/carousel keyboard and reduced-motion behavior cannot be verified because those components are not implemented.

## Conflicts With the Current Contract

- [ ] The specification says both that visible content uses “Socal” and that visible social branding uses “SoCal NextGen YM.” The exact boundary must be approved.
- [ ] The style guide says hero and footer values are managed in WP Rig Settings, while the updated contract requires the native Theme Customizer.
- [ ] The existing React Options component stores hero and social settings that overlap the proposed Customizer settings.
- [ ] `page-fine-arts.php` and `page-leadership-hub.php` remain, although the contract requires Initiatives and Resources replacements.
- [ ] `front-page.php` includes Weekly Services, which is absent from the newly mandated homepage order.
- [ ] The mandated homepage order lists Sponsors before Gallery and Community Cards after Gallery, while the earlier request described sponsors under “From Our Community.” Final order needs confirmation.
- [ ] The specification is marked approved but lacks a completed clarification record, explicit design-compliance section, user stories, success metrics, and a confidence score above 95%.
- [ ] The specification incorrectly states that the July 18 milestone has passed; on the audit date, July 18, 2026 is still upcoming.
- [ ] The layout-fixes specification says it is implemented while retaining unanswered approval questions and an approval-needed footer.

## Files To Create

- [ ] `page-initiatives.php`
- [ ] `page-giving.php`
- [ ] `page-merch.php`
- [ ] `page-stay-connected.php`
- [ ] Reusable Initiative section template part(s)
- [ ] Homepage Initiatives preview template part
- [ ] Homepage Resources preview template part
- [ ] Homepage Scholarships preview template part
- [ ] Homepage Sponsors template part
- [ ] Sponsor card/logo template part
- [ ] Conditional hero-slider JavaScript source
- [ ] Sponsor carousel/scrolling-row JavaScript source only if controls require it
- [ ] Targeted tests for starter content, Customizer sanitization, and conditional slider assets

## Files To Update

- [ ] `.ai/plans/2026-06-27-socalnextgen-theme/SPEC.md`
- [ ] `.ai/STYLE-GUIDE.md`
- [ ] `inc/Theme.php`
- [ ] `inc/Customizer/Component.php`
- [ ] `inc/Starter_Content/Component.php`
- [ ] `inc/Scripts/Component.php`
- [ ] `front-page.php`
- [ ] `header.php`
- [ ] `page-about.php`
- [ ] `page-resources.php`
- [ ] `page-scholarships.php`
- [ ] `page-contact.php`
- [ ] `page-gallery.php`
- [ ] `template-parts/sections/home-hero.php`
- [ ] `template-parts/sections/mission.php`
- [ ] `template-parts/sections/pillars.php`
- [ ] `template-parts/sections/events-preview.php`
- [ ] `template-parts/sections/program-cards.php` or replace it with focused preview sections
- [ ] `template-parts/sections/gallery-preview.php`
- [ ] `template-parts/sections/final-cta.php`
- [ ] `template-parts/footer/info.php`
- [ ] Tailwind source and relevant CSS partials
- [ ] E2E screenshot and interaction tests

## Files To Remove After Approval

- [ ] `page-fine-arts.php`
- [ ] `page-leadership-hub.php`

Do not delete corresponding WordPress database content. Stop creating and linking obsolete pages going forward.

## Architectural Decisions

### Customizer ownership

Approved: register and expand the existing `Customizer` WP Rig component as the single owner of Socal-specific customer-editable settings. Move hero, Community images, Sponsors, contact, social, Giving, Merch, and homepage CTA controls out of the sidebar Theme Settings experience. Generic WP Rig settings may remain in the existing Options component. Existing Socal values require a documented compatibility or migration path before their old controls are removed.

Status: approved by the user on 2026-07-16.

### Gallery source

Approved: administrators manage up to 10 approved Community images from the native **SocalNextGen Theme Options** Customizer panel using Media Library controls. The homepage renders configured attachment IDs with `wp_get_attachment_image()` and shows a useful empty state rather than placeholder cards when no images are configured. Do not scrape social platforms or store API tokens in the theme.

Status: approved by the user on 2026-07-16.

### Sponsor storage

Approved: administrators manage up to 12 Sponsor entries from the native **SocalNextGen Theme Options** Customizer panel. Each fixed slot provides a Media Library logo control, optional destination URL, accessible sponsor name, and visibility toggle. Slot order determines display order. This intentionally avoids a complicated Customizer repeater and a theme-owned Sponsor content type.

Status: approved by the user on 2026-07-16.

### Forms

No forms plugin is installed. Do not implement custom processing. Add editor/shortcode integration regions only after the customer selects a forms plugin and supplies scholarship fields, notification recipients, and registration requirements.

Status: blocked by plugin and customer decisions.

## Missing Dependencies and Customer Content

- [ ] Approved forms plugin.
- [ ] Scholarship application fields and workflow.
- [ ] Event registration fields and workflow.
- [ ] Verified form notification recipients.
- [ ] Verified public email address.
- [ ] Verified Facebook, Instagram, YouTube, and optional TikTok URLs.
- [ ] External Merch URL and button label.
- [ ] Online Giving URL, introduction, options, and QR code.
- [ ] Sponsor names, logos, alt text, links, order, and visibility.
- [ ] Approved Gallery images and alt text.
- [ ] Basketball and Volleyball information and images.
- [ ] Fine Arts Festival information and image.
- [ ] Network churches, youth ministries, and contact details.
- [ ] Resources documents, external links, and categories.
- [ ] Next customer review date.

## Phase 1 — Foundation

- [x] Audit repository architecture and current implementation.
- [x] Confirm configuration and Tailwind integration.
- [x] Inventory installed plugins and missing forms dependency.
- [x] Confirm current Events removal state.
- [x] Create this implementation checklist.
- [ ] Resolve branding boundary.
- [x] Approve native Customizer ownership for Socal-specific settings.
- [ ] Approve the saved-value migration strategy.
- [x] Approve Gallery source architecture.
- [x] Approve Sponsor storage architecture.
- [ ] Reconcile and approve the formal specification at >95% confidence.
- [ ] Update the style guide for Customizer, Gallery, Sponsors, carousel behavior, and reduced motion.
- [ ] Run the pre-change validation baseline and record exact failures.

Phase gate: formal specification approved, context completeness and implementation confidence above 95%, architecture decisions documented, and baseline failures separated from new regressions.

## Phase 2 — Navigation and Templates

- [x] Update the Primary menu to About, Initiatives, Resources, Scholarships, Giving, external Merch, and Contact.
- [x] Add a one-time migration for existing assigned Primary menus without deleting page content.
- [x] Create initial Initiatives and Giving page templates.
- [ ] Update starter page definitions to the approved slug list.
- [ ] Update primary and footer starter menu order.
- [ ] Preserve existing assigned menus and user content.
- [ ] Point highlighted Stay Connected actions to `/stay-connected/`.
- [ ] Create Initiatives, Giving, Merch, and Stay Connected templates.
- [ ] Update Resources and Scholarships integration regions.
- [ ] Remove obsolete Fine Arts and Leadership Hub template references/files.
- [ ] Verify `the_content()` on editor-managed pages.
- [ ] Verify desktop and mobile navigation order.

Phase gate: PHP syntax, targeted unit tests, navigation E2E checks, and no destructive activation behavior.

## Phase 3 — Customizer and Homepage

- [x] Register the native Customizer component.
- [x] Remove static and legacy hero image fallbacks when no Customizer slide is selected.
- [x] Add the SocalNextGen Theme Options panel.
- [x] Add editable footer phone, email, location/state, and social controls.
- [x] Add editable footer creator/designer credit text and optional URL.
- [x] Replace the hardcoded footer event teaser with the next future `tribe_events` event.
- [ ] Add five sanitized Hero slide groups and global controls.
- [ ] Add Contact, Social, Giving, Merch, Sponsor/Homepage CTA settings according to approved ownership.
- [ ] Build accessible, conditional hero slider markup and assets.
- [x] Update mission statement and inclusive supporting copy.
- [x] Change pillar “Word” to “Work” with approved icon/copy.
- [ ] Improve The Events Calendar helper/API usage and registration CTA handling.
- [ ] Add Initiatives, Resources, and Scholarships previews.
- [x] Add approved Sponsor output directly below From Our Community.
- [x] Replace Gallery sourcing with Customizer Media Library controls.
- [ ] Confirm Community card contrast.
- [ ] Make final CTA settings editable and link to Stay Connected.
- [ ] Reconcile Weekly Services with the mandated homepage order.

Phase gate: Customizer save/render tests, slider keyboard tests, reduced-motion tests, plugin-active/inactive Events tests, responsive screenshots, and no unnecessary slider JS for zero or one active slide.

## Phase 4 — Pages and Integrations

- [ ] Build four editable Initiative sections with stable section IDs.
- [ ] Complete Resources grouping and download/link presentation.
- [ ] Complete Giving options and QR presentation.
- [ ] Complete Merch landing page without automatic redirect.
- [ ] Complete Stay Connected structure without fabricated organizations.
- [ ] Prepare Scholarship form shortcode region without invented fields.
- [ ] Prepare Event registration integration without custom processing.
- [ ] Verify Contact form region after forms plugin selection.
- [ ] Add narrowly scoped Events Calendar styles/hooks only where required.

Phase gate: editor-managed content verified, external URL behavior verified, forms plugin contract approved, accessibility checks pass.

## Phase 5 — QA and Handoff

- [ ] `npm run build`
- [ ] `npm run lint:css`
- [ ] `npm run lint:js`
- [ ] `npm run test:e2e`
- [ ] `npm run test:e2e:screenshot`
- [ ] `npm run ai:check`
- [ ] Desktop, tablet, and mobile review.
- [ ] Keyboard navigation and focus review.
- [ ] Reduced-motion review.
- [ ] Accessibility audit.
- [ ] Page-speed review.
- [ ] SEO title and description review.
- [ ] External-link validation.
- [ ] Activation test with an existing assigned menu and existing pages.
- [ ] Events Calendar active/inactive tests.
- [ ] Final `npm run ai:check` compliance submission.

Known baseline validation issue: Playwright previously failed because its configured web server exited early. JavaScript lint previously reported existing Prettier and unused-function errors. Re-run and record fresh results before source implementation.

## Clarification Log

1. Pending: exact boundary between internal “Socal” naming and visible “SoCal NextGen YM” branding.
2. Approved: native Customizer is the sole administration screen for Socal-specific settings; generic WP Rig settings may remain in the sidebar Options component. Pending: treatment of existing saved Socal values.
3. Approved: up to 10 Community Media Library image slots in the native Theme Options Customizer panel.
4. Approved: up to 12 fixed Sponsor logo/name/link/visibility slots in the native Theme Options Customizer panel.
5. Pending: whether Weekly Services remains on the homepage and, if so, its exact position.
6. Pending: whether Sponsors appear before Gallery or directly after “From Our Community.”
7. Pending: selected forms plugin and form requirements.
8. Approved: hero slider images must also be managed through Media Library controls in the native Theme Options Customizer panel.
