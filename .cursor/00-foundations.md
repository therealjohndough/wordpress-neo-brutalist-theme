---
description: Foundations for Case Study Labs — neo-brutalist theme
globs: "**/*"
alwaysApply: true
---

## Intent
- Produce production-ready WP code with minimal dependencies.
- Prefer clarity, low complexity, and consistent naming over cleverness.

## Truth Hierarchy
1) Existing theme code & PHP hooks
2) ACF field schema and template contracts
3) These Rules

## Quality Bar
- Escape output (`esc_html`, `esc_url`, `wp_kses_post`) and sanitize on save.
- Version assets via `filemtime()`. No inline scripts/styles unless unavoidable.
- Add a short rationale when changing architecture (comment or PR note).

## House Style
- 2-space indentation, LF newlines, trailing newline.
- No debug output in committed code (`var_dump`, `error_log`, `console.log`).
