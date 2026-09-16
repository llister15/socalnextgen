# Theme-Owned Events Removal

Status: Approved and implemented
Date: 2026-07-08

## Mission Statement

Remove the theme-owned Events page and `scng_event` architecture because The Events Calendar exclusively owns `/events/`.

## Clarifications

Documented request:

1. Remove theme activation behavior that creates the Events page.
2. Preserve The Events Calendar ownership of the `/events/` slug.
3. Keep this change narrow and avoid unrelated navigation/content updates.
4. Remove `scng_event` completely from the theme.

Assumptions:

1. Existing manually created pages should not be deleted.
2. Existing manually assigned menus should not be overwritten.
3. Homepage/footer links to `/events/` can remain because they should resolve to The Events Calendar's route.
4. Legacy theme-owned Events templates must be removed.
5. The existing WordPress Events page is preserved for manual deletion or slug editing; the theme must not delete administrator content automatically.

## Design Compliance

No visual design changes are introduced.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`.

Files changed:

- `inc/Starter_Content/Component.php`
- `inc/Theme.php`
- `template-parts/sections/events-preview.php`

Removed files:

- `inc/Events/Component.php`
- `page-events.php`
- `archive-scng_event.php`
- `single-scng_event.php`

## User Stories

- As a site admin, I want The Events Calendar to own the `/events/` URL so there is no slug conflict with a theme-created page.
- As a developer, I want starter content to avoid creating plugin-owned URLs.
- As a visitor, I want existing links to `/events/` to continue reaching the events experience.

## Success Metrics

- `get_pages()` no longer includes the `events` starter page.
- Starter primary/footer menus no longer try to add a page menu item for `events`.
- The theme no longer registers `scng_event` or its taxonomy.
- The homepage preview queries only The Events Calendar's `tribe_events` post type.
- PHP syntax check passes for `inc/Starter_Content/Component.php`.
- `npm run ai:check` is attempted if feasible.

## Technical Plan

1. Edit `inc/Starter_Content/Component.php`.
2. Remove `events` from the primary starter menu slug list.
3. Remove `events` from the footer quick links starter menu slug list.
4. Remove the `events` entry from `get_pages()`.
5. Unregister and remove the theme-owned Events component and templates.
6. Remove the homepage `scng_event` fallback.
7. Verify with PHP syntax checks, targeted searches, and `npm run ai:check`.

## Approval Gate

Implementation confidence: 99%.

Approved by the user on 2026-07-16: “I dont want it.”
