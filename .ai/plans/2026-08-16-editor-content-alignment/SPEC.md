# Editor Content Alignment Specification

Status: Approved  
Date: 2026-08-16

## Mission Statement

Restore natural left alignment for normal editor-authored page content and forms without removing intentional centering from heroes, section headings, cards, or other purpose-designed components.

## Context Assessment

- Context completeness: 100%.
- Implementation confidence: 98%.
- Confirmed default: ordinary editor content is left-aligned.
- Confirmed forms: labels, fields, help text, and validation messages are left-aligned; submit buttons retain their existing component alignment.
- Confirmed Initiatives scope: keep the current single-column editor layout and change alignment only.
- Root causes identified: the shared `page-content.php` wrapper includes `text-center`, `content.css` applies broad page-template centering to editor children, and the Contact page grid centers its contents on small screens.

## Design Compliance

This correction follows [`.ai/STYLE-GUIDE.md`](../../STYLE-GUIDE.md), especially its readable body typography and editor/plugin ownership of forms. The style guide will be updated to state that editor-authored body content and forms default to left alignment while centering must be explicitly applied to intentional presentation components.

Left-aligned paragraphs, lists, labels, instructions, and errors improve scanning and form usability. No color, typography, spacing, responsive breakpoint, or interaction pattern changes are introduced.

## Architectural Fit

- Theme type: classic WP Rig theme, per `config/config.json`.
- Shared template part: `template-parts/layout/page-content.php` provides editor content for Initiatives, Giving, Fine Arts, Leadership Hub, Scholarships, Resources, and Gallery.
- Content stylesheet: `assets/css/src/content.css` defines width and alignment behavior for editor children on multiple named page templates.
- Contact template: `page-contact.php` contains editor/plugin-owned form content inside its responsive grid.
- Existing explicit alignment utilities remain on page heroes and intentionally centered components.
- Hooks, filters, JavaScript, components, and scaffolding: none required.
- Relevant guidance: [Feature Planning](../../skills/feature-planning/SKILL.md), [Architecture](../../skills/architecture/SKILL.md), [Web Designer](../../skills/web-designer/SKILL.md), and [Styles](../../skills/styles/SKILL.md).

## User Stories

- As a visitor, I want paragraphs and lists to be left-aligned so that page content is easier to scan.
- As a form user, I want labels, instructions, fields, and errors aligned consistently so that forms are easier to complete.
- As an editor, I want the Initiatives page to retain its current simple structure without unintended global presentation styles.
- As a designer, I want heroes and deliberately centered components to remain centered through explicit local classes.

## Success Metrics

- The shared page-content wrapper no longer carries `text-center`.
- Broad page-template editor rules retain their width behavior but no longer set `text-align: center`.
- The Contact content/form grid no longer applies mobile-first inherited centering.
- Initiatives remains a single column with left-aligned headings, descriptions, and links.
- Form content defaults to left alignment without changing button component rules.
- Explicitly centered heroes, headings, cards, and promotional components are unaffected.
- PHP syntax, CSS build/lint, focused diff checks, visual verification when available, and `npm run ai:check` are run; unrelated or environmental failures are documented.

## Technical Contract

### Implementation

1. Remove `text-center` from the inner wrapper in `template-parts/layout/page-content.php` while preserving its width, color, and centering within the container.
2. Remove only the `text-align: center` declaration from the named page-template `.entry-content > *` rule in `assets/css/src/content.css`; preserve the wide-content maximum width.
3. Remove inherited `text-center` and the now-redundant `md:text-left` override from the Contact page content grid in `page-contact.php`.
4. Update `.ai/STYLE-GUIDE.md` with the scoped editor-content alignment rule.
5. Rebuild generated CSS through the existing WP Rig CSS workflow.

### Verification

1. Run PHP syntax checks on modified PHP files.
2. Run the CSS build and linter.
3. Search source and generated CSS to confirm the shared and broad content selectors no longer force centered text.
4. Use the screenshot workflow to inspect Initiatives and a form page if the configured development server is available.
5. Run `git diff --check` on changed files.
6. Run the mandatory `npm run ai:check` pre-flight validation.

## Out of Scope

- Redesigning Initiatives into cards, columns, or a custom block.
- Changing page-hero alignment or intentionally centered section headings/cards.
- Changing form markup, plugins, field sizing, submit-button alignment, or validation behavior.
- Altering content entered in WordPress.
