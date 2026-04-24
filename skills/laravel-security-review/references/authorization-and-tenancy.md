# Authorization And Tenancy

Authorization must be server-side and object-level.

## Files To Check

- `app/Policies`
- `app/Providers/AuthServiceProvider.php`
- Laravel 11+ provider registrations
- `app/Http/Controllers`
- `app/Http/Requests`
- `app/Models`
- `app/Services`
- `routes/*.php`
- tests covering authorization behavior

## Checks

- Sensitive models have policies or documented equivalent checks.
- Controllers call `$this->authorize(...)`, `Gate::authorize(...)`, policy methods, `can` middleware, or form requests with meaningful `authorize()`.
- Form request `authorize()` does not return `true` for sensitive actions unless another explicit authorization check is proven.
- Index, show, update, delete, export, search, autocomplete, and bulk operations are scoped consistently.
- Admin bypass behavior is explicit and tested.
- Billing, support, impersonation, and permission changes are explicitly authorized.

## Tenancy Checks

Look for the app's tenant concept:

- `team_id`
- `account_id`
- `organization_id`
- `tenant_id`
- membership tables
- current team/account helpers
- global scopes
- scoped route bindings

Every private query must be constrained to the authorized tenant/account/team unless the security model explicitly says otherwise.

## Route Model Binding

Route model binding is not authorization by itself.

Pass only if one is true:

- scoped bindings constrain by parent tenant/account/team
- policy check runs before private data is returned or mutated
- query is manually constrained to the current authorized scope
- binding uses a custom resolver that enforces scope

## Missing Policy Heuristic

Compare `app/Models` to `app/Policies`. Any sensitive model without a policy is a `Fail` unless another explicit authorization mechanism is documented with evidence.

