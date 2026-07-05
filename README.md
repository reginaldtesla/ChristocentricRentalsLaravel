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

- PHP 8.3+
- Composer
- Node.js 18+ and npm
- MySQL 8+ (Laragon, XAMPP, or standalone)

## Local setup

### 1. Clone and install dependencies

```bash
git clone <repository-url> ChristocentricRentals
cd ChristocentricRentals

composer install
cp .env.example .env   # skip if .env already exists
php artisan key:generate
npm install
```

Or use the bundled setup script (does not seed the catalog):

```bash
composer setup
```

### 2. Create the database

Create an empty MySQL database before running migrations:

```sql
CREATE DATABASE christocentric_rentals CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

In Laragon, you can also create it from HeidiSQL or the MySQL console. Match the name to `DB_DATABASE` in `.env` (default: `christocentric_rentals`).

### 3. Configure environment

Edit `.env` for your machine. At minimum:

| Variable | Purpose |
|----------|---------|
| `APP_ENV` | Use `local` for development |
| `APP_URL` | e.g. `http://christocentricrentals.test` or `http://127.0.0.1:8000` |
| `DB_*` | MySQL connection |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` | Initial admin account (created on seed) |
| `PAYSTACK_*` | Payment keys (leave empty to use demo mode) |
| `PAYMENT_DEMO_MODE` | `true` skips real Paystack charges locally |

### 4. Migrate and seed the catalog

```bash
php artisan migrate
php artisan db:seed
php artisan catalog:import-images --apply-descriptions
```

This gives you:

- **14 categories**
- **~130 products** with images and descriptions
- **1 admin user** from your `.env` credentials

Product images ship with the repo under `public/images/` (~2,600+ files). The import command reads slug-based filenames from `public/images/storage/products/` and does not need a WordPress export.

### 5. Run the app

**Option A — Laragon virtual host**

Point a vhost at `public/` and open your local URL.

**Option B — Artisan + Vite**

```bash
composer dev
```

This starts the PHP server, queue worker, log tail, and Vite dev server together.

Or run them separately:

```bash
php artisan serve
npm run dev
```

For production assets:

```bash
npm run build
```

## Admin panel

- URL: `/admin/login`
- Login uses the account from `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env`
- Manage products, orders, categories, newsletters, subscribers, and site settings

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

## Fresh install checklist

After cloning on a new machine:

```bash
composer install
cp .env.example .env
php artisan key:generate
# Create MySQL database christocentric_rentals
php artisan migrate
php artisan db:seed
php artisan catalog:import-images --apply-descriptions
npm install && npm run dev
```

No `CLONE_PATH` is required if you use `catalog:import-images`.

## Payments

- **Paystack** handles checkout when `PAYMENT_DEMO_MODE=false` and keys are set
- **Demo mode** (`PAYMENT_DEMO_MODE=true`) lets you complete test orders without charging cards

Currency defaults to GHS (`PAYSTACK_CURRENCY=GHS`).

## Troubleshooting

**`composer install` fails on `package:discover` with “Unknown database”**

Create the MySQL database first, then run `composer install` again.

**`APPLICATION IN PRODUCTION` prompt on seed/migrate**

Set `APP_ENV=local` in `.env` for local development.

**Products show placeholder images**

Run `php artisan catalog:import-images` to relink products to files in `public/images/storage/products/`.

**Clone commands say “Clone path not found”**

You can ignore them. Use `catalog:import-images` instead, or set `CLONE_PATH` if you still have the WordPress static export.

## License

MIT
