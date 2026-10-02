# Security Dog Handler Certificate Management System

Production-ready Laravel application for issuing, verifying, and exporting Security Dog Handler certificates (BASDU-style).

## Requirements

- **PHP 8.3+** (Laravel 13)
- **Composer 2**
- **MySQL 8+** (or SQLite for local demos)
- PHP extensions: `bcmath`, `ctype`, `curl`, `fileinfo`, `gd`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`

> Local XAMPP PHP 8.0 is **not** supported. Use PHP 8.3+ (Herd, Docker, upgraded XAMPP, or WinGet `PHP.PHP.8.3`).

**No Node.js / Vite required.** Frontend is Blade + static CSS + CDN Alpine; admin uses AdminLTE from `public/vendor`.

## Quick start

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### MySQL (recommended)

In `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=certificate_management
DB_USERNAME=root
DB_PASSWORD=
```

Create the database, then:

```bash
php artisan migrate --seed
php artisan serve
```

### SQLite (optional local demo)

```env
DB_CONNECTION=sqlite
```

```bash
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

## Default admin accounts

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `admin@example.com` | `password` |
| Admin | `staff@example.com` | `password` |

**Change these immediately in production.**

## Important URLs

| Area | URL |
|------|-----|
| Public home | `/` |
| Certificate listing | `/certificates` |
| Verify | `/verify/{slug}` e.g. `/verify/BASDU-OA-2025-0147` |
| Hidden admin login | `/secure-admin/login` |
| Admin dashboard | `/secure-admin/dashboard` |

Stored certificate numbers use slashes (`BASDU/OA/2025/0147`). Public URLs use dashes (`BASDU-OA-2025-0147`).

## Features

- Role-based admin panel (`admin`, `super_admin`) behind `/secure-admin`
- Certificate CRUD with auto-generated unique numbers
- BASDU-style certificate design (double border, PASS/FAIL badge, signatures, seal)
- Code128 barcode (`milon/barcode`) encoding the exact certificate number
- QR verification link (PNG via GD-compatible generator)
- PDF download (`barryvdh/laravel-dompdf`)
- PNG download (`intervention/image` GD compositing)
- Public search, listing, detail, comments (moderated)
- Soft deletes on certificates and comments

## Branding assets

- Logo: `public/images/logo.png` (replace with your official logo)
- Fonts used for PNG export: `resources/fonts/` (`georgia.ttf`, `script.ttf`, etc.)

## Frontend (no Node / Vite)

Public UI:
- Blade templates
- Static CSS: `public/css/site.css`
- Alpine.js via CDN (mobile menu)

Admin UI:
- AdminLTE / Bootstrap from `public/vendor`

## Deploy on Vercel

This is a **Laravel PHP app**, not a static Vite site. Vercel’s default Vite preset looks for a `dist` folder and will fail — do **not** set Framework Preset to Vite or Output Directory to `dist`.

This repo includes container deployment files:

- [`vercel.json`](vercel.json)
- [`Dockerfile.vercel`](Dockerfile.vercel)
- [`Caddyfile`](Caddyfile)

### Vercel project settings

1. Framework Preset: **Other** (or leave blank)
2. Build / Output Directory: leave empty (handled by `vercel.json` container service)
3. Root Directory: project root

### Required environment variables

Set these in Vercel → Project → Settings → Environment Variables:

| Variable | Notes |
|----------|--------|
| `APP_KEY` | Run `php artisan key:generate --show` locally and paste the value |
| `APP_URL` | Your Vercel URL, e.g. `https://your-app.vercel.app` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `mysql` (or `pgsql`) |
| `DB_HOST` / `DB_PORT` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | External database (Vercel has no built-in MySQL) |

Optional but recommended:

- `SESSION_DRIVER=cookie` (already defaulted in Docker)
- `CACHE_STORE=database` or Redis if you need shared cache
- `LOG_CHANNEL=stderr`

### After first deploy

Run migrations against your external database from your machine (or CI):

```bash
php artisan migrate --force --seed
```

### Important limits

- Container filesystem is **not durable** — use an external DB; do not rely on local SQLite/uploads for production.
- Certificate PDF/PNG generation needs the GD extension (already installed in `Dockerfile.vercel`).

## Security notes

- Session auth only (no JWT)
- CSRF protection on forms
- Admin routes require `auth` + active status + role middleware
- Public registration is disabled
