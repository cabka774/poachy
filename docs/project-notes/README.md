## Poachy backend fixes (Fix 1–Fix 9)

This folder summarizes backend hardening and related changes implemented in this repository (historical notes).

### Fix 1 — Add indexes to all migrations (performance)

- Updated migrations:
  - `database/migrations/2026_04_20_125046_create_products_table.php`
  - `database/migrations/2026_04_20_125219_create_sales_and_sale_items_tables.php`
  - `database/migrations/2026_04_20_150841_create_expenses_table.php`
  - `database/migrations/2026_04_20_150842_create_customers_table.php`
  - `database/migrations/2019_09_15_000020_create_domains_table.php`
  - `database/migrations/0001_01_01_000002_create_jobs_table.php`

### Fix 2 — Base `ApiResponse` trait for consistent response envelopes

- Added:
  - `app/Http/Responses/ApiResponse.php`
- Updated API controllers to use the trait:
  - `app/Http/Controllers/Api/AuthController.php`
  - `app/Http/Controllers/Api/CustomerController.php`
  - `app/Http/Controllers/Api/DashboardController.php`
  - `app/Http/Controllers/Api/ExpenseController.php`
  - `app/Http/Controllers/Api/InventoryController.php`
  - `app/Http/Controllers/Api/POSController.php`
  - `app/Http/Controllers/Api/ReportsController.php`
  - `app/Http/Controllers/Api/SettingsController.php`

### Fix 3 — Update all Models

- Updated models:
  - `app/Models/User.php`
  - `app/Models/Product.php`
  - `app/Models/Sale.php`
  - `app/Models/SaleItem.php`
  - `app/Models/Customer.php`
  - `app/Models/Expense.php`
  - `app/Models/Setting.php`
  - `app/Models/Tenant.php`
  - `app/Models/Domain.php`

### Fix 4 — All Controllers rewritten

- API controllers standardized and corrected.
- Web controllers tightened:
  - `app/Http/Controllers/WebAuthController.php`
  - `app/Http/Controllers/PoachyController.php`
- Removed misplaced file:
  - deleted `app/Http/Controllers/api.ts`

Important correctness fix included in Fix 4:
- `SettingsController::changePassword()` now validates with `current_password` and hashes the new password.

### Fix 5 — Routes with rate limiting, removed dead web routes

- Added rate limiters:
  - `app/Providers/AppServiceProvider.php`
- Applied throttles:
  - `routes/api.php`
  - `routes/web.php`
- Removed a duplicate/invalid web routes artifact (Windows path duplication) and restored `routes/web.php`.

### Fix 6 — CORS locked to env variable, not hardcoded

- Updated:
  - `config/cors.php` (uses `CORS_ALLOWED_ORIGINS`)
  - `bootstrap/app.php` (CORS middleware enabled)
  - `.env.example` (documents `CORS_ALLOWED_ORIGINS`)

### Fix 7 — `.env` with `APP_KEY` instruction and `SESSION_ENCRYPT`

- Updated:
  - `.env.example` (documents `php artisan key:generate`, sets `SESSION_ENCRYPT=true`)

### Fix 8 — Seeder: admin user only, no hardcoded products

- Updated:
  - `database/seeders/DatabaseSeeder.php` (admin-only seeding, env-driven)
- Updated:
  - `.env.example` (added `SEED_ADMIN_EMAIL`, `SEED_ADMIN_NAME`, `SEED_ADMIN_PASSWORD`)

### Fix 9 — `.gitignore` to prevent `.env` from ever being committed again

- Updated:
  - `.gitignore` (ignores `.env` and `.env.*`, keeps `!.env.example`)

