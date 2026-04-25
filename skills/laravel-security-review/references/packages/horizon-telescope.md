# Horizon And Telescope Security

Use when the app uses Laravel Horizon, Telescope, Pulse, Debugbar, or similar operational/debug tooling.

## Horizon

- Dashboard access is restricted in non-local environments.
- Queue payloads do not contain plaintext secrets.
- Failed job payloads and exception context are redacted.
- Job retry actions are restricted to privileged users.
- Metrics do not expose sensitive tenant or user data.

## Telescope

- Telescope is disabled or access-controlled in production.
- Entries do not expose passwords, tokens, authorization headers, cookies, private payloads, environment values, or provider secrets.
- Request and exception watchers are configured with appropriate redaction.
- Telescope data storage retention is limited.
- Access to Telescope is admin-only or environment-restricted.

## Fail If

- Horizon or Telescope is publicly accessible in production.
- Debug tooling exposes headers, cookies, tokens, request bodies, or exception context.
- Failed job payloads contain plaintext secrets.

## Tests / Evidence

- Check service provider gates.
- Check environment-based registration.
- Check config redaction options.
- Check production deploy config or documented production expectations.

