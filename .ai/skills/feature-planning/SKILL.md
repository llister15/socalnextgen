---
name: feature-planning
description: Plan WP Rig theme features with a concise specification, repository discovery, and reasonable defaults before implementation.
---

# Feature Planning: Contract-First Strategy

This skill guides the agent through a "Contract-First" feature planning process for WP Rig. Create a concrete technical plan before implementing theme features, using the user’s request and repository evidence to resolve routine decisions.

## The Core Philosophy

1.  **Contract Establishment:** Write a specification (`SPEC.md`) before implementing theme features. A user’s request to implement a feature authorizes proceeding within that scope; separate specification approval is required only when the user explicitly requests it. Documentation-only edits to this workflow do not require a feature specification. All design-related specs must align with or update the `.ai/STYLE-GUIDE.md`.
2.  **Challenge the Request:** As a WP Rig expert, you must ensure any feature plan follows WP Rig's opinionated architecture and design standards. If a user's request violates these (e.g., inconsistent typography or non-standard markup), you must challenge it.
3.  **Design-Planning Reciprocity:** Designs in the `.ai/STYLE-GUIDE.md` must inform feature planning, and new feature plans that introduce novel design patterns must be used to update the style guide. If this style guide does not yet exist, it must be created and completely documented with a full set of common design patterns and concerns from color pallets to typography, layout spacing rules, and more.
4.  **Strategic Trio Alignment:** Every feature must be evaluated through three lenses:
    - **Architecture:** How does it fit into the PHP/JS structure? (Refer to [Architecture skill](../architecture/SKILL.md))
    - **Web Design:** What are the aesthetic, interactive, and accessibility requirements? Does it adhere to the `.ai/STYLE-GUIDE.md`? (Refer to [Web Designer skill](../web-designer/SKILL.md))
    - **Feature Planning:** How do we define and verify the "Contract"? (Current skill)
4.  **Context Engineering:** Use existing skills (`architecture`, `web-designer`, `php-filters`, `create-component`, etc.) to inform the plan.

## The Process

### Step 1: Discover Context and Resolve Unknowns

Read `config/config.json`, relevant source files, and applicable architecture and design guidance. Use repository evidence and the user’s existing instructions before asking questions.

- Choose reasonable defaults for reversible implementation and design decisions, following existing theme conventions.
- Ask only when missing information materially affects correctness, scope, or a consequential user choice and cannot be inferred from the repository.
- Do not require a minimum number of questions, numerical confidence scores, an echo-check approval, or repeated permission to perform already authorized work.
- Document assumptions and actual user answers separately in the specification. Never label an inferred default as user-approved.
- State significant defaults briefly and continue independent work while awaiting any necessary clarification. Silence is not approval.
- Respect explicit requests to review a plan before implementation, and obtain any authorization required for actions beyond the original task.

#### Key Areas to Explore
- **Business Value:** What is the core problem being solved? Who is the end-user?
- **WP Rig Integration:**
    - Does this require a new component? (Refer to [Create Component skill](../create-component/SKILL.md))
    - Will it use existing asset filters? (Refer to [PHP Filters skill](../php-filters/SKILL.md))
    - Does it need new styles, JS, or a design system update? (Refer to [Web Designer skill](../web-designer/SKILL.md), [Styles skill](../styles/SKILL.md), and [npm Scripts skill](../npm-scripts/SKILL.md))
- **Constraints:** Are there specific accessibility or performance requirements? (Refer to [Web Designer skill](../web-designer/SKILL.md))

### Step 2: Draft the Specification

Create a new directory: `.ai/plans/{YYYY-MM-DD}-{feature-slug}/` and create a `SPEC.md` within it.

The `SPEC.md` must include:

1.  **Mission Statement:** A concise goal for the feature.
2.  **Design Compliance:**
    - Reference relevant sections of `.ai/STYLE-GUIDE.md`.
    - Note if this feature will require updates to the style guide.
3.  **Architectural Fit:**
    - Identify the WP Rig components involved. (Refer to [Architecture skill](../architecture/SKILL.md))
    - List the hooks/filters to be used (e.g., `wp_rig_css_files`).
4.  **User Stories:** Simple "As a user, I want..." statements.
5.  **Success Metrics:** How will we verify this? (e.g., "Passes Lighthouse accessibility scan", "No visual regressions in E2E tests").
6.  **Technical Plan (The "Contract"):**
    - **Scaffolding:** Commands like `npm run create-rig-component`.
    - **Implementation Steps:** Logical order of file creation/modification.
    - **Verification:** Tools and commands to test the result (Refer to [E2E Testing skill](../e2e-testing/SKILL.md) and [Code Quality Standards](../code-quality-standards/SKILL.md)).

### Step 3: Refinement

Make the specification reviewable and proceed with implementation within the user’s authorized scope. Update it when findings or user feedback change the plan. Pause for specification approval only if the user requested that checkpoint; otherwise do not add an approval gate.

## Best Practices

- **Evidence-Based Planning:** Verify file paths and integration points in the repository and record important decisions in `SPEC.md`.
- **Reference Skills:** Always link to relevant `/.ai/skills/*.md` files within your technical plan to ensure the agent (or developer) follows the correct recipe.
- **Fail Early:** If the feature request is not technically feasible within WP Rig's architecture, identify this during the planning phase.
- **Maintain Context:** Keep all related planning documents (User Stories, Technical Specs) within the same `.ai/plans/` subdirectory.
