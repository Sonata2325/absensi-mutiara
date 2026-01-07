# Copilot / AI Agent Instructions for mutiara-web

Purpose: quick, actionable guide so an AI coding agent can be productive immediately in this repository.

## Big picture
- This is a small Laravel 11 web app (PHP 8.2). It's mostly a server-rendered site with Blade views and a simple order flow handled in-session (no persistent `orders` table).
- Main request flow: client -> routes (routes/web.php) -> `App\Http\Controllers\PageController` -> `resources/views/*.blade.php`.
- Frontend assets are built with Vite + Tailwind (`package.json` scripts). CSS/JS entry points: `resources/css/app.css`, `resources/js/app.js`.

## Key files to inspect first
- `routes/web.php` — canonical URLs and localised aliases (e.g. `/pesan` and `/order`).
- `app/Http/Controllers/PageController.php` — order/contact/tracking endpoints; order is kept in session under `last_order` and redirected to `order.success` with a generated `resi` like `MJEyymmddXXXXX`.
- `resources/views/` — Blade templates for pages (home, order, order-success, contact, etc.). Look for `@vite()` usage in `welcome.blade.php`.
- `composer.json` — project PHP requirement, dev deps (Pest, Pint, Sail), and composite scripts (notable: `setup`, `dev`, `test`).
- `package.json` & `vite.config.js` — Vite scripts and plugin configuration.
- `phpunit.xml` and `tests/` — test configuration and Pest-based tests.
- `.env` — default environment setup: DB = sqlite, SESSION_DRIVER=database. Keep in mind sessions use the database driver by default here.

## Development & common commands (concrete)
- Full setup (preferred):
  - `composer run-script setup`  (runs composer install, copies `.env`, `php artisan key:generate`, runs migrations, `npm install`, `npm run build`)
- Quick dev (recommended):
  - `composer run-script dev`  (runs `php artisan serve`, `php artisan queue:listen --tries=1`, and `npm run dev` via `concurrently`)
  - Or run components manually: `php artisan serve` + `npm run dev` + `php artisan queue:listen`.
- Build assets: `npm run build` (Vite production build).
- Run tests: `composer run-script test` OR `./vendor/bin/pest` (Pest is configured; `php artisan test` is used in the script).
- Lint / format: run `./vendor/bin/pint` (Pint is included in dev dependencies).
- Queue: app enqueues to `database` connection by default — run `php artisan queue:work` or `php artisan queue:listen`.

## Project-specific patterns & gotchas
- Orders are NOT persisted — they are stored in session only (`$request->session()->put('last_order', $order)`). If you add persistence, add migrations and tests.
- Service types: `b2b` or `b2c` — look at `submitOrder()` to see how sender/receiver payload shape differs and how `orderSuccess()` computes `office` info for `b2c`.
- Routes are duplicated for Indonesian/English (e.g. `/pesan` and `/order`) — prefer named routes (e.g., `route('order')`) when linking.
- Default `.env` is configured for SQLite + DB sessions; ensure migrations run when adding DB-backed features.
- `phpunit.xml` sets `APP_ENV=testing` and faster hashes (`BCRYPT_ROUNDS=4`) — tests may rely on this.

## Tests & where to add them
- Add Feature tests in `tests/Feature/` and Unit tests in `tests/Unit/` using Pest syntax (see `tests/Pest.php`).
- Example test runner: `./vendor/bin/pest --filter submitOrder` or `composer test`.

## Integration points & external dependencies
- No external APIs are currently integrated.
- Optional Docker: `laravel/sail` is available in dev deps — use `vendor/bin/sail` if you prefer containerized development.
- Frontend: Vite + Tailwind; changes to `resources/js` or `resources/css` require `npm run dev` (for dev) or `npm run build` (for production).

## PR guidance for contributors (and AI agents)
- When changing behaviour that relies on sessions (e.g., order flow), add Feature tests asserting session contents and response redirects.
- If adding DB-backed features, include a migration and test data setup in tests (migrations use sqlite by default during initial setup).
- Run `composer test` and `./vendor/bin/pint` before opening a PR.

---
If anything above is unclear or you'd like more examples (e.g., a test that asserts `last_order` contents), tell me which area to expand and I will add a short example test and a snippet to this file. ✅
