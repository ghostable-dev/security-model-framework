# Data Exposure

Check every path where model data becomes output.

## Files To Check

- `app/Models`
- `app/Http/Resources`
- `app/Http/Controllers`
- `app/Livewire`
- `app/View/Components`
- `resources/views`
- `resources/js`
- broadcast events
- notification and mail classes

## Eloquent

- Sensitive fields must be hidden when they should never serialize.
- `$fillable` or `$guarded` must prevent privileged field assignment.
- Accessors must not decrypt or expose secrets during serialization.
- Casts such as encrypted casts reduce storage risk but do not make output safe.
- Avoid returning raw Eloquent models for sensitive resources.

High-risk fields:

- `password`
- `remember_token`
- `token`
- `api_key`
- `secret`
- `private_key`
- `recovery_codes`
- `provider_payload`
- `billing_*`
- `is_admin`
- `role`
- `permissions`
- `team_id`, `account_id`, `tenant_id` when they enable inference or tampering

## API Resources

- Resources should explicitly select fields.
- Do not include decrypted secret values, token hashes, password hashes, provider credentials, raw billing payloads, or internal permission override data.
- Conditional fields must be tied to authorization, not only route context.

## Livewire

- Treat public properties as browser-visible.
- Never store plaintext secrets, decrypted environment values, API tokens, private keys, or provider payloads in public properties.
- Validate all Livewire input server-side.
- Authorize every mutating action.
- Do not trust model IDs sent from the browser.

