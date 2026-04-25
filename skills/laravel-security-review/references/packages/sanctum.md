# Sanctum Security

Use when the app uses Laravel Sanctum for API tokens or SPA authentication.

## Check

- API routes requiring identity use `auth:sanctum` or documented equivalent middleware.
- Token abilities are checked for privileged API actions.
- Object-level authorization still runs after token authentication.
- Personal access tokens are hashed at rest.
- Plaintext tokens are shown only once.
- Token creation, revocation, and ability changes are authorized.
- SPA stateful domains and CORS config are restricted to intended origins.
- Cookies use secure production settings.
- CSRF behavior is correct for first-party SPA flows.
- Tokens are not logged, queued, broadcast, mailed, or returned after creation.

## Fail If

- API token auth is treated as sufficient authorization.
- Token abilities are broad by default for sensitive actions.
- Token strings appear in logs, exceptions, tests, docs, seeders, or frontend code.
- Revoked tokens can still be used.

## Tests

- Unauthenticated API request is rejected.
- Token without required ability is rejected.
- Token with ability still cannot access another team/account/tenant resource.
- Revoked token is rejected.

