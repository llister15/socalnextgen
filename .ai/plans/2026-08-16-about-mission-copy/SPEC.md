# About Mission Copy Specification

Status: Approved  
Date: 2026-08-16

## Mission Statement

Ensure the About page always displays the approved, theme-owned mission statement instead of allowing the WordPress page excerpt to replace it.

## Context Assessment

- Context completeness: 100%.
- Implementation confidence: 98%.
- Confirmed behavior: the mission copy is hardcoded and the About page excerpt never overrides it.
- Confirmed presentation: use two semantic `<p>` elements, with the first paragraph ending “communities, and beyond.” and the second beginning “Through leadership development…”.
- Scope is limited to the mission assignment and output in `page-about.php`.

## Design Compliance

This correction follows the About-page direction in [`.ai/STYLE-GUIDE.md`](../../STYLE-GUIDE.md): the existing photo-backed hero and photo/copy story section remain unchanged. The mission uses semantic paragraphs and existing utility classes; it introduces no new styling, interaction, or design token, so the style guide requires no update.

## Architectural Fit

- Theme type: classic WP Rig theme, as defined by `config/config.json`.
- Theme namespace: `WP_Rig\WP_Rig`.
- Text domain: `socalnextgen`.
- Involved template: `page-about.php`.
- Components, hooks, filters, assets, and scaffolding: none required.
- Each approved paragraph remains wrapped in WordPress internationalization functions and escaped at output.
- Relevant guidance: [Feature Planning](../../skills/feature-planning/SKILL.md), [Architecture](../../skills/architecture/SKILL.md), and [Web Designer](../../skills/web-designer/SKILL.md).

## User Story

As a visitor to the About page, I want to see the organization’s approved mission statement consistently so that an unrelated or stale WordPress excerpt cannot replace it.

## Success Metrics

- `page-about.php` no longer calls `get_the_excerpt()` to set `$mission`.
- The approved mission statement is represented as two translatable paragraphs.
- Other About-page markup and all existing styling remain unchanged.
- The modified PHP file passes syntax validation.
- `npm run ai:check` passes, subject to any documented pre-existing or environment-level failures.

## Technical Contract

### Scaffolding

No scaffolding command is appropriate because this is a one-line correction within an existing classic-theme template; it adds no component or content-input type.

### Implementation

1. Edit only the mission assignment and output in `page-about.php`.
2. Remove the call to `get_the_excerpt( $post_id )` and the fallback assignment.
3. Store the approved mission copy as two directly assigned, translatable paragraphs.
4. Render each escaped paragraph in its own `<p>` element using the existing typography utilities and appropriate spacing between paragraphs.

### Verification

1. Run `php -l page-about.php`.
2. Search the template to confirm `$mission` has no excerpt dependency.
3. Run the mandatory `npm run ai:check` pre-flight validation.

## Out of Scope

- Changing the mission statement wording beyond dividing it after “communities, and beyond.”.
- Making the mission editable through excerpts, post meta, Customizer settings, blocks, or theme options.
- Altering About-page layout, CSS, images, headings, or other content.
