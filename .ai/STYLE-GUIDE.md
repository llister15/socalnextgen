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
- Hero uses a lightweight slider. Manage slide image URLs in WP Rig Settings, or add files as `assets/images/hero-slide-*.jpg`, `.png`, or `.webp`; `HeroImage.jpg` is the fallback.
- Footer social links are managed in WP Rig Settings.

## Components

- Primary button: orange background, white uppercase text, slight radius.
- Secondary button: white background, navy border, navy text.
- Text CTA: orange uppercase text with right arrow.
- Cards: radius `8px`, subtle shadow, clear image/date/title hierarchy.
- Program cards: strong gradient background with white text and outline CTA.
- Pillar cards: circular icon badge, uppercase title, short support copy.

## Responsive Behavior

- Desktop: horizontal header, large hero, 4-column events, 3-column program cards, multi-column footer.
- Tablet: two-column grids where possible.
- Mobile: stacked layout, compact header, stacked CTAs, single-column cards.

## Accessibility

- Keep visible focus states.
- Maintain contrast on image overlays.
- Use descriptive alt text for content images and empty alt text for decorative placeholders.
- Honor reduced-motion preferences.
