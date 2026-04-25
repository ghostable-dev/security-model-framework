# Filament Security

Use when the app uses Filament panels, resources, pages, widgets, relation managers, actions, or exports.

## Check

- Panel access is restricted with `canAccessPanel`, middleware, policy, or documented equivalent.
- Filament resources respect model policies.
- Relation managers enforce authorization for related records.
- Table queries are scoped to the current tenant/team/account.
- Bulk actions authorize every affected record or constrain the query to authorized records.
- Export actions apply the same authorization and field filtering as normal views.
- Hidden, disabled, or concealed form fields are not treated as authorization.
- File uploads use intended disks and visibility.
- Global search does not reveal private records.
- Widgets and metrics scope data to the authorized tenant/team/account.

## Fail If

- Panel access is open to any authenticated user when admin access is expected.
- A resource query is unscoped in a multi-tenant app.
- Bulk actions mutate records without policy checks.
- Exports include sensitive hidden fields.

## Tests

- Non-admin users cannot access restricted panels.
- Users cannot see another tenant/team/account resource in tables or global search.
- Bulk actions reject unauthorized records.
- Export output omits sensitive fields.

