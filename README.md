# Security Dog Handler Certificate Management System

Production-ready Laravel application for issuing, verifying, and exporting Security Dog Handler certificates (BASDU-style).

## Requirements

- **PHP 8.3+** (Laravel 13)
- **Composer 2**
- **Node.js 18+** (Vite / Tailwind build)
- **MySQL 8+** (or SQLite for local demos)
- PHP extensions: `bcmath`, `ctype`, `curl`, `fileinfo`, `gd`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`

> Local XAMPP PHP 8.0 is **not** supported. Use PHP 8.3+ (Herd, Docker, upgraded XAMPP, or WinGet `PHP.PHP.8.3`).

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
npm install
npm run build
php artisan serve
```

### SQLite (optional local demo)

```env
DB_CONNECTION=sqlite
```

```bash
touch database/database.sqlite
php artisan migrate --seed
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

## Admin UI

The secure admin panel uses **[Laravel AdminLTE v4](https://jeroennoten.github.io/Laravel-AdminLTE/)** (AdminLTE 4 + Bootstrap 5.3):

```bash
composer require jeroennoten/laravel-adminlte
npm i bootstrap@^5.3 bootstrap-icons@^1.13 overlayscrollbars@^2.11 @fontsource/source-sans-3@^5.3
php artisan adminlte:install
```

Configuration lives in `config/adminlte.php` (branding, sidebar menu, dark sidebar theme).

## Security notes

- Session auth only (no JWT)
- CSRF protection on forms
- Admin routes require `auth` + active status + role middleware
- Public registration is disabled
