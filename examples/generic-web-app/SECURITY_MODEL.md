# Security Model

This example shows a compact `SECURITY_MODEL.md` for a generic web application.

## Authentication

- Users authenticate with email and password.
- Sessions are stored server-side.
- API clients authenticate with scoped API tokens.
- Password reset and login routes are throttled.

## Authorization

- Deny by default.
- Users may only access resources they own or resources shared with their account.
- Admin users require an explicit `admin` permission.
- Billing routes require `billing.manage`.

## Public Routes

| Route | Method | Purpose | Allowed Data Exposure |
| --- | --- | --- | --- |
| `/` | GET | Marketing page | Public content only |
| `/login` | GET/POST | Login | No private data |
| `/password/reset` | GET/POST | Password reset | No account enumeration |
| `/webhooks/payment` | POST | Payment provider webhook | Signature verified |

## Protected Route Expectations

| Route Pattern | Required Protection |
| --- | --- |
| `/app/*` | Authenticated user |
| `/api/*` | API token plus object authorization |
| `/admin/*` | Admin permission |
| `/billing/*` | Billing permission |

## Sensitive Data

- Password hashes
- API tokens
- Webhook secrets
- Payment provider IDs
- Private uploaded files
- Account membership records

## Critical Rules

- Never expose plaintext secrets in logs, queues, events, exceptions, analytics, or browser payloads.
- API responses must include only fields needed by the caller.
- Public routes must not leak private IDs, stack traces, account metadata, or internal state.
- File downloads must authorize the current user before returning content.
- Background jobs must not serialize plaintext secrets.

## Required Tests

- Unauthenticated users cannot access protected routes.
- Users cannot access another account's resources.
- Users without billing permissions cannot access billing routes.
- Admin routes reject non-admin users.
- Public routes expose only intended data.
- API responses do not include sensitive fields.
- Webhooks reject invalid signatures.

## AI Agent Instructions

Before changing routes, controllers, API serializers, jobs, events, notifications, or file handling:

1. Check authentication requirements.
2. Check object-level authorization.
3. Check account scoping.
4. Check sensitive fields are not returned.
5. Check secrets are not logged, queued, broadcast, or rendered.
6. Add or update authorization tests.
7. Return pass/fail/unknown audit output with evidence.

