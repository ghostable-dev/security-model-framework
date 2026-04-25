# Spatie Permission Security

Use when the app uses `spatie/laravel-permission` for roles, permissions, teams, guards, or cached authorization data.

## Check

- Guard names are correct for web, admin, API, and other guards.
- Role and permission assignment routes require explicit privileged permission.
- Users cannot assign roles or permissions they do not already control.
- Team-scoped permissions are enabled and consistently set when the app is multi-tenant.
- Permission cache is reset after role or permission changes.
- Super-admin behavior is explicit, audited, and tested.
- Role names from request payloads are validated against allowed roles.
- Policies and gates do not assume a role name alone is enough for object-level authorization.
- Seeders and tests do not grant broad roles accidentally in production-like paths.

## Fail If

- A normal user can assign `admin`, `owner`, or privileged permissions.
- Guard mismatch causes permissions to pass or fail unexpectedly.
- Team-scoped permissions are used without setting the active team context.
- Role checks replace ownership or tenant scoping.

## Tests

- User without permission cannot assign roles.
- User cannot grant a permission they do not control.
- Guard-specific permission checks behave correctly.
- Team-scoped role does not apply to another team.

