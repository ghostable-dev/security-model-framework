# Laravel Security Model

This file defines the expected security behavior of this Laravel application. It should be used by engineers, reviewers, and AI coding agents before changing controllers, routes, middleware, policies, gates, requests, resources, Livewire components, jobs, listeners, notifications, events, models, casts, storage, or configuration.

## Application Security Summary

- Laravel version:
- Application type:
- Primary users:
- Admin users:
- Authentication stack: Fortify / Breeze / Jetstream / custom / other
- API authentication: Sanctum / Passport / token guard / other
- Authorization model: policies / gates / roles / permissions / custom
- Tenancy model: user / team / account / organization / custom
- Billing model:
- Queue driver:
- Broadcast driver:
- Storage disks:
- Error reporting services:

## Authentication

Document the actual guards and providers in use.

| Area | Guard | Provider | Middleware | Notes |
| --- | --- | --- | --- | --- |
| Web app | `web` | `users` | `auth` |  |
| Admin | `admin` | `admins` | `auth:admin` |  |
| API | `sanctum` | `users` | `auth:sanctum` |  |

### Authentication Rules

- Laravel Fortify, Breeze, Jetstream, or the custom auth layer must be the single source of truth for user login behavior.
- Admin access must use an explicit guard, role, permission, or policy check. Do not rely on route names or UI hiding.
- API requests must authenticate with Sanctum, Passport, or an explicitly documented token guard.
- Password reset tokens, remember tokens, session cookies, personal access tokens, and API keys must never be logged, rendered, queued, broadcast, or returned in API resources.
- Session fixation protections must remain enabled during login.
- MFA changes must require an authenticated user and should require password confirmation.

## Authorization

### Default Rule

Deny by default. Every non-public action must be protected by middleware, a policy, a gate, a form request authorization method, or an explicit service-layer authorization check.

### Ownership And Tenancy

Document the expected scope.

- Current user accessor:
- Current team/account/tenant accessor:
- Global scopes:
- Team/account membership model:
- Admin bypass rule:

Critical rules:

- All project resources must be scoped to the current team/account/tenant where applicable.
- Users may never access resources outside their authorized team/account/tenant.
- Route model binding must not bypass ownership checks.
- Queries for index, show, update, delete, export, search, autocomplete, and bulk actions must all apply the same scope.
- Background jobs must not assume a user still has access if access can change after dispatch.

## Policies And Gates

Every sensitive Eloquent model should have a policy or an explicitly documented alternative.

| Model | Policy/Gate | Required Abilities | Notes |
| --- | --- | --- | --- |
| User | `UserPolicy` | view, update, delete |  |
| Team | `TeamPolicy` | view, update, invite, removeMember |  |
| Project | `ProjectPolicy` | viewAny, view, create, update, delete | Must be team-scoped |
| Environment | `EnvironmentPolicy` | view, update, delete | Sensitive |
| EnvironmentVariable | `EnvironmentVariablePolicy` | view, update, delete | Secret-bearing |
| DeployToken | `DeployTokenPolicy` | view, create, revoke | Secret-bearing |

### Missing Policy Checks

Agents must check for sensitive models without policies by reviewing:

- `app/Models`
- `app/Policies`
- `AuthServiceProvider` or Laravel 11+ provider registration
- controller calls to `$this->authorize(...)`
- `Gate::authorize(...)`
- `can` middleware
- form request `authorize()` methods
- Livewire action authorization

If a sensitive model has no policy, the audit result must be `Fail` unless another explicit authorization mechanism is documented with evidence.

## Route Expectations

| Route Pattern | Expected Middleware | Additional Checks |
| --- | --- | --- |
| `/` | public | Must expose public data only |
| `/login` | guest | Throttled |
| `/register` | guest | Throttled or disabled |
| `/dashboard/*` | `auth` | User/team scoped |
| `/admin/*` | `auth:admin` or admin permission | Must not rely on UI hiding |
| `/api/*` | `auth:sanctum` or documented API guard | Token abilities and object authorization |
| `/billing/*` | `auth` plus billing permission | Account ownership and billing role |
| `/webhooks/*` | signature verification | No normal session auth assumption |

### Open Route Rules

- Every public route must be intentionally listed or justified.
- Public routes must not return private models, internal IDs that enable enumeration, debug output, signed storage paths, stack traces, or environment details.
- Public POST routes must use validation, throttling, CSRF where applicable, or webhook signature verification.

## Sensitive Models

Add all models that deserve extra scrutiny.

| Model | Sensitive Fields | Required Controls |
| --- | --- | --- |
| User | email, password, remember_token, recovery data | Hidden fields, policy, audit events |
| Team | billing data, ownership metadata | Membership checks |
| Environment | provider metadata, team ownership | Team scoped policy |
| EnvironmentVariable | key, encrypted value, decrypted value | Encrypt at rest, never expose plaintext |
| DeployToken | token, token hash, abilities | Hash at rest, one-time reveal |
| TeamPermissionOverride | permission grants | Admin-only updates, audit log |

## Eloquent Model Rules

- Sensitive attributes must be listed in `$hidden` when they should never serialize.
- Use casts for encrypted fields where appropriate, but do not assume casts make exposure safe.
- Accessors must not accidentally decrypt secrets for JSON serialization.
- `toArray()`, `toJson()`, API resources, Livewire public properties, broadcasts, and notifications must be checked for accidental exposure.
- Mass assignment rules must prevent users from setting privileged fields such as `is_admin`, `role`, `team_id`, `owner_id`, `billing_status`, `email_verified_at`, or permission flags.
- Route model binding must be paired with policy or scope checks.

## API Resources And Serialization

- API resources must explicitly choose fields.
- Do not return raw Eloquent models from controllers for sensitive resources.
- Never include encrypted secret values, decrypted secret values, tokens, password hashes, remember tokens, provider credentials, internal permission overrides, or billing provider raw payloads.
- Include authorization-derived fields only when the caller is allowed to know them.
- Search, export, and bulk endpoints must use the same resource exposure rules.

## Livewire Rules

- Treat public properties as browser-visible.
- Never store plaintext secrets, decrypted environment values, API tokens, private keys, or sensitive provider payloads in public Livewire properties.
- Authorize Livewire actions the same way controller actions are authorized.
- Validate all Livewire input server-side.
- Re-check team/account ownership inside actions that mutate data.
- Avoid trusting model IDs sent from the browser.
- Use locked or computed properties where appropriate, but do not treat them as a substitute for authorization.

## Secrets And Environment Values

Critical rules:

- Never expose plaintext secrets in logs, queues, events, notifications, exceptions, error reporters, browser payloads, API responses, Livewire state, broadcasts, or source maps.
- Environment variables must only be decrypted in the smallest possible scope.
- If client-side decryption is required, the server must not receive or log the plaintext value.
- Deploy tokens must be hashed at rest when they do not need to be recovered.
- One-time tokens must only be shown once.
- `.env` values must never be committed, copied into docs as real examples, printed in CI, or hard-coded in config defaults.

## Config And ENV Checks

Agents must look for:

- hard-coded credentials in `config/*`, `app/*`, `routes/*`, tests, seeders, factories, docs, Docker files, CI files, and frontend assets
- unsafe `APP_DEBUG=true` assumptions
- broad CORS origins
- insecure cookie settings
- missing `SESSION_SECURE_COOKIE` or equivalent production setting
- queue, cache, mail, broadcast, filesystem, and logging config that may leak sensitive data
- public disks used for private files

## Controllers, Form Requests, And Services

- Controllers must authorize before reading or mutating private resources.
- Form request `authorize()` must not return `true` for sensitive actions unless another authorization check is proven.
- Validation is not authorization.
- Service classes must not bypass policies when called from multiple entry points.
- Bulk operations must authorize every affected record or use a query constrained to authorized records.

## Jobs, Events, Listeners, Mail, And Notifications

- Queued jobs must not contain plaintext secrets in serialized properties.
- Jobs that mutate private resources should reload models through authorized scopes or verify ownership before acting.
- Events and broadcasts must not include private models or secret-bearing attributes unless explicitly authorized and redacted.
- Mail and notification payloads must not expose secrets in subject lines, preview text, provider metadata, or third-party templates.
- Failed job payloads and exception context must not contain secrets.

## Filesystem And Downloads

- Private files must use private disks.
- Downloads must go through authorized routes or short-lived signed URLs.
- User uploads must validate MIME type, extension, size, and intended storage disk.
- Public storage must not contain private exports, invoices, secrets, backups, logs, database dumps, or temporary files.

## Billing And Payments

- Billing routes require an explicit billing permission such as `billing.manage`.
- Webhooks must verify provider signatures.
- Billing provider IDs must be scoped to the current team/account.
- Raw billing provider payloads must not be exposed to normal users.
- Subscription changes, payment method updates, and invoice access must be audited.

## Admin And Support Access

- Admin routes must require admin authentication or an explicit admin permission.
- Support impersonation must be auditable, time-limited, and visible where appropriate.
- Admin actions must still avoid exposing plaintext secrets unless specifically required and logged.
- Privileged permission changes must be audited.

## Tests Required For Security-Sensitive Changes

Add or update tests for:

- unauthenticated users are redirected or rejected
- users cannot access another team/account/tenant resource
- users cannot update privileged fields through mass assignment or request payloads
- users without permission cannot access billing/admin routes
- valid users can access only their permitted resources
- policies deny unrelated users
- public routes expose only intended fields
- API resources do not include sensitive fields
- Livewire components do not expose secret values in public state
- webhooks reject invalid signatures
- private files cannot be downloaded by unauthorized users
- secrets are not logged, queued, broadcast, notified, or rendered

## AI Agent Instructions

Before changing Laravel security-sensitive code:

1. Read this file.
2. Identify touched routes, controllers, requests, policies, models, resources, Livewire components, jobs, events, notifications, config, and tests.
3. Check route middleware.
4. Check policy, gate, or form request authorization.
5. Check tenant/team/account scoping.
6. Check route model binding cannot bypass scope.
7. Check mass assignment and sensitive model serialization.
8. Check API resources and Livewire public properties.
9. Check logs, queues, events, notifications, broadcasts, and failed jobs for secret exposure.
10. Check hard-coded ENV values or credentials.
11. Add or update tests for the security behavior.
12. Return this structured output:

```md
## Laravel Security Audit Output

| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Route middleware correct | Pass/Fail/Unknown | Route file, middleware, route:list, or test | Action or none |
| Public routes reviewed | Pass/Fail/Unknown | Public route list and exposed data | Action or none |
| Policy/gate/form request authorization | Pass/Fail/Unknown | Policy, gate, request, middleware, or controller line | Action or none |
| Missing model policies checked | Pass/Fail/Unknown | Models compared against policies | Action or none |
| Team/account/tenant scoping | Pass/Fail/Unknown | Query, scope, policy, or test | Action or none |
| Route model binding safe | Pass/Fail/Unknown | Binding, scoped binding, policy, or explicit check | Action or none |
| Mass assignment safe | Pass/Fail/Unknown | fillable/guarded and request validation | Action or none |
| Sensitive serialization safe | Pass/Fail/Unknown | hidden fields, resources, Livewire properties | Action or none |
| Secret exposure checked | Pass/Fail/Unknown | Logs, jobs, events, notifications, browser payloads | Action or none |
| Hard-coded ENV/credentials checked | Pass/Fail/Unknown | Files searched and findings | Action or none |
| Tests added or updated | Pass/Fail/Unknown | Test files and cases | Action or none |

### Failed Checks

- List each failed check with the exact file and required fix.

### Unknowns

- List anything that could not be verified.

### Residual Risk

- List remaining security risk after the change.
```

