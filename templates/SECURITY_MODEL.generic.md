# Security Model

This file defines the expected security behavior of the application. It is not only a vulnerability reporting policy. It is a working security contract for engineers, reviewers, and AI coding agents.

When changing authentication, authorization, routing, data access, file handling, jobs, logging, API responses, browser payloads, or sensitive models, this file must be checked first.

## Application Security Summary

Describe the application in security terms.

- Application type:
- Primary users:
- Privileged users:
- Authentication method:
- Authorization model:
- Tenant/account/team model:
- API access model:
- Billing or subscription model:
- Sensitive data classes:
- External services:

## Authentication

Document how users and systems prove identity.

- Primary users authenticate with:
- Admin users authenticate with:
- API clients authenticate with:
- Service-to-service requests authenticate with:
- Session lifetime:
- Password reset flow:
- MFA requirements:
- Account recovery rules:

### Authentication Rules

- Anonymous users may only access routes explicitly listed as public.
- Authenticated sessions must be tied to a single user identity.
- Privileged areas must require a stronger or separate authorization check than normal user areas.
- API tokens must be revocable, scoped, and stored hashed when possible.
- Passwords, recovery tokens, remember tokens, API tokens, and session secrets must never be logged or returned.

## Authorization

Document how access decisions are made.

- Authorization system:
- Default access rule:
- Resource ownership rule:
- Tenant/team/account scoping rule:
- Admin override rule:
- Billing permission rule:
- Support or impersonation rule:

### Authorization Rules

- Deny by default.
- Every private resource must have an owner, tenant, account, organization, or explicit access grant.
- Users may never access resources outside their authorized scope.
- Privileged actions require explicit permission checks.
- UI hiding is not authorization. Server-side checks are required.
- API filtering is not authorization. Object-level checks are required.

## Public Routes

List every route that may be accessed without authentication.

| Route | Method | Purpose | Allowed Data Exposure |
| --- | --- | --- | --- |
| `/` | GET | Public landing page | Public marketing content only |

### Public Route Rules

- Public routes must not expose private IDs, secrets, internal state, stack traces, account metadata, or user-specific data.
- Public forms must be protected against abuse with validation, throttling, spam controls, or equivalent safeguards.
- Public webhooks must verify signatures or shared secrets.

## Protected Route Expectations

Define route-level security expectations.

| Route Pattern | Required Protection | Notes |
| --- | --- | --- |
| `/app/*` | Authenticated user | Must scope all data to current user or account |
| `/admin/*` | Admin permission | Must not rely on UI visibility only |
| `/api/*` | API authentication | Must enforce object-level authorization |
| `/billing/*` | Billing permission | Must verify account ownership or billing role |

## Sensitive Models And Data

List models, tables, documents, or objects that require special handling.

| Model/Data | Why Sensitive | Required Protection |
| --- | --- | --- |
| User | Identity and account access | Owner/admin access only |
| API Token | Credential material | Hash at rest, never display after creation |
| Secret | Secret value | Encrypt at rest, never log or expose |

## Secret Handling

Secrets include passwords, API keys, tokens, private keys, webhook secrets, recovery tokens, session identifiers, OAuth credentials, encrypted environment values, and provider credentials.

### Critical Rules

- Never expose plaintext secrets in logs, queues, events, notifications, exceptions, telemetry, analytics, browser payloads, source maps, local storage, session storage, URLs, or API responses.
- Never hard-code production secrets in source code, tests, documentation examples, seeders, fixtures, containers, or CI files.
- Secrets must be encrypted or hashed at rest according to whether they need to be recovered.
- One-time reveal flows must not make the secret retrievable later.
- Redaction must happen before data reaches logs, error reporters, or analytics tools.

## Data Exposure Rules

- API responses must return only the fields needed by the caller.
- Browser payloads must not include hidden sensitive fields.
- Internal IDs must not grant access by themselves.
- Error responses must not reveal stack traces, queries, environment values, file paths, provider secrets, or internal authorization logic.
- Pagination, search, exports, and autocomplete must use the same authorization rules as normal detail views.

## File And Storage Rules

- Private files must not be stored in public buckets or public web roots.
- Download routes must authorize access before returning files.
- Temporary signed URLs must expire and be scoped to the intended file.
- Uploads must validate file type, size, and storage location.
- User-uploaded files must not be executed as code.

## Background Jobs, Events, And Notifications

- Jobs must receive IDs or minimal payloads instead of full sensitive objects when possible.
- Jobs must re-check authorization or ownership if acting on behalf of a user.
- Queued payloads must not contain plaintext secrets.
- Events and broadcasts must not leak private model data.
- Notifications must avoid exposing secrets or private data in subject lines, previews, push payloads, or third-party templates.

## Logging, Monitoring, And Exceptions

- Logs must redact credentials, tokens, secrets, payment data, private keys, and sensitive request fields.
- Exceptions must not expose sensitive context to users.
- Debug mode must be disabled in production.
- Security-relevant events should be auditable: login failures, password resets, MFA changes, token creation, permission changes, billing changes, admin actions, exports, and destructive actions.

## Configuration And Environment

- Production configuration must not depend on local defaults.
- Debug tooling must not be exposed in production.
- CORS must allow only intended origins.
- Cookie security settings must match the deployment environment.
- Rate limits must protect login, password reset, public forms, token creation, and expensive API endpoints.
- CI must not print secrets.

## Third-Party Integrations

For each external service, document:

| Service | Data Shared | Auth Method | Webhook Verification | Failure Mode |
| --- | --- | --- | --- | --- |

Rules:

- Send the minimum data required.
- Verify inbound webhooks.
- Store provider credentials securely.
- Treat third-party callbacks as untrusted input.

## Testing Requirements

Security-sensitive changes must include or update tests for:

- Authentication required.
- Authorization denied for unrelated users, tenants, accounts, or teams.
- Authorization allowed for valid actors.
- Privileged actions denied without explicit permission.
- Public routes expose only intended data.
- Sensitive fields are not returned by APIs or browser payloads.
- Secrets are not logged, queued, broadcast, or rendered.
- File access is denied to unauthorized users.
- Webhooks reject invalid signatures.
- Rate limits apply to abuse-prone routes.

## AI Agent Instructions

Before changing controllers, route handlers, middleware, policies, permissions, API resources, serializers, background jobs, events, notifications, file handling, authentication flows, or billing code:

1. Read this file.
2. Identify the affected security areas.
3. Check ownership and tenant/account/team scoping.
4. Check route protection.
5. Check object-level authorization.
6. Check public data exposure.
7. Check secret handling.
8. Check logs, jobs, events, notifications, and browser payloads.
9. Add or update tests for authorization and exposure behavior.
10. Return structured audit output using this format:

```md
## Security Audit Output

| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Authentication required | Pass/Fail/Unknown | File, route, test, or reasoning | Action or none |
| Authorization enforced | Pass/Fail/Unknown | File, policy, middleware, or test | Action or none |
| Tenant/account scoping | Pass/Fail/Unknown | Query, scope, policy, or test | Action or none |
| Public route exposure | Pass/Fail/Unknown | Route and response fields checked | Action or none |
| Sensitive data exposure | Pass/Fail/Unknown | Fields, serializers, resources checked | Action or none |
| Secret handling | Pass/Fail/Unknown | Logs, jobs, events, browser payloads checked | Action or none |
| Tests updated | Pass/Fail/Unknown | Test files or missing coverage | Action or none |

### Residual Risk

- List anything not fully verified.
```

