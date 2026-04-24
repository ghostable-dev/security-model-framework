# Laravel SECURITY_MODEL.md Sections

Use these sections when generating a Laravel security model.

## Required Sections

- Application Security Summary
- Authentication
- Authorization
- Policies And Gates
- Route Expectations
- Public Routes
- Sensitive Models
- Eloquent Model Rules
- API Resources And Serialization
- Livewire Rules
- Secrets And Environment Values
- Config And ENV Checks
- Controllers, Form Requests, And Services
- Jobs, Events, Listeners, Mail, And Notifications
- Filesystem And Downloads
- Billing And Payments
- Admin And Support Access
- Tests Required For Security-Sensitive Changes
- AI Agent Instructions

## Good Tables

Route expectations:

```md
| Route Pattern | Expected Middleware | Additional Checks |
| --- | --- | --- |
| `/dashboard/*` | `auth` | Current team scoped |
```

Sensitive models:

```md
| Model | Sensitive Fields | Required Controls |
| --- | --- | --- |
| DeployToken | token hash, abilities | Hash at rest, one-time reveal |
```

Audit output:

```md
| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Team/account/tenant scoping | Pass/Fail/Unknown |  |  |
```

## Wording Standard

- Use "must" for rules agents must enforce.
- Use "should" only for preferred but non-blocking practices.
- Use "Unknown" for unverified behavior.
- Avoid vague phrases like "securely handled" unless the handling is specified.

