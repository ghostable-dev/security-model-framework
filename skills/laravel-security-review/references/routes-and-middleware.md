# Routes And Middleware

Review route files before trusting controller logic.

## Files To Check

- `routes/web.php`
- `routes/api.php`
- `routes/console.php`
- `routes/channels.php`
- route files loaded from service providers
- `app/Http/Middleware`
- `bootstrap/app.php` for Laravel 11+ middleware aliases
- `app/Http/Kernel.php` for older apps

## Checks

- Public routes are intentional and listed in `SECURITY_MODEL.md`.
- Protected web routes use `auth`, guard-specific auth, or equivalent middleware.
- API routes use `auth:sanctum`, Passport, token middleware, or documented custom auth.
- Admin routes require `auth:admin` or an explicit admin permission.
- Billing routes require an explicit billing permission such as `billing.manage`.
- Webhooks verify provider signatures and do not assume normal session auth.
- Guest routes such as login, register, invite, and password reset are throttled.
- Debug, preview, health, test, telescope, horizon, pulse, or internal routes are not publicly exposed in production unless intended.

## Commands

Use when available:

```bash
php artisan route:list
php artisan route:list --path=admin
php artisan route:list --path=api
php artisan route:list --path=billing
```

## Common Failures

- Route groups added without middleware.
- Public POST routes without CSRF, throttling, or signature verification.
- Admin route prefix without admin authorization.
- API token authentication without object-level authorization.
- Route model binding used before checking ownership.

