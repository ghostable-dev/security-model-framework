# Passport Security

Use when the app uses Laravel Passport OAuth clients, access tokens, refresh tokens, or scopes.

## Check

- OAuth clients and client secrets are protected and not exposed in browser payloads.
- Password grant usage is intentional; prefer more constrained flows where possible.
- Access token scopes are checked for privileged API routes.
- Object-level authorization runs after OAuth authentication.
- Refresh tokens can be revoked and expire appropriately.
- Personal access clients are restricted to intended use.
- Token pruning is configured where appropriate.
- Client creation, secret rotation, and revocation are authorized and audited.
- Tokens, refresh tokens, authorization codes, and client secrets are not logged or queued.

## Fail If

- OAuth scope checks replace object-level authorization.
- Client secrets are committed, rendered, logged, or exposed to normal users.
- Password grant is enabled without documented product need.
- Refresh tokens remain valid after revocation or credential reset.

## Tests

- Missing or insufficient scopes are rejected.
- Valid token cannot access another team/account/tenant resource.
- Revoked token is rejected.
- Client management routes require explicit permission.

