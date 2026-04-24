# Laravel SaaS Security Model

This example shows a compact `SECURITY_MODEL.md` for a Laravel SaaS application.

## Authentication

- Users authenticate with Laravel Fortify.
- Admins use a separate `admin` guard.
- API requests use Laravel Sanctum.
- Password confirmation is required before MFA, email, password, and billing changes.

## Authorization

- All project resources must be scoped to the current team.
- Users may never access projects outside their team.
- Billing routes require `billing.manage`.
- Admin routes require the `admin` guard or an explicit admin permission.
- Policies are required for sensitive Eloquent models.

## Sensitive Models

| Model | Sensitive Fields | Required Controls |
| --- | --- | --- |
| User | password, remember_token, email | Hidden fields and policy checks |
| Team | owner_id, billing metadata | Membership and billing permission checks |
| Environment | team_id, provider metadata | Team-scoped policy |
| EnvironmentVariable | key, encrypted value | Encrypt at rest, never expose plaintext |
| DeployToken | token hash, abilities | One-time reveal, revoke support |
| TeamPermissionOverride | permission grants | Admin-only, audited changes |

## Route Expectations

| Route Pattern | Required Protection |
| --- | --- |
| `/dashboard/*` | `auth` and team scope |
| `/admin/*` | `auth:admin` or admin permission |
| `/api/*` | `auth:sanctum`, token abilities, object authorization |
| `/billing/*` | `auth` and `billing.manage` |
| `/webhooks/*` | Provider signature verification |

## Livewire Rules

- Treat public properties as browser-visible.
- Never store plaintext secrets, decrypted environment values, API tokens, or private keys in public Livewire properties.
- Authorize Livewire actions the same way controller actions are authorized.
- Re-check team ownership before mutating records.

## Critical Rules

- Never expose plaintext secrets in logs, queues, events, notifications, exceptions, failed jobs, broadcasts, API resources, or Livewire state.
- Environment variables must only be decrypted in the smallest possible scope.
- Deploy tokens are read-only after creation and must not be recoverable as plaintext.
- Personal teams cannot be shared, renamed, or deleted unless explicitly allowed by product rules.
- Route model binding must not bypass team scoping.
- Form request `authorize()` must not return `true` for sensitive actions unless another authorization check is proven.

## Required Tests

- Unauthenticated users are redirected or rejected.
- Users cannot access another team's resources.
- Users without billing permissions cannot access billing routes.
- Non-admin users cannot access admin routes.
- Policies deny unrelated users.
- API resources do not include sensitive fields.
- Livewire components do not expose secrets in public state.
- Webhooks reject invalid signatures.
- Queued jobs do not serialize plaintext secrets.

## AI Agent Instructions

Before changing controllers, policies, form requests, Livewire components, API resources, jobs, events, notifications, routes, config, or storage:

1. Check route middleware.
2. Check policy, gate, or form request authorization.
3. Check team scoping and route model binding.
4. Check mass assignment and sensitive model serialization.
5. Check API resources and Livewire public properties.
6. Check logs, queues, events, notifications, broadcasts, and failed jobs for secret exposure.
7. Check hard-coded ENV values or credentials.
8. Add or update tests for authorization behavior.
9. Return pass/fail/unknown audit output with evidence.

