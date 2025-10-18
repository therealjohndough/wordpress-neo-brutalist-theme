# NEO-BRUTALIST-WP-THEME-CUSTOM

This repository contains the custom WordPress theme for the staging site at https://staging19.casestudy-labs.com/.

## Overview
- **Theme Name**: NEO-BRUTALIST-WP-THEME-CUSTOM
- **WordPress Version**: Compatible with WordPress 5.0+
- **Staging Site**: https://staging19.casestudy-labs.com/

## Recent Audit (October 17, 2025)
The theme was audited by Qwen3-Coder for mobile responsiveness and performance issues. Key findings and fixes are documented below.

### Critical Issues Identified
1. **100vh Mobile Problems**: Using `100vh` causes content to be hidden under mobile browser UI
2. **Fixed Header Overlap**: Fixed navigation overlaps page content
3. **Horizontal Overflow**: Elements overflow on mobile screens
4. **Missing Safe Areas**: No support for iPhone notches and safe areas

### Required Fixes
Apply these changes to improve mobile experience:

#### 1. Replace 100vh with Dynamic Viewport Units
**File**: `style.css` or relevant CSS files

```css
/* Replace all instances of 100vh with 100dvh */
.hero-section, .full-height-section {
  min-height: 100dvh; /* Modern browsers */
}

/* Fallback for older browsers */
@supports not (min-height: 100dvh) {
  .hero-section, .full-height-section {
    min-height: calc(var(--vh, 1vh) * 100);
  }
}
```

#### 2. Add JavaScript for Viewport Height
**File**: `functions.php` or custom JS file

```javascript
// Add to theme's JavaScript
function setVH() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}

setVH();
window.addEventListener('resize', setVH);
```

#### 3. Fix Header Overlap
**File**: `style.css`

```css
/* Add padding to body to account for fixed header */
body {
  padding-top: 80px; /* Adjust to match header height */
}

@media (max-width: 768px) {
  body {
    padding-top: 60px; /* Smaller on mobile */
  }
}
```

#### 4. Prevent Horizontal Overflow
**File**: `style.css`

```css
/* Prevent horizontal scrolling */
body {
  overflow-x: hidden;
}

/* Constrain wide elements */
.container, .section {
  max-width: 100%;
  overflow-x: hidden;
  box-sizing: border-box;
}
```

#### 5. Add Safe Area Support
**File**: `style.css`

```css
/* Safe area support for notched devices */
@supports (padding: max(0px)) {
  .header, .footer {
    padding-left: max(12px, env(safe-area-inset-left));
    padding-right: max(12px, env(safe-area-inset-right));
  }

  .footer {
    padding-bottom: max(12px, env(safe-area-inset-bottom));
  }
}
```

## Development Rules for AI Assistants (Qwen)

### Important: Do Not Modify These Files Without Review
- `functions.php` - Core theme functionality
- `index.php` - Main template
- `header.php` - Site header
- `footer.php` - Site footer
- `style.css` - Main stylesheet

### Safe Modification Areas
- Custom CSS in `custom-styles.css` (if exists)
- Custom JavaScript in `custom-scripts.js` (if exists)
- Page templates in `template-parts/`
- Custom post types in `inc/`

### Testing Requirements
Before committing changes:
1. Test on mobile devices (iOS Safari, Chrome mobile)
2. Check viewport meta tag is present
3. Verify no horizontal scrolling
4. Test header positioning on scroll
5. Validate in Chrome DevTools device emulation

### Deployment
1. Commit changes to this repo
2. Push to GitHub
3. Use rsync or FTP to deploy to staging server
4. Test on live staging site
5. Backup before major changes

### Performance Optimizations
- Use lazy loading for images
- Minify CSS/JS for production
- Optimize font loading with `font-display: swap`
- Remove unused styles/scripts

## File Structure
```
NEO-BRUTALIST-WP-THEME-CUSTOM/
├── style.css                 # Main stylesheet
├── functions.php             # Theme functions
├── index.php                 # Main template
├── header.php                # Header template
├── footer.php                # Footer template
├── page.php                  # Page template
├── single.php                # Single post template
├── archive.php               # Archive template
├── search.php                # Search template
├── 404.php                   # 404 template
├── template-parts/           # Template parts
├── inc/                      # Includes
├── assets/                   # CSS, JS, images
│   ├── css/
│   ├── js/
│   └── images/
└── README.md                 # This file
```

## Contact
For questions about this theme, contact the development team.