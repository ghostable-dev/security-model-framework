# Tests And Output

Security-sensitive Laravel changes need tests that prove both denial and allowed behavior.

## Test Areas

- unauthenticated users are redirected or rejected
- unrelated users cannot access another team/account/tenant resource
- users cannot update privileged fields through request payloads
- users without permission cannot access admin or billing routes
- valid users can access only their permitted resources
- public routes expose only intended data
- API resources do not include sensitive fields
- Livewire components do not expose secret values in public state
- webhooks reject invalid signatures
- private files cannot be downloaded by unauthorized users
- queued jobs do not serialize plaintext secrets

## Useful Commands

```bash
php artisan test
php artisan test --filter=Authorization
php artisan test --filter=Policy
php artisan test --filter=Livewire
php artisan route:list
```

## Output Rules

- Evidence must include file paths, tests, command output summaries, or exact code mechanisms.
- `Unknown` is better than pretending a check passed.
- Any `Fail` must have a concrete required action.
- Residual risk should include only real remaining risk, not generic warnings.

