# CSL Agency WordPress Theme

Modern WordPress theme with Tailwind CSS, Vite, and Alpine.js for Case Study Labs.

## 🚀 Quick Start

### Development

```bash
# Navigate to theme directory
cd /Users/dough/public_html/wp-content/themes/casestudy-labs-modern-theme

# Install dependencies
npm install

# Start development server (hot reload)
npm run dev

# Build for production
npm run build

# Watch mode (auto-rebuild on changes)
npm run watch
```

## 📦 Tech Stack

- **Tailwind CSS 3.4** - Utility-first CSS framework
- **Vite 5** - Lightning-fast build tool
- **Alpine.js 3.13** - Lightweight JavaScript framework
- **WordPress** - CMS backend

## 🎨 Tailwind Configuration

### Custom Colors

```css
primary: #ff4500        /* Orange accent */
primary-dark: #cc3700   /* Darker orange */
accent: #1abc9c         /* Teal */
dark: #1a1a1a          /* Dark background */
light: #f5f5f5         /* Light background */
```

### Custom Fonts

```css
font-space      /* Space Grotesk (headings) */
font-fira       /* Fira Code (monospace) */
font-montserrat /* Montserrat (body) */
```

## 🔧 Development Workflow

### Making Style Changes

1. Edit `src/styles.css` for custom Tailwind components
2. Or add Tailwind classes directly to PHP templates
3. Run `npm run dev` for hot reload (with `WP_DEBUG = true`)
4. Or `npm run build` for production

### Environment Modes

**Development** (`npm run dev`):
- Loads from Vite dev server (localhost:5173)
- Hot module replacement
- Requires `WP_DEBUG = true` in wp-config.php

**Production** (`npm run build`):
- Optimized, minified assets
- Hashed filenames for cache busting
- Auto-loaded when built files exist

## 📊 Performance

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| CSS Size | ~120KB | 28.7KB | **76% smaller** |
| Gzipped CSS | ~30KB | 5.12KB | **83% smaller** |
| Build Time | Manual | <1s | ⚡ Lightning fast |

## 📁 Project Structure

```
### Project Structure

```
casestudy-labs-modern-theme/
├── src/
│   ├── styles.css          # Tailwind entry + custom components
│   └── main.js             # Alpine.js + interactions
├── dist/                   # Build output (generated)
│   ├── css/
│   └── js/
├── inc/
│   ├── vite-helper.php     # WordPress + Vite integration
│   └── seo-meta-tags.php   # SEO module
├── functions.php           # Theme functions (updated)
├── package.json            # NPM dependencies
├── tailwind.config.js      # Tailwind configuration
├── vite.config.js          # Vite build config
├── README.md               # Development guide
├── SEO-OPTIMIZATION.md     # SEO documentation
├── SEO-CHECKLIST.md        # SEO manual tasks
└── PROJECT-STATUS.md       # This file
```
```

## 🎯 Deployment

### To Staging19

1. **Commit changes**:
   ```bash
   git add .
   git commit -m "Add Tailwind CSS with Vite"
   git push origin main
   ```

2. **Deploy to SiteGround**:
   - Changes pushed to GitHub
   - Pull on server or use auto-deployment

3. **Build on server**:
   ```bash
   npm install
   npm run build
   ```

## 🛠️ Available Scripts

```bash
npm run dev      # Development mode with HMR
npm run build    # Production build
npm run watch    # Watch mode (auto-rebuild)
npm run preview  # Preview production build
```

## 🧩 Pre-built Components

### Buttons
```html
<a class="btn">Default Button</a>
<a class="btn btn-accent">Accent Button</a>
<a class="btn btn-glass">Glass Button</a>
```

### Glass Effects
```html
<div class="glass-panel">Glass Panel</div>
<div class="glass-realistic">Realistic Glass</div>
<div class="glass-medium">Medium Glass</div>
```

### Animations
```html
<div class="anim-reveal">Fade up on scroll</div>
<div class="anim-slide-left">Slide from left</div>
<div class="anim-slide-right">Slide from right</div>
```

## 📝 Notes

- Legacy `style.css` is commented out (replaced by Tailwind)
- Conditional CSS (contact forms, ticket forms) still loads separately
- Google Fonts still load via CDN
- HubSpot integration included

## 🐛 Troubleshooting

**Assets not loading?**
1. Run `npm run build`
2. Check `dist/` folder exists
3. Clear WordPress cache

**Development mode not working?**
1. Run `npm run dev` in separate terminal
2. Ensure `WP_DEBUG = true` in wp-config.php
3. Check port 5173 is available

**Build errors?**
1. Delete `node_modules` and run `npm install`
2. Check for syntax errors in `src/styles.css`
3. Ensure all Tailwind classes are valid

## 🔗 Links

- **Staging:** https://staging19.casestudy-labs.com/
- **GitHub:** https://github.com/therealjohndough/
- **Tailwind Docs:** https://tailwindcss.com
- **Alpine.js Docs:** https://alpinejs.dev

---

**Built with ❤️ by Case Study Labs**
