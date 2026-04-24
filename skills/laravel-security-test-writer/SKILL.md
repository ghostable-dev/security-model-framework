---
name: laravel-security-test-writer
description: Use when adding Laravel Pest or PHPUnit tests for authentication, authorization, policies, gates, team/account/tenant scoping, route protection, Livewire public state, API resource exposure, webhooks, file downloads, billing/admin permissions, or secret leakage regressions.
metadata:
  short-description: Write Laravel security regression tests
---

# Laravel Security Test Writer

Use this skill to add fast, focused tests for Laravel security behavior.

## Workflow

1. Read `SECURITY_MODEL.md`.
2. Identify the smallest security promise affected by the change.
3. Write denial tests first, then allowed behavior.
4. Use factories and acting users that make ownership boundaries obvious.
5. Prefer feature tests for routes and Livewire tests for components.
6. Keep each test assertion tied to one security rule.

## Test Patterns

Read only what you need:

- Authorization and tenancy tests: `references/authorization-tests.md`
- Exposure and secret tests: `references/exposure-tests.md`

## Required Coverage For Sensitive Changes

- unauthenticated user rejected
- unrelated user denied
- user without permission denied
- authorized user allowed
- cross-team/account/tenant access denied
- sensitive fields absent from response or component state
- invalid webhook signature rejected
- private file denied to unauthorized user

## Output

When done, report:

- test file paths
- security rules covered
- command run
- failures or untested residual risk

