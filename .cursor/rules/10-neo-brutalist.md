---
description: Case Study Labs — neo-brutalist theme rules (site structure aware)
globs: "**/*.php,**/*.css,**/*.js"
---

## Theme Scope
- Theme slug: `newo-brutalist`
- Editor model: **ACF Pro first** for all landing/marketing pages. Disable Gutenberg where ACF drives content.
- Function prefix: `csl_`

## Information Architecture
### Navigation (observed)
- Primary: Home, Studio, Services, Work, Contact, News.
- Footers: Newsletter, Explore (About/Services/Pricing/Case Studies/Work With Us), Services list, Connect (email, Calendly, LinkedIn, IG).
- Ensure menu locations `primary` and `footer_*` exist and are registered. :contentReference[oaicite:1]{index=1}

### Pages & Templates
- **Front Page (`front-page.php`)** sections (in order):
  1. **Hero** — headline, supporting copy, two CTAs (e.g., “Brand Clarity Quiz”, “Our Process”). ACF group: `hero_headline`, `hero_subcopy`, `hero_ctas` (repeater: `label`, `url`, `style`). :contentReference[oaicite:2]{index=2}
  2. **Trusted By** logos strip — ACF repeater `trusted_by` with `logo` (image), `alt`, optional `url`. Use `<ul>` list; logos lazy-load. :contentReference[oaicite:3]{index=3}
  3. **Outcomes (Case teasers)** — three cards linking to case studies. ACF repeater `outcomes_cards`: `title`, `lede`, `url`, `tags[]`, `cover_image`. Use a partial `template-parts/csl-card-outcome.php`. :contentReference[oaicite:4]{index=4}
  4. **Mission** — kicker + headline + blurb + pull-quote. ACF: `mission_kicker`, `mission_headline`, `mission_body`, `mission_quote`. :contentReference[oaicite:5]{index=5}
  5. **Values** — three “lab values” blocks. ACF repeater `values`: `title`, `copy`. Keep semantic headings (h3). :contentReference[oaicite:6]{index=6}
  6. **Capabilities Grid** — 6 cards (Strategy, Branding & Production, Media Buying, Web Design, Content & Social, Lifecycle Marketing). ACF repeater `capabilities`: `title`, `copy`, optional `url`. Compact cards, equal height. :contentReference[oaicite:7]{index=7}
  7. **Mutual Fit / Not a Fit** — two-column comparison list. ACF: `fit_list[]`, `not_fit_list[]`. Render with accessible list semantics. :contentReference[oaicite:8]{index=8}
  8. **Bottom CTA** — dual buttons (Start a Project / Join Our Network). ACF: `cta_primary_label/url`, `cta_secondary_label/url`. :contentReference[oaicite:9]{index=9}
- **Services (`page-services.php`)**:
  - Capabilities recap grid (mirror front page).
  - **SLA Table** (type, default SLA, revisions, output, one-off price) — use ACF repeater `sla_rows` with strict columns to avoid ad-hoc HTML. :contentReference[oaicite:10]{index=10}
  - **Service Tiers** (Launch/Growth/Scale) — ACF repeater `tiers` with `name`, `target`, `price_range`, `key_services[]`. :contentReference[oaicite:11]{index=11}
  - **Service Catalog** — grouped lists via ACF Flexible Content: groups (`Branding & Strategy`, `Design & Creative`, `Digital & Web`, `Marketing & Content`, `Production & Media`, `Consulting & Ongoing`) each with item repeater `label`, `price_hint`. :contentReference[oaicite:12]{index=12}
- **Case Studies**:
  - Archive: `archive-case-studies.php` at `/case-studies` and linked as “Work”. Grid of cards using `csl-card-case-study.php` (thumb, title, excerpt/tags). Avoid N+1 by prefetching thumbnails/meta. :contentReference[oaicite:13]{index=13}
  - Single: `single-case-studies.php` with sections:
    - Hero (title, hero image), body (`the_challenge`, `our_solution`), sidebar meta (`client_name`, `services_provided[]`, `project_year`, `project_url`), optional gallery.

## ACF: Registration & Options
- Register ACF field groups in code with stable keys (JSON sync optional).
- **Theme Options** page: logo, brand colors, font CSS URL (Google Fonts), social links, analytics/head snippets, custom CSS, Calendly/GHL URLs.
- Provide a `csl_option($key, $default)` helper and `csl_field($key, $default)` with safe fallbacks.

## CSS & Layout
- **Neo-brutalist**: big type, hard edges, strong contrast; minimal shadows; grid-first.
- Use CSS vars: `--c-bg`, `--c-fg`, `--c-accent`, `--space-*`, `--radius-*`.
- Files: `/assets/css/layout.css`, `components.css`, `utilities.css`. Keep specificity low. Use `:where()` to tame specificity when needed.
- Logo strip: equal height rows; constrain max-height with object-fit; grayscale on rest, full on hover (optional). :contentReference[oaicite:14]{index=14}

## JS
- Modules only; no globals. Defer by default. Keep to essentials (menus, accordions, smooth-scroll, analytics).
- Any quizzes/CTA tracking should emit data-attributes for hooks (e.g., `data-cta="brand-quiz"`). :contentReference[oaicite:15]{index=15}

## Performance & Media
- Define image sizes: `csl-card` (≈900×600 hard crop), `csl-hero` (≈1600×900), `csl-logo` (variable height).
- Always set `loading="lazy"` + `decoding="async"`; include width/height/aspect-ratio to prevent CLS.
- Preload critical font CSS if non-blocking; `font-display: swap`.

## SEO
- `title-tag` support; meta description via Theme Options. OG/Twitter tags in `wp_head`.
- JSON-LD:
  - `Organization` sitewide (logo, sameAs).
  - `CreativeWork` per case study.
  - `Product/Service` structured snippets for service items (optional).
- Canonical URL on all pages; clean slugs. Ensure `/case-studies` indexable. :contentReference[oaicite:16]{index=16}

## Accessibility
- Semantic headings (no skipped levels). Buttons vs links correctly used.
- Alt text from ACF for all logos and project images.
- Fit/Not-Fit comparison rendered as two lists with headings (improves screen reader nav). :contentReference[oaicite:17]{index=17}

## Dev Patterns
- **Partials** live under `template-parts/` and accept data arrays:
  - `csl-card-case-study.php` (archive cards)
  - `csl-card-capability.php`
  - `csl-card-outcome.php` (front “Outcomes”)
- **Helpers**
  - `csl_get_img($id, $size, $attrs=[])` centralizes `<img>` generation.
  - `csl_menu($location, $class)` wraps `wp_nav_menu` with sane defaults.
  - `csl_button($label, $url, $variant='solid')` standardizes CTA buttons.
- Avoid queries inside partials; build arrays in the parent template.
