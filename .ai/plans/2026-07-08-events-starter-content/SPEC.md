# Events Starter Content Removal

Status: Draft, awaiting approval
Date: 2026-07-08

## Mission Statement

Stop the theme activation/starter-content process from creating a WordPress page with the `events` slug, because The Events Calendar should own `/events/`.

## Clarifications

Documented request:

1. Remove theme activation behavior that creates the Events page.
2. Preserve The Events Calendar ownership of the `/events/` slug.
3. Keep this change narrow and avoid unrelated navigation/content updates.

Assumptions:

1. Existing manually created pages should not be deleted.
2. Existing manually assigned menus should not be overwritten.
3. Homepage/footer links to `/events/` can remain because they should resolve to The Events Calendar's route.
4. The legacy `page-events.php` template can remain in the theme for now, but new starter content will not assign it automatically.

## Design Compliance

No visual design changes are introduced.

## Architectural Fit

Theme type: classic, confirmed in `config/config.json`.

Primary file expected to change after approval:

- `inc/Starter_Content/Component.php`

No new component, template, CSS, or JavaScript is required.

## User Stories

- As a site admin, I want The Events Calendar to own the `/events/` URL so there is no slug conflict with a theme-created page.
- As a developer, I want starter content to avoid creating plugin-owned URLs.
- As a visitor, I want existing links to `/events/` to continue reaching the events experience.

## Success Metrics

- `get_pages()` no longer includes the `events` starter page.
- Starter primary/footer menus no longer try to add a page menu item for `events`.
- No existing event templates, plugin compatibility, or homepage event previews are removed.
- PHP syntax check passes for `inc/Starter_Content/Component.php`.
- `npm run ai:check` is attempted if feasible.

## Technical Plan

1. Edit `inc/Starter_Content/Component.php`.
2. Remove `events` from the primary starter menu slug list.
3. Remove `events` from the footer quick links starter menu slug list.
4. Remove the `events` entry from `get_pages()`.
5. Verify with PHP syntax check and targeted grep for starter-content `events` references.

## Approval Gate

Implementation confidence: 99%.

This spec needs user approval before source files are modified.
