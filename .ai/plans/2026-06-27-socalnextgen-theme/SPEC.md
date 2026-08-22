# SocalNextGen Theme — Updated Development Plan

**Status:** Approved for implementation  
**Project:** SocalNextGen Youth Ministries  
**Theme Base:** WP Rig classic theme  
**Feature Slug:** `socalnextgen-theme`

## 1. Project Direction

Build a custom classic WordPress theme using WP Rig and Tailwind CSS.

The theme will:

- Use reusable PHP template parts and WP Rig components.
- Avoid page builders.
- Avoid Advanced Custom Fields.
- Use WordPress pages, menus, the Theme Customizer, and plugin-owned content where appropriate.
- Keep page content editable through the WordPress editor.
- Use The Events Calendar for all event content through the native `tribe_events` post type.
- Use **Socal** as one word throughout the codebase, theme labels, documentation, and visible website content.
- Use the public-facing brand name **SoCal NextGen YM** where required by the customer.

## 2. Primary Navigation

The desktop and mobile Primary menu order must be:

1. About
2. Initiatives
3. Resources
4. Scholarships
5. Giving
6. Merch
7. Contact

### Navigation Rules

- Rename **Fine Arts** to **Initiatives**.
- Rename **Leadership Hub** to **Resources**.
- Do not keep a second separate Resources navigation item.
- Do not create or add an Events page to the navigation.
- The Events Calendar owns the `/events/` route.
- Merch may link to an external merchandise website.
- Verify the same order on desktop and mobile.
- Keep Home accessible through the linked site logo rather than a Primary menu item.
- Keep **Stay Connected** as a separate highlighted header action rather than a Primary menu item.

## 3. Page Architecture

Create or reuse these WordPress pages during theme activation:

- `home`
- `about`
- `initiatives`
- `resources`
- `scholarships`
- `giving`
- `merch`
- `contact`
- `stay-connected`
- `gallery`

Set `home` as the static front page.

### Root Templates

Create:

- `front-page.php`
- `page-about.php`
- `page-initiatives.php`
- `page-resources.php`
- `page-scholarships.php`
- `page-giving.php`
- `page-merch.php`
- `page-contact.php`
- `page-stay-connected.php`
- `page-gallery.php`

Do not create:

- `page-events.php`
- `single-scng_event.php`
- `archive-scng_event.php`

The Events Calendar controls the event archive and single-event routes.

## 4. Theme Activation and Starter Content

Update `inc/Starter_Content/Component.php` so activation:

- Creates only the approved pages.
- Reuses existing pages by slug.
- Never overwrites existing page content.
- Assigns the Home page as the static front page.
- Creates the Primary and Footer menus only when needed.
- Does not create an Events page.
- Does not register a custom event post type.
- Does not add Events to starter menus.

### Primary Menu

- About
- Initiatives
- Resources
- Scholarships
- Giving
- Merch — external link to `https://socalpuleganextgenym.com/`
- Contact

### Footer Quick Links

- About
- Initiatives
- Resources
- Scholarships
- Giving
- Merch
- Contact
- Stay Connected

## 5. Homepage Structure

`front-page.php` will contain the following sections in this order.

### 5.1 Hero Slider

- Full-width responsive hero slider.
- Managed from the WordPress Theme Customizer.
- Supports desktop and optional mobile images.
- Displays customer-approved youth ministry messaging.
- Includes primary and secondary CTA buttons.
- Must preserve image visibility while maintaining readable text contrast.

### 5.2 Mission Statement

Replace the old message with:

> Building today's generation to create a stronger tomorrow.

Supporting copy should be youth-focused, welcoming, and inclusive rather than limited only to church members.

### 5.3 Four Pillars

Keep the Four Pillars section with:

- Prayer
- Work
- Fellowship
- Service

### 5.4 Upcoming Events

- Query upcoming events directly from `tribe_events`.
- Use The Events Calendar APIs or helpers where available.
- Order by the event start date.
- Display up to four upcoming events.
- Show featured image, event title, date, location, and CTA.
- Link to the plugin-managed `/events/` archive.
- Support event registration links when available.
- Show a graceful empty state when no upcoming events exist.
- Remain error-free when The Events Calendar is inactive.

### 5.5 Initiatives Preview

Display previews for:

- Fine Arts
- Youth Alive
- Speed the Light
- AG Athletics

Each preview should link to the Initiatives page or a relevant section anchor.

### 5.6 Resources Preview

Replace the old Leadership Hub preview with Resources.

Possible content:

- Ministry training
- Leadership tools
- Downloadable documents
- Resource categories

### 5.7 Scholarships Preview

- Scholarship summary.
- Application CTA.
- Link to the Scholarships page.

### 5.8 Sponsors

- Horizontal scrolling sponsor logo section.
- Sponsor logos may be clickable.
- Pause movement on hover and keyboard focus.
- Respect reduced-motion preferences.
- Allow sponsor logos and URLs to be managed from WordPress.

### 5.9 Gallery / Social Photos

- Homepage gallery or slider.
- Use approved Facebook and Instagram photos.
- Clean and optimize images before upload.
- Prefer locally stored Media Library images for performance and reliability.
- Social API integrations may be added where credentials are available.
- Provide a fallback when external social feeds are unavailable.

### 5.10 Community Cards

Cards shown above the **From Our Community** section must use:

- White headings.
- White body text.
- White metadata.
- White links or accessible high-contrast link styles.
- No muted gray or navy text on colored or image-backed cards.

### 5.11 Final CTA

Replace the old “Find Your…” wording with:

> Let us build the next generation together.

Add a **Stay Connected** CTA button linking to the Stay Connected page.

### 5.12 Footer

Include:

- Logo.
- Short ministry summary.
- Footer navigation.
- Phone number.
- Verified email address.
- Social links.
- Legal links.
- Optional upcoming-event teaser.

## 6. Theme Customizer

Add a dedicated **SocalNextGen Theme Options** panel to the native WordPress Theme Customizer.

### 6.1 Hero Slider Section

Support at least five slides.

Each slide includes:

- Enable/disable toggle.
- Desktop image using a Media Library image control.
- Optional mobile image.
- Heading.
- Subheading.
- Description.
- Primary button text.
- Primary button URL.
- Secondary button text.
- Secondary button URL.
- Slide order.

### 6.2 Hero Slider Global Controls

Add controls for:

- Autoplay on/off.
- Transition speed.
- Slide duration.
- Pause on hover.
- Loop slides.
- Navigation arrows.
- Pagination dots.
- Overlay color.
- Overlay opacity.

### 6.3 Hero Slider Requirements

- Use native `WP_Customize_Image_Control` or `WP_Customize_Media_Control`.
- Do not require pasted image URLs.
- Use Media Library attachment data.
- Use desktop image as the mobile fallback.
- Use image alt text from the Media Library.
- Skip disabled or incomplete slides.
- Provide a default fallback hero when no slides are configured.
- Support keyboard controls.
- Respect `prefers-reduced-motion`.
- Ensure controls and text meet accessibility contrast requirements.

### 6.4 Additional Customizer Sections

Create sections for:

#### Contact

- Phone number.
- Email address.
- Address.
- Office hours.

Default customer phone:

`760-625-2910`

#### Social Media

- Facebook URL.
- Instagram URL.
- YouTube URL.
- Optional TikTok URL.

Public-facing social branding:

**SoCal NextGen YM**

#### Giving

- Online giving URL.
- Giving QR code image.
- Giving introduction text.

#### Merch

- External merchandise website URL.
- Button label.
- Open in new tab option.

#### Sponsors

- Sponsor logos.
- Sponsor destination URLs.
- Sponsor order.
- Sponsor visibility.

#### Homepage CTA

- CTA heading.
- CTA supporting text.
- Button label.
- Button URL.

## 7. Initiatives Page

Build `page-initiatives.php` with reusable sections for:

### Fine Arts

- Program summary.
- Festival information.
- Registration or event CTA.

### Youth Alive

- Program summary.
- Participation information.
- Contact or resource CTA.

### Speed the Light

- Program summary.
- Giving or participation CTA.

### AG Athletics

- Basketball tournament information.
- Volleyball tournament information.
- Registration links.
- Featured images.

Each initiative should be independently linkable through section IDs.

## 8. Resources Page

`page-resources.php` replaces Leadership Hub.

Include:

- Ministry training resources.
- Leadership development content.
- Downloadable documents.
- Links to external ministry tools.
- Optional resource categories.
- Clear file names, descriptions, and download actions.
- WordPress editor content for future additions.

Do not create or retain a separate Leadership Hub navigation item or page template.

## 9. Scholarships Page

Build `page-scholarships.php` with:

- Scholarship overview.
- Eligibility information.
- Deadlines.
- Requirements.
- Application instructions.
- Scholarship application form.
- Confirmation message.
- Email notifications.
- Spam protection.
- Mobile-friendly field layout.

Final content and form fields depend on information from Crystal.

## 10. Giving Page

Build `page-giving.php` with:

- Giving introduction.
- Multiple giving options.
- Giving QR code.
- Online giving button.
- External giving platform link.
- Optional giving FAQ.
- Clear external-link behavior.

## 11. Merch

Build `page-merch.php` as a lightweight branded landing page that links to the external merchandise store.

Include:

- Short merchandise introduction.
- Featured visual.
- Shop Merch button.
- External store link from the Theme Customizer.
- Optional automatic redirect only if later approved.

## 12. Stay Connected

Build `page-stay-connected.php` with:

- Network churches list.
- Youth ministries.
- Church contact information.
- Ministry network explanation.
- Join/connect CTA.
- Contact or interest form if required.

Final directory information depends on the client-provided network churches list.

## 13. Events Integration

Use The Events Calendar exclusively.

### Requirements

- Use the `tribe_events` post type.
- Do not register a theme event CPT.
- Do not create an Events page.
- Do not create a `page-events.php` template.
- Style plugin archive and single-event views through supported plugin hooks, CSS, and approved template overrides.
- Verify event detail pages.
- Require a featured image for customer-created events where practical.
- Support event registration links or forms.

### Initial Events

Add when customer information is available:

- Fine Arts Festival.
- Basketball Tournament.
- Volleyball Tournament.

## 14. Forms

Forms may be provided by an approved forms plugin.

Required forms:

### Scholarship Application

- Required application fields.
- Confirmation message.
- Admin email notification.
- Applicant confirmation email when available.
- Spam protection.
- Mobile-friendly layout.

### Event Registration

- Event selection or event-specific context.
- Attendee information.
- Required fields.
- Confirmation message.
- Email notifications.
- Spam protection.
- Mobile-friendly layout.

### Contact Form

- Verify recipient email.
- Verify confirmation behavior.
- Test validation and spam protection.

## 15. Media and Images

- Optimize all uploaded images.
- Use WebP where appropriate.
- Retain original quality for logos and key promotional artwork.
- Add featured images to all events.
- Add sponsor logos.
- Add homepage gallery images.
- Provide descriptive alt text.
- Avoid uploading unnecessarily oversized images.
- Recommended desktop hero width: at least 1600 pixels.
- Recommended hero aspect ratio: approximately 16:9.

## 16. Branding and Content Rules

- Use **Socal** as one word in internal theme naming, code comments, filenames, settings, and technical documentation.
- Use **SoCal NextGen YM** for customer-approved public-facing social branding.
- Replace outdated homepage messaging.
- Make copy more youth-focused and inclusive.
- Review the About page.
- Review all page headings and CTA wording.
- Verify terminology is consistent across desktop, mobile, footer, forms, and metadata.

## 17. Contact Information

Update the primary contact phone to:

**Ben — 760-625-2910**

Also verify:

- Public email address.
- Contact form destination.
- Footer contact details.
- Mobile click-to-call behavior.

## 18. Responsive and Accessibility Requirements

### Desktop

- Full navigation.
- Four-column event layout where space permits.
- Horizontal sponsor carousel.
- Multi-column footer.

### Tablet

- Responsive navigation.
- Two-column cards where appropriate.
- Controlled hero text width.
- Touch-friendly slider controls.

### Mobile

- Compact header and menu.
- Stacked CTA buttons.
- Single-column event cards.
- Swipe-safe slider.
- Readable text over images.
- Mobile-friendly forms.

### Accessibility

- Visible keyboard focus states.
- Skip link.
- Meaningful image alt text.
- Accessible form labels and errors.
- WCAG-compliant contrast.
- Reduced-motion support.
- Keyboard-operable sliders and carousels.

## 19. Implementation Phases

### Phase 1 — Foundation

- Confirm WP Rig configuration.
- Standardize Socal naming.
- Configure Tailwind.
- Build design tokens.
- Build header and footer.
- Register menus.
- Update starter pages.
- Add Theme Customizer architecture.

### Phase 2 — Navigation and Core Pages

- Finalize desktop/mobile navigation.
- Build About.
- Build Initiatives.
- Build Resources.
- Build Scholarships.
- Build Giving.
- Build Merch.
- Build Contact.
- Build Stay Connected.

### Phase 3 — Homepage

- Build Customizer-powered hero slider.
- Update mission statement.
- Update Four Pillars.
- Build `tribe_events` preview.
- Build Initiatives preview.
- Build Resources preview.
- Build Scholarships preview.
- Build Sponsors.
- Build Gallery.
- Fix Community card text contrast.
- Build final CTA.

### Phase 4 — Integrations and Forms

- Style The Events Calendar.
- Add event data when received.
- Configure event registration.
- Configure scholarship form.
- Add Giving QR code.
- Configure social links.
- Add gallery images.
- Add sponsor logos.
- Configure Merch URL.

### Phase 5 — QA and Launch Preparation

- Test desktop, tablet, and mobile.
- Verify navigation.
- Verify forms.
- Verify event archive and details.
- Test hero slider.
- Test sponsor carousel.
- Check image optimization.
- Check accessibility.
- Check SEO titles and descriptions.
- Check performance.
- Verify external links.
- Prepare client review.

## 20. Client Dependencies

### Waiting on Ben

- Updated event calendar.
- Basketball tournament information.
- Volleyball tournament information.
- Event featured images.
- Verified social links.
- Verified email address.

### Waiting on Crystal

- Scholarship information.
- Scholarship application fields.
- Giving QR code.
- Resources content.
- Network churches list.
- Youth ministry contacts.

## 21. Completion Target

The previous July 18 milestone has passed. Replace that date with the next approved customer review date before tracking the final launch schedule.

The site is considered ready for customer review when:

- Navigation is finalized.
- Homepage is complete.
- Events integration works.
- Initiatives is complete.
- Resources is complete.
- Giving is complete.
- Merch link works.
- Stay Connected is complete.
- Scholarships and forms are operational.
- Sponsors are visible.
- Gallery is populated.
- Contact and social details are updated.
- Desktop, tablet, and mobile layouts pass QA.

## 22. Verification Commands

Run:

```bash
npm run build
npm run lint:css
npm run lint:js
npm run test:e2e
npm run test:e2e:screenshot
npm run ai:check
```

Also verify:

- Theme activation does not create an Events page.
- Theme activation does not register `scng_event`.
- Homepage pulls upcoming events from `tribe_events`.
- Customizer hero images save and render correctly.
- Disabled slides do not render.
- Empty hero settings fall back safely.
- Theme remains error-free without The Events Calendar.
- All page templates call `the_content()` where editor-managed content is expected.
