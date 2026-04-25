# Scout Security

Use when the app uses Laravel Scout with Algolia, Meilisearch, Typesense, database driver, or custom engines.

## Check

- `toSearchableArray()` excludes secrets, private notes, provider payloads, billing data, hidden fields, internal permission data, and private file metadata.
- Search indexes do not include records users should not discover.
- Tenant/team/account scope is enforced after search results return.
- Soft-deleted, archived, draft, private, or disabled records are excluded unless intentionally searchable.
- Search filters cannot be tampered with to cross tenant/account/team boundaries.
- Queue payloads for indexing do not contain plaintext secrets.
- External search provider credentials are not exposed to frontend code unless intended for public search-only keys.
- Public search keys are restricted by index, filter, or rules where supported.

## Fail If

- Authorization is assumed because a search filter was sent from the browser.
- Sensitive fields are indexed into a third-party provider.
- Search returns private records before server-side filtering and authorization.
- Scout indexes are shared across tenants without enforced tenant filtering.

## Tests

- Search cannot return another team/account/tenant record.
- Sensitive fields are absent from `toSearchableArray()`.
- Private or soft-deleted records are not searchable unless allowed.

