# Agent Security Audit Guide

Use this guide when asking an AI coding agent to modify or review a web application that has a `SECURITY_MODEL.md` security model.

## Recommended Prompt

```md
Before making changes, read `SECURITY_MODEL.md` and identify every affected security boundary. If the project also has `SECURITY.md`, treat it as the vulnerability reporting policy unless it explicitly contains application security rules.

After making changes, return structured security audit output. For each check, mark `Pass`, `Fail`, or `Unknown`. Include concrete evidence such as files, routes, policies, middleware, tests, resources, serializers, Livewire components, jobs, events, notifications, config files, or commands checked.

Do not mark a check as `Pass` unless you verified it directly.
Do not hide uncertainty. If something cannot be verified, mark it `Unknown` and explain what would be needed.
Any `Fail` must include a required action.
```

## Required Output

```md
## Security Audit Output

| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Authentication required | Pass/Fail/Unknown |  |  |
| Route protection correct | Pass/Fail/Unknown |  |  |
| Public routes reviewed | Pass/Fail/Unknown |  |  |
| Object-level authorization | Pass/Fail/Unknown |  |  |
| Missing model policies checked | Pass/Fail/Unknown |  |  |
| Tenant/account/team scoping | Pass/Fail/Unknown |  |  |
| Sensitive serialization safe | Pass/Fail/Unknown |  |  |
| Secret exposure checked | Pass/Fail/Unknown |  |  |
| Logs/queues/events safe | Pass/Fail/Unknown |  |  |
| Hard-coded credentials checked | Pass/Fail/Unknown |  |  |
| Tests added or updated | Pass/Fail/Unknown |  |  |

### Failed Checks

- 

### Unknowns

- 

### Residual Risk

- 
```

## Review Areas

### Public Surface

- Public routes
- Guest-only routes
- Webhooks
- Health checks
- Static files
- Public storage
- Public API endpoints
- Password reset and invitation flows

### Identity And Access

- Authentication middleware
- Guards
- Sessions
- API tokens
- MFA
- Password confirmation
- Admin access
- Support impersonation

### Authorization

- Policies
- Gates
- Middleware
- Form request `authorize()` methods
- Service-layer authorization
- Object-level authorization
- Bulk operation authorization
- Export/download authorization

### Data Scoping

- User-owned records
- Team-owned records
- Account-owned records
- Tenant-owned records
- Organization-owned records
- Admin bypass behavior
- Route model binding behavior
- Search and autocomplete behavior

### Sensitive Data

- Password hashes
- Remember tokens
- API tokens
- OAuth tokens
- Webhook secrets
- Private keys
- Environment variables
- Deploy tokens
- Payment metadata
- Provider raw payloads
- Recovery codes

### Exposure Paths

- API resources
- JSON responses
- Server-rendered pages
- Livewire public state
- Frontend hydration payloads
- Logs
- Exception context
- Queued jobs
- Failed jobs
- Events
- Broadcasts
- Notifications
- Mail templates
- Analytics
- Error reporting
- Source maps

## Pass/Fail Standard

Use strict statuses:

- `Pass`: verified directly with code, config, command output, or tests.
- `Fail`: verified a missing or unsafe behavior.
- `Unknown`: not enough evidence to prove pass or fail.

Never use `Pass` for assumptions.
