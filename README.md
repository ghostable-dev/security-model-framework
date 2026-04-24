# Security Model Framework

A `SECURITY_MODEL.md` convention for documenting application security rules and guiding AI-assisted code review.

Most `SECURITY.md` files explain how to report vulnerabilities. This project keeps that purpose intact and adds a separate application security model file for the rules engineers and AI coding agents need while changing code.

## Why This Exists

AI coding agents are increasingly able to change controllers, policies, routes, API resources, Livewire components, jobs, events, config, and tests. They need more than general secure coding advice. They need project-specific security expectations they can read before making changes and verify after making changes.

`SECURITY_MODEL.md` documents:

- how users authenticate
- how authorization is enforced
- which routes are public
- which models and fields are sensitive
- how tenant, team, account, or organization scoping works
- where secrets must never appear
- which tests are required for security-sensitive changes
- what structured audit output an AI agent must return

## File Convention

Use both files when possible:

- `SECURITY.md`: vulnerability reporting, disclosure policy, supported versions, and contact information.
- `SECURITY_MODEL.md`: authentication, authorization, sensitive data, public routes, secret handling, test expectations, and AI agent audit instructions.

## What's Included

- [templates/SECURITY_MODEL.generic.md](templates/SECURITY_MODEL.generic.md): baseline framework for any web application.
- [templates/SECURITY_MODEL.laravel.md](templates/SECURITY_MODEL.laravel.md): Laravel-focused version covering guards, Sanctum, Fortify, policies, gates, Livewire, queues, jobs, logs, storage, config, and environment handling.
- [templates/SECURITY.github-policy.md](templates/SECURITY.github-policy.md): small GitHub-compatible vulnerability reporting policy that links to `SECURITY_MODEL.md`.
- [guides/agent-security-audit.md](guides/agent-security-audit.md): structured audit instructions that force an agent to report what it checked, what passed, what failed, and what remains unknown.
- [examples/generic-web-app/SECURITY_MODEL.md](examples/generic-web-app/SECURITY_MODEL.md): compact example for a generic web app.
- [examples/laravel-saas/SECURITY_MODEL.md](examples/laravel-saas/SECURITY_MODEL.md): compact example for a Laravel SaaS app.

## Quick Start

Copy the closest template into your project root:

```bash
cp templates/SECURITY_MODEL.generic.md ./SECURITY_MODEL.md
```

For Laravel apps:

```bash
cp templates/SECURITY_MODEL.laravel.md ./SECURITY_MODEL.md
```

If you do not already have a GitHub security policy:

```bash
cp templates/SECURITY.github-policy.md ./SECURITY.md
```

Then customize the model for your real application.

## Agent Audit Output

The templates require agents to return structured security audit output:

```md
| Check | Status | Evidence | Required Action |
| --- | --- | --- | --- |
| Authentication required | Pass/Fail/Unknown | File, route, test, or reasoning | Action or none |
| Authorization enforced | Pass/Fail/Unknown | File, policy, middleware, or test | Action or none |
| Sensitive data exposure | Pass/Fail/Unknown | Fields, serializers, resources checked | Action or none |
```

The rule is simple: do not mark a check as `Pass` unless it was verified directly.

## Laravel Focus

The Laravel template adds checks for:

- route middleware and public routes
- guards, Sanctum, Fortify, and session behavior
- policies, gates, form requests, and missing model policies
- route model binding and tenant/team/account scoping
- Eloquent serialization, hidden fields, casts, and mass assignment
- API resources and Livewire public properties
- queues, events, listeners, mail, notifications, broadcasts, and failed jobs
- hard-coded credentials and unsafe environment defaults
- billing, admin, support, storage, and webhook behavior

## License

MIT
