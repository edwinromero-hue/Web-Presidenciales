# Architecture — Actores Electorales 2026

This document describes the project structure, conventions, and patterns used in the static site for Actores Electorales 2026 (CNE Colombia). The site is plain HTML/CSS/JS (no frameworks) and is designed for future WordPress migration.

---

## Project Structure

```
/
├── index.html                 # Home page
├── quienes-somos.html         # About (interactive radial infographic)
├── aliados.html               # Chapter 01: Allies (sub-page of quienes-somos)
├── metricas.html              # Chapter 02: Metrics (sub-page of quienes-somos)
├── compromisos.html           # Chapter 04: Commitments (sub-page of quienes-somos)
├── propositos.html            # Chapter 05: Purposes (sub-page of quienes-somos)
├── plataforma.html            # Platform (under construction)
├── entrenamiento.html         # Training (under construction)
├── regiones.html              # Regional locator (map + department list)
├── canales.html               # Contact channels + FAQ + chat widget
├── prensa.html                # Press room (news grid + filters)
├── eventos.html               # Events calendar
│
├── css/
│   └── styles.css             # Single CSS file (mobile-first, ~6400 lines)
│
├── js/
│   ├── shell.js               # Shared: header, progress rail, mobile nav, back-to-top, footer accordion, countdown
│   ├── scrolly.js             # Shared: GSAP ScrollTrigger scenes, count-up, word-reveal, parallax, FAQ
│   ├── inicio.js              # Home: banner scroll, video lite-embed, press marquee
│   ├── quienes-somos.js       # About: radial diagram interaction, carousel, detail panels
│   ├── regiones.js            # Regions: locator with multi-provider map support (placeholder/Leaflet/Google/Mapbox)
│   └── pages.js               # Page-specific: chat widget (canales), tab/filter toggles (prensa), calendar (eventos)
│
├── assets/
│   ├── logo.svg               # Main brand logo
│   ├── logo_mono.svg          # Monochrome logo variant
│   ├── fonts/                 # ClashDisplay-Light.otf, Outfit-Black.otf
│   └── img/                   # All images: photos (JPEG), decorative SVGs, vectors
│
├── ds/
│   └── colors_and_type.css    # Design system reference (NOT consumed in production)
│
├── api/
│   └── gate.ts                # Vercel serverless function (access gate)
│
├── middleware.ts               # Vercel edge middleware
├── vercel.json                 # Vercel config (security headers, caching, clean URLs)
├── .env.example                # Environment variable template
└── .gitignore
```

### Ignored directories

- `/wp/` — WordPress theme (separate development track, do not touch)
- `/.claude/` — AI agent configuration

---

## CSS Architecture

### Single-file, section-based

All styles live in `css/styles.css`. The file is organized into clearly commented sections in this order:

1. **Font-face** declarations (ClashDisplay, Outfit)
2. **CSS Custom Properties** (`:root` variables — colors, fonts, easing, spacing)
3. **Reset & base** (`*`, `html`, `body`, `a`, `img`)
4. **Skip link & focus** (accessibility)
5. **Header** (mobile-first: `.hdr-wrap`, `.hdr-nav`, `.hdr-mobile-nav`, floating pill)
6. **Buttons** (`.btn`, `.btn.red`, `.btn.outline`, etc.)
7. **Typography** (`h1`-`h6`, `.eyebrow`)
8. **Layout** (`.wrap`, `.pad`, `.pad-sm`, `main`)
9. **Footer** (`.footer`, `.footer-col` accordion)
10. **Cards** (`.card`, `.fcard`, `.news-card`)
11. **Scrollytelling** (`.scene`, `.pin`, `[data-enter]` reveal, parallax)
12. **Hero** (`.hero-stage`, `.ph` page hero)
13. **Grids** (`.g2`, `.g3`, `.g4`, `.ae-split`)
14. **Progress rail**
15. **FAQ** (`.faq-item`, `.ae-faq-item`)
16. **Back-to-top**, **Sticky CTA**
17. **Breakpoints** (480px, 768px, 1000px, 1240px) — mobile-first `min-width`
18. **Accessibility** (`prefers-reduced-motion`, `forced-colors`)
19. **Utilities** (`.ae-dots`, `.ae-footer-claim`, `.ae-h2`, `.sr-only`, `.breadcrumb`)
20. **Home banners** (`.ae-banner-*`)
21. **Home press marquee** (`.ae-press-*`)
22. **Home video** (`.ae-video-*`)
23. **Contact / channels** (`.ae-contact-*`, `.ae-faq-*`)
24. **Detail pages** (`.ae-detail-*`, `.ae-ally-*`)
25. **Locator / regions** (`.ae-locator-*`)
26. **Quienes-somos diagram** (`.ae-diag-*`)
27. **Under construction** (`.ae-construction-*`)
28. **Entrenamiento** (`.cert-card`, `.mod-*`, `.vid-card`, `.dl-card`)

### Design tokens

All colors, fonts, and spacing use CSS custom properties defined in `:root`:

| Token | Value | Purpose |
|-------|-------|---------|
| `--ae-blue` | `#1e3a8a` | Primary brand blue |
| `--ae-yellow` | `#ffc627` | Colombian flag yellow |
| `--ae-red` | `#e11d48` | Colombian flag red |
| `--ae-ink` | `#0f172a` | Text/headings |
| `--ae-muted` | `#475569` | Secondary text (passes WCAG AA) |
| `--ae-line` | `#e2e8f0` | Borders |
| `--ae-paper` | `#ffffff` | Backgrounds |
| `--font-ui` | Manrope, Archivo | Body and UI text |
| `--font-head` | Manrope, Archivo | Headings |
| `--font-display` | ClashDisplay | Display / decorative |
| `--font-impact` | Outfit | Impact numbers |
| `--ease` | cubic-bezier(.2,.7,.2,1) | Standard easing |

### Naming convention

- BEM-inspired prefix: `ae-` (Actores Electorales)
- Component blocks: `.ae-banner-*`, `.ae-press-*`, `.ae-video-*`, `.ae-diag-*`, `.ae-locator-*`
- State classes: `.is-active`, `.is-open`, `.in`, `.floating`, `.show`, `.open`

---

## JS Module Map

| File | Scope | Dependencies | Key exports |
|------|-------|-------------|-------------|
| `shell.js` | All pages | None | `window.AEShell` (REDUCED_MOTION) |
| `scrolly.js` | All pages | GSAP (optional) | `window.AEScrolly` (clamp01, range, stepAt, hasGSAP, isDesktop) |
| `inicio.js` | index.html | AEScrolly | `window.scene_bannersScene` |
| `quienes-somos.js` | quienes-somos.html | None | Diagram + carousel interactions |
| `regiones.js` | regiones.html | None | `window.AELocator` (setTab, selectPlace, providers) |
| `pages.js` | canales, prensa, eventos | None | Chat widget, tab/filter toggles, calendar grid |

### Loading order

Every page loads:
1. GSAP + ScrollTrigger (CDN, `<head>`)
2. `js/shell.js`
3. `js/scrolly.js`
4. Page-specific JS (if any): `js/inicio.js`, `js/quienes-somos.js`, `js/regiones.js`, or `js/pages.js`

### Pattern: scene callbacks

For scroll-driven scenes, `scrolly.js` looks for `window['scene_' + scene.id]` functions. The home page registers `scene_bannersScene` in `inicio.js`.

---

## How to Add a New Page

1. **Create the HTML file** in the project root (e.g., `nueva-pagina.html`).

2. **Copy the head boilerplate** from any existing page. Ensure you include:
   - `<meta charset="UTF-8">`
   - `<title>` with format: `Page Name — Actores Electorales 2026`
   - `<meta name="viewport">`, `<meta name="theme-color">`, `<meta name="description">`
   - Google Fonts preconnect + stylesheet
   - `<link rel="stylesheet" href="css/styles.css">`
   - GSAP scripts (if scroll animations are needed)

3. **Use the canonical header** (copy from any existing page, update the `class="active"` and `aria-current="page"` on the correct nav link).

4. **Use the canonical footer** with the accordion pattern (`footer-col` + `footer-col-btn`).

5. **Include scripts** at the bottom:
   ```html
   <script src="js/shell.js"></script>
   <script src="js/scrolly.js"></script>
   <!-- Add page-specific JS only if needed -->
   ```

6. **Add page-specific CSS** to `css/styles.css` under a new clearly-commented section. Never use inline `<style>` blocks.

7. **Update navigation** in ALL 12+ HTML files — both the desktop nav (`.hdr-nav`) and mobile nav (`.hdr-mobile-nav`) must include the new link.

8. **Update the footer** link columns if the new page should appear there.

---

## Asset Conventions

### Images

- Place all images in `assets/img/`
- Use descriptive filenames with underscores (e.g., `Malla_Azul.svg`, `vector_01.svg`)
- Photos: JPEG for photos, SVG for illustrations/vectors/decorative
- Use `loading="lazy"` and `decoding="async"` on all images except above-the-fold hero images

### Fonts

- Custom fonts go in `assets/fonts/`
- Register them in `css/styles.css` via `@font-face`
- Currently using: ClashDisplay (display), Outfit (impact numbers), Manrope + Archivo (via Google Fonts CDN)

### Logos

- `assets/logo.svg` — main logo
- `assets/logo_mono.svg` — monochrome variant

---

## Deployment

- **Platform**: Vercel (static + serverless)
- **Config**: `vercel.json` handles security headers, asset caching, and clean URLs
- **Middleware**: `middleware.ts` provides edge-level access control
- **API**: `api/gate.ts` handles authentication gate

---

## Accessibility

- All pages include a skip link (`.skip-link`)
- Mobile nav has focus trap, Escape key support, and scroll lock
- `prefers-reduced-motion` disables all animations and transitions
- `forced-colors` (Windows High Contrast) support included
- Interactive elements meet 44px minimum touch target
- WCAG AA contrast ratios verified for all text colors
- `aria-label`, `aria-expanded`, `aria-current`, `role` attributes used throughout

---

## WordPress Migration Notes

- The header and footer are currently duplicated across all HTML files. In WordPress, they become `header.php` and `footer.php` partials.
- Each page's `<main>` content maps to a WordPress template or page template.
- `regiones.js` is designed for WordPress portability (reads data from DOM, supports ACF/CPT data sources).
- CSS custom properties can be overridden in WordPress theme's `style.css`.
- Inline scripts have been extracted to `js/pages.js` for clean WordPress enqueueing.
