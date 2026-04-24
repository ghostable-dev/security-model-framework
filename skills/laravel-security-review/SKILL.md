---
name: laravel-security-review
description: Use when reviewing or changing Laravel security-sensitive code, including routes, middleware, guards, policies, gates, form requests, Eloquent models, API resources, Livewire components, jobs, events, notifications, storage, config, environment variables, billing, admin areas, tenancy, or SECURITY_MODEL.md enforcement.
metadata:
  short-description: Review Laravel changes against SECURITY_MODEL.md
---

# Laravel Security Review

Use this skill before changing or reviewing Laravel code that can affect authentication, authorization, tenancy, sensitive data exposure, secrets, files, queues, events, notifications, billing, admin behavior, or API/Livewire payloads.

## Fast Workflow

1. Read `SECURITY_MODEL.md` first. If missing, use `templates/SECURITY_MODEL.laravel.md` from this project as the expected model shape.
2. Identify touched surfaces: routes, controllers, requests, policies, models, resources, Livewire, jobs, events, notifications, config, storage, tests.
3. Run the hotspot scanner when working in a Laravel app:

```bash
php skills/laravel-security-review/scripts/laravel-security-hotspots.php
```

If this skill was copied elsewhere, run the script from its actual path.

4. Read only the focused references needed:

- Routes and middleware: `references/routes-and-middleware.md`
- Policies, gates, tenancy, route model binding: `references/authorization-and-tenancy.md`
- Models, API resources, Livewire serialization: `references/data-exposure.md`
- Secrets, config, files, queues, events, notifications: `references/secrets-and-side-effects.md`
- Tests and final audit output: `references/tests-and-output.md`

5. Make the smallest code change that satisfies the security model.
6. Add or update tests when behavior changes or a risk is security-relevant.
7. Return structured audit output. Never mark `Pass` unless directly verified.

## Required Final Output

```md
## Laravel Security Audit Output

| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Route middleware correct | Pass/Fail/Unknown |  |  |
| Public routes reviewed | Pass/Fail/Unknown |  |  |
| Policy/gate/form request authorization | Pass/Fail/Unknown |  |  |
| Missing model policies checked | Pass/Fail/Unknown |  |  |
| Team/account/tenant scoping | Pass/Fail/Unknown |  |  |
| Route model binding safe | Pass/Fail/Unknown |  |  |
| Mass assignment safe | Pass/Fail/Unknown |  |  |
| Sensitive serialization safe | Pass/Fail/Unknown |  |  |
| Secret exposure checked | Pass/Fail/Unknown |  |  |
| Hard-coded ENV/credentials checked | Pass/Fail/Unknown |  |  |
| Tests added or updated | Pass/Fail/Unknown |  |  |

### Failed Checks

- 

### Unknowns

- 

### Residual Risk

- 
```

## Pass/Fail Standard

- `Pass`: verified directly with code, config, command output, or tests.
- `Fail`: verified missing or unsafe behavior.
- `Unknown`: not enough evidence to prove pass or fail.

