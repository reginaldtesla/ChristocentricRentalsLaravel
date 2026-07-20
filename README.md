# Christocentric Rentals

Laravel application for [Christocentric Rentals](https://christocentricrentals.com) — a camera and production equipment rental shop based in Kumasi, Ghana. Customers browse gear, build a cart, and checkout with Paystack. Staff manage products, orders, and site content from an admin panel.

Built with **Laravel 13**, **PHP 8.3+**, **MySQL**, **Tailwind CSS 4**, and **Vite**.

## Features

- Public shop with categories, search, compare, and cart
- Rental checkout with pickup/return scheduling and Paystack payments (demo mode available)
- Admin dashboard for products, categories, orders, newsletters, and site settings
- Product images stored under `public/images/` (WooCommerce uploads + slug-based product files)
- Catalog can be rebuilt from repo assets — no WordPress static clone required for a fresh install

## Requirements

- PHP 8.3+ with extensions: `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` or `imagick`
- Composer 2+
- Node.js 18+ and npm
- MySQL 8+ (Laragon, XAMPP, or standalone)

**Recommended on Windows:** [Laragon](https://laragon.org/) (includes PHP, MySQL, Composer, and Apache/Nginx).

## Installation

Follow these steps on a new machine to get a working local copy with products and images.

### 1. Get the code

```bash
git clone <repository-url> ChristocentricRentals
cd ChristocentricRentals
```

On Laragon, clone into `C:\laragon\www\ChristocentricRentals` so auto-virtual hosts can pick it up.

### 2. Create the MySQL database

Create an empty database **before** `composer install` / migrations (Composer’s package discovery may touch the DB):

```sql
CREATE DATABASE christocentric_rentals CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

In Laragon: open HeidiSQL or MySQL console, run the statement above. The name must match `DB_DATABASE` in `.env` (default: `christocentric_rentals`).

### 3. Install PHP and Node dependencies

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
```

Shortcut (installs deps, generates key, runs migrations, builds frontend assets — **does not** seed or import the catalog):

```bash
composer setup
```

If you use `composer setup`, still run the seed and catalog import steps below.

### 4. Configure `.env`

Edit `.env` for your machine. Important values:

| Variable | Example / notes |
|----------|-----------------|
| `APP_ENV` | `local` |
| `APP_DEBUG` | `true` |
| `APP_URL` | Must match the URL you open in the browser (see below) |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `127.0.0.1` |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | `christocentric_rentals` |
| `DB_USERNAME` | `root` (Laragon default) |
| `DB_PASSWORD` | empty on Laragon by default |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` | Initial admin login (created on seed) |
| `PAYMENT_DEMO_MODE` | `true` for local checkout without Paystack |
| `PAYSTACK_*` | Optional; leave empty in demo mode |

**`APP_URL` must match how you open the site**, or images break. Laravel builds image URLs with `asset()`, which uses `APP_URL`.

| How you run the app | Set `APP_URL` to |
|---------------------|------------------|
| Laragon vhost | `http://christocentricrentals.test` |
| `php artisan serve` | `http://127.0.0.1:8000` |

Do **not** leave `APP_URL` pointing at `https://christocentricrentals.com` while developing locally — product and brand images will 404.

After changing `.env`:

```bash
php artisan config:clear
```

### 5. Migrate, seed, and import the catalog

```bash
php artisan migrate
php artisan db:seed
php artisan catalog:import-images --apply-descriptions
```

This creates:

- Database tables
- **14 categories**
- **~130 products** with images and descriptions
- **1 admin user** from `ADMIN_EMAIL` / `ADMIN_PASSWORD`

Product images ship in the repo under `public/images/` (~2,600+ files). The import reads slug-based files from `public/images/storage/products/` — no WordPress clone or `storage:link` is required for catalog images.

### 6. Build frontend assets (first time or production)

```bash
npm run build
```

For day-to-day CSS/JS development with hot reload, use `npm run dev` instead (see step 7).

### 7. Run the app

**Option A — Laragon (recommended on Windows)**

1. Start Laragon (Apache/Nginx + MySQL).
2. Point the site document root at `public/` (Laragon usually does this for `www\ChristocentricRentals`).
3. Open `http://christocentricrentals.test` (or your configured host).
4. Confirm `APP_URL` matches that host, then `php artisan config:clear` if you changed it.

**Option B — Artisan + Vite (all-in-one)**

```bash
composer dev
```

Starts the PHP server, queue worker, log tail, and Vite together. Open `http://127.0.0.1:8000` and set `APP_URL` to the same.

**Option C — Separate terminals**

```bash
php artisan serve
npm run dev
```

### 8. Verify install

| Check | Expected |
|-------|----------|
| Homepage | Hero, logo, and banners load |
| Shop | Products with real images (not placeholders) |
| Admin | `/admin/login` with your `ADMIN_*` credentials |

Quick image check: open `/images/brand/logo.png` on your local host — it should return the logo file, not a 404.

## Admin panel

- URL: `/admin/login`
- Login uses `ADMIN_EMAIL` and `ADMIN_PASSWORD` from `.env`
- Manage products, orders, categories, newsletters, subscribers, and site settings

## Quick install checklist

Copy-paste sequence after the database exists:

```bash
git clone <repository-url> ChristocentricRentals
cd ChristocentricRentals
composer install
cp .env.example .env
php artisan key:generate
# Edit .env: APP_ENV=local, APP_URL=<your local URL>, DB_* credentials
php artisan migrate
php artisan db:seed
php artisan catalog:import-images --apply-descriptions
npm install
npm run build
# Then: composer dev   OR   open Laragon vhost
```

No `CLONE_PATH` is required when using `catalog:import-images`.

## Project structure (high level)

```
app/
  Console/Commands/   # Catalog import, image tools, WordPress export
  Http/Controllers/   # Shop, checkout, auth, admin
  Models/             # Product, Order, Category, etc.
  Support/            # ProductImage, SiteConfig, ProductDescriptions, …
public/images/        # All site and product images (committed to git)
  banners/
  brand/
  storage/            # WooCommerce uploads (2022–2025) + products/
config/site.php       # Categories, hero slides, clone path default
database/seeders/     # Categories + starter products
```

## Artisan commands

### Catalog (day-to-day)

| Command | Description |
|---------|-------------|
| `catalog:import-images` | **Primary import** — build catalog from `public/images/storage/products/` |
| `catalog:apply-descriptions` | Apply researched descriptions from `ProductDescriptions` |
| `catalog:export-wordpress` | Export CSV for WooCommerce (does not change Laravel data) |

### Catalog (optional — requires WordPress static clone)

Set `CLONE_PATH` in `.env` to a folder containing `shop/`, `product/`, and `storage/` from the old static site export.

| Command | Description |
|---------|-------------|
| `catalog:import-clone` | Import products from clone HTML |
| `catalog:import-descriptions` | Import descriptions from clone HTML |
| `assets:sync-clone` | Copy images from clone and fix product paths |

### Images

| Command | Description |
|---------|-------------|
| `images:rename-products` | Copy images to `storage/products/{slug}.{ext}` |
| `images:remove-backgrounds` | Generate transparent cutouts (requires `rembg`) |

## Payments

- **Paystack** handles checkout when `PAYMENT_DEMO_MODE=false` and keys are set
- **Demo mode** (`PAYMENT_DEMO_MODE=true`) lets you complete test orders without charging cards

Currency defaults to GHS (`PAYSTACK_CURRENCY=GHS`).

## Troubleshooting

**`composer install` fails on `package:discover` with “Unknown database”**

Create the MySQL database first, then run `composer install` again.

**`APPLICATION IN PRODUCTION` prompt on seed/migrate**

Set `APP_ENV=local` in `.env` for local development.

**Logo / product images return 404 or load from the live site**

Set `APP_URL` to your local URL (e.g. `http://christocentricrentals.test`), then run `php artisan config:clear`. Do not use the production domain while developing locally.

**Products show placeholder images**

Run `php artisan catalog:import-images` to relink products to files in `public/images/storage/products/`. Catalog images live under `public/images/` — `php artisan storage:link` is not required for them.

**Clone commands say “Clone path not found”**

You can ignore them. Use `catalog:import-images` instead, or set `CLONE_PATH` if you still have the WordPress static export.

## License

MIT
