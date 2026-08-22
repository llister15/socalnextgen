# SocalNextGen Style Guide

Status: Active
Date: 2026-06-27

## Design Direction

SocalNextGen uses a bright Southern California youth-ministry look: white space, deep navy structure, orange action accents, warm sunset gold, coastal blue, and clear ministry photography.

## Colors

- Navy: `#071b3a` for headings, header text, footer, and primary text.
- Orange: `#ff6a00` for CTAs, active navigation, date badges, and emphasis.
- Gold: `#ffd23f` for warm secondary accents inspired by the logo.
- Sky: `#15a9d6` for coastal/wave accents.
- Green: `#067a3d` for scholarship/service cards.
- Purple: `#32156b` for Fine Arts.
- Muted: `#64748b` for supporting text.
- Line: `#d9e2ec` for borders.

## Typography

- Display: condensed bold sans-serif for uppercase headings and navigation.
- Body: clean sans-serif for readable ministry content.
- Script: reserved for short emotional accents such as "Heart", "Basics", and "Call".

## Layout

- Max content width: `1180px`.
- Desktop sections: generous `64px` to `96px` rhythm.
- Tablet sections: `48px` to `72px`.
- Mobile sections: `32px` to `48px`.
- Use full-width bands and constrained inner containers.
- Avoid nested cards.
- Global body, page, and content backgrounds stay white or light. Do not switch the theme to a black/dark background based on OS dark mode.
- Hero supports either one decorative MP4 background or the lightweight image slider, managed in the WordPress Customizer. A selected MP4 replaces the slider, autoplays muted, loops, plays inline, and uses the first slider image as its poster/fallback. Reduced-motion users receive the static poster. Hero media spans the full width with uniform reduced opacity; do not use a directional fade that obscures one side.
- The homepage slider has a critical startup state: slides are layered before the asynchronous stylesheet arrives and only the first slide is initially visible, preventing stacked-image flashes.
- Every JavaScript-enabled front-end page uses a full-viewport SocalNextGen logo loader that releases on `window.load`, fades out, and includes a bounded safety timeout. The loader is decorative, non-focusable, and hidden when JavaScript is unavailable.
- Image priority is contextual: the header brand and first hero image load eagerly, the first hero image receives high fetch priority, and later hero plus clearly below-the-fold theme images lazy-load. WordPress retains control of editor-image loading heuristics.
- Footer social links are managed in WP Rig Settings.
- About and Youth Ministries pages use a photo-backed hero, one alternating photo/copy story section, and strong full-width content bands. Do not add a Team section or standalone image-only gallery.
- Signup forms and Giving forms remain editor/plugin-owned; the theme supplies layout and form presentation rather than hardcoded form fields.
- Editor-authored body content defaults to left alignment, including paragraphs, lists, links, form labels, instructions, and validation messages. Centering is applied only to intentionally designed components such as heroes, selected section headings, and cards.
- Ordinary inline content links remain underlined in unvisited and visited states so recognition does not depend on color. Visited content links use the established purple accent; navigation, buttons, cards, CTAs, brands, social links, and other designed components retain their own link treatments.
- A fixed circular back-to-top arrow appears at the bottom-right after meaningful scrolling on every page. It is keyboard accessible, uses smooth scrolling by default, jumps instantly for reduced-motion visitors, and cannot receive input while hidden.
- NextGen Locator results remain grouped by state and city, with ministry names sorted A–Z within each city.

## Components

- Primary button: orange background, white uppercase text, slight radius. The desktop header CTA is a WordPress Primary-menu item labeled “Stay Connected,” not a hardcoded template link.
- Secondary button: white background, navy border, navy text.
- Text CTA: orange uppercase text with right arrow.
- Cards: radius `8px`, subtle shadow, clear image/date/title hierarchy.
- Program cards: strong gradient background with white text and outline CTA.
- Pillar cards: circular icon badge, uppercase title, short support copy.
- Utility bar: a compact `36px` to `40px` deep-navy band above the primary header, with white identity text, muted-white social icons, editable secondary navigation, and gold hover/focus accents. Its content spans the browser width using the same responsive side padding as the primary header rather than the constrained site container.
- Social links: use recognizable inline SVG icons with accessible link names. On dark surfaces, unvisited and visited states remain white or muted white; hover and focus use gold.
- Featured event: a full-browser-width linked promotion that automatically displays the next future event from The Events Calendar. Show its title, date, location, excerpt, and featured image, using the SocalNextGen logo when the event has no image. Hide the band when no future event exists. Preserve readable content, clear hover feedback, and a visible keyboard focus treatment across the complete linked banner.
- Locator: accessible search/state/city filters above grouped Youth Group cards. Filters work with normal GET requests and do not depend on geolocation or JavaScript.
- Placeholder images: use the SocalNextGen logo when a card requires an image but has no meaningful featured image. Never substitute unrelated photography.

## Responsive Behavior

- Desktop: horizontal header, large hero, 4-column events, 3-column program cards, multi-column footer.
- Tablet: two-column grids where possible.
- Mobile: stacked layout, compact header, stacked CTAs, single-column cards. Keep the utility-bar identity visible and place its social and secondary actions inside the existing mobile navigation.

## Accessibility

- Keep visible focus states.
- Maintain contrast on image overlays.
- Use descriptive alt text for content images and empty alt text for decorative placeholders.
- Honor reduced-motion preferences.
- Form fields and directory filters require persistent visible labels, clear errors, and keyboard-operable controls.

## Sharing Metadata

- Singular content uses its title, excerpt, canonical URL, content type, featured image, and featured-image alt text for Open Graph and X/Twitter sharing.
- Fall back to the site description and SocalNextGen logo when contextual descriptions or images are unavailable.
- Theme metadata must yield to a recognized SEO plugin to avoid duplicate social tags.
