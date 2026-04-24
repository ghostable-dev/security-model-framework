# Secrets And Side Effects

Check where sensitive values can leak outside the main request.

## Secrets

Secrets include:

- passwords
- API keys
- OAuth tokens
- Sanctum tokens
- webhook secrets
- private keys
- recovery codes
- deploy tokens
- encrypted environment values
- provider credentials

## Never Expose Secrets In

- logs
- exception context
- queued job payloads
- failed job payloads
- events
- broadcasts
- notifications
- mail subjects and previews
- analytics
- telemetry
- API responses
- Livewire state
- frontend hydration payloads
- URLs
- source maps

## Files To Check

- `config/*.php`
- `.env.example`
- `app/Jobs`
- `app/Events`
- `app/Listeners`
- `app/Notifications`
- `app/Mail`
- `app/Exceptions`
- `app/Logging`
- `app/Http/Middleware`
- `config/logging.php`
- `config/filesystems.php`
- `config/cors.php`
- CI files
- Docker files
- seeders, factories, tests, docs

## Hard-Coded Credential Patterns

Search for:

```txt
password=
api_key
apikey
secret
token
private_key
client_secret
access_key
APP_DEBUG=true
```

Flag real-looking secrets. Ignore documented placeholders only when clearly non-sensitive.

## Files And Storage

- Private files must use private disks.
- Public disks must not contain private exports, logs, backups, invoices, secrets, or temporary sensitive files.
- Downloads must authorize access before returning content.
- Signed URLs must be short-lived and scoped.

