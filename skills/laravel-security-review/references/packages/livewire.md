# Livewire Security

Use when the app has `app/Livewire`, `app/Http/Livewire`, Livewire routes, or Livewire tests.

## Check

- Public properties contain no plaintext secrets, decrypted env values, API tokens, private keys, provider payloads, password hashes, or sensitive billing data.
- Every mutating action authorizes the current user.
- Actions re-check team/account/tenant ownership before reading or writing models.
- Component methods do not trust IDs, enum values, role names, team IDs, or permission flags sent from the browser.
- Validation runs server-side for all user-controlled input.
- File uploads validate type, size, visibility, and storage disk.
- Hydration/dehydration hooks do not expose sensitive computed state.
- Locked or computed properties are used appropriately, but not treated as authorization.
- Rendered views do not include hidden sensitive fields in Alpine, data attributes, inline scripts, or JSON blobs.

## Fail If

- A secret-bearing value is assigned to a public property.
- A Livewire action mutates a model without policy/gate/form request equivalent authorization.
- A component accepts a model ID and uses it without scoping to the current user/team/account.
- Private files uploaded through Livewire are stored on a public disk without explicit intent.

## Tests

- Use `Livewire::test(...)` for action authorization and state exposure.
- Assert unauthorized users receive forbidden responses or validation errors.
- Assert secret values are not visible in output or public state.

