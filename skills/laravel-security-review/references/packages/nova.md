# Nova Security

Use when the app uses Laravel Nova resources, tools, lenses, cards, actions, filters, or metrics.

## Check

- Nova access is restricted through `Nova::auth`, gates, middleware, or equivalent.
- Resources map to policies for view, create, update, delete, restore, forceDelete, replicate, and attach/detach behavior.
- Index queries are scoped to the current tenant/team/account.
- Lenses, filters, metrics, cards, and tools do not bypass resource policies.
- Actions authorize every selected model.
- Fields marked hidden, readonly, or onlyOnForms are not treated as authorization.
- Sensitive fields are not displayed, searchable, filterable, exportable, or included in action payloads.
- Impersonation or support tools are auditable and permission-gated.

## Fail If

- Nova is accessible to normal authenticated users unexpectedly.
- Resource index/detail queries expose cross-tenant records.
- Actions run on unauthorized selected records.
- Sensitive fields are hidden from the UI but still serialized or searchable.

## Tests

- Unauthorized users cannot access Nova.
- Resource policies deny unrelated users.
- Lenses and metrics are tenant-scoped.
- Actions cannot mutate unauthorized records.

