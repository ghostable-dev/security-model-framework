---
name: laravel-security-model-author
description: Use when creating, filling in, or updating SECURITY_MODEL.md for a Laravel application by inspecting routes, guards, policies, models, Livewire components, API resources, jobs, config, storage, billing, admin areas, tests, and sensitive data flows.
metadata:
  short-description: Generate Laravel SECURITY_MODEL.md from code
---

# Laravel Security Model Author

Use this skill to create or update `SECURITY_MODEL.md` for an existing Laravel app.

## Workflow

1. Start from `templates/SECURITY_MODEL.laravel.md` if no model exists.
2. Inspect the application before writing claims.
3. Prefer concrete project facts over generic guidance.
4. Mark unknowns explicitly instead of inventing security rules.
5. Keep the final model strict enough for AI agents to enforce during future changes.

## Discovery Order

1. Routes and middleware: `routes/*`, `php artisan route:list`, middleware aliases.
2. Authentication: `config/auth.php`, Fortify/Jetstream/Breeze/Sanctum/Passport config, guards, providers.
3. Authorization: `app/Policies`, gates, form requests, controller authorization calls.
4. Tenancy: team/account/organization/tenant models, membership tables, global scopes, current tenant helpers.
5. Sensitive models: models with credentials, tokens, secrets, payment data, private files, permission overrides.
6. Exposure surfaces: API resources, Livewire public properties, views, broadcasts, notifications, mail.
7. Side effects: jobs, events, listeners, failed jobs, logs, storage, webhooks.
8. Config: CORS, filesystems, logging, session, queue, cache, debug, `.env.example`.
9. Tests: authorization, policy, feature, Livewire, API, webhook, file access tests.

## Output Rules

- Write `SECURITY_MODEL.md` as a contract, not an essay.
- Include route patterns and required protection.
- Include sensitive models and required controls.
- Include critical rules that must never be violated.
- Include AI agent instructions with pass/fail/unknown audit output.
- Do not claim a protection exists unless verified.

For model section details, read `references/model-sections.md`.

