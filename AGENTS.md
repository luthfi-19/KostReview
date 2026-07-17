# KostReview — Agent Instructions

## Project

Laravel 13 boarding-house ("kost") review platform. PHP 8.3+, Vite + Tailwind CSS 3 + Alpine.js. SQLite default (DB_CONNECTION=sqlite). Indonesian codebase comments.

## Key Commands

```bash
composer setup          # full setup: install, key, migrate, npm, build
composer dev            # runs artisan serve + queue + pail + vite concurrently
composer test           # clears config cache, then runs phpunit
php artisan migrate     # run migrations (force flag needed in prod)
php artisan db:seed     # seeders: AdminSeeder, CampusSeeder, FacilitySeeder, DummyKostSeeder, StudentDummySeeder
```

Run a single test: `php artisan test --filter=TestClassName` or `phpunit --filter=testMethodName`

## Architecture

**Three roles** — enforced via `App\Http\Middleware\RoleMiddleware` (registered as `role` alias in `bootstrap/app.php`):
- `student` (default) — search/browse, apply for occupancy, leave reviews
- `owner` — manage kost listings, approve/reject occupancies
- `admin` — dashboard, moderation (delete kosts), manage campuses/facilities/users

**Domain models**: `User`, `Kost`, `Campus`, `Facility`, `KostImage`, `Occupancy`, `Review`
- `kost_campus` and `kost_facility` are pivot tables (no model classes)

**Routes**: All in `routes/web.php`. Auth routes via `routes/auth.php` (Laravel Breeze).
- Public: `/` (catalog with search/filter), `/kost/{kost}` (detail)
- Auth-gated sections nested under `role:student`, `role:owner`, `role:admin` middleware groups

**Views**: Blade templates in `resources/views/`. Layouts: `layouts/app.blade.php`, `layouts/guest.blade.php`.
- Dashboard views per role in `resources/views/dashboard/`

## Testing

PHPUnit 12 with SQLite in-memory DB (`phpunit.xml` overrides). Tests in `tests/Feature/` and `tests/Unit/`. Tests use `Tests\TestCase` base class (no RefreshDatabase trait by default — check individual tests).

## Conventions

- 4-space indent, LF line endings, UTF-8 (`.editorconfig`)
- `composer test` clears config cache before running — preferred over raw `phpunit`
- `.npmrc` sets `ignore-scripts=true` — npm postinstall hooks are suppressed
- Code comments are in Indonesian (Bahasa Indonesia)
