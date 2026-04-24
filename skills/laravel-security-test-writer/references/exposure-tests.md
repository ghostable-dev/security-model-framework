# Exposure Tests

Use these patterns to prove sensitive data does not leave the server.

## API Resource Field Absence

```php
it('does not expose deploy token secrets', function () {
    $token = DeployToken::factory()->create();

    $this->actingAs($token->team->owner)
        ->getJson(route('api.deploy-tokens.show', $token))
        ->assertOk()
        ->assertJsonMissingPath('data.token')
        ->assertJsonMissingPath('data.secret')
        ->assertJsonMissingPath('data.token_hash');
});
```

## Livewire Public State

```php
Livewire::test(EditEnvironmentVariable::class, ['variable' => $variable])
    ->assertSet('key', $variable->key)
    ->assertDontSee($plaintextSecret);
```

## File Access

```php
it('prevents unrelated users from downloading private files', function () {
    $file = PrivateExport::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('exports.download', $file))
        ->assertForbidden();
});
```

## Rules

- Assert missing sensitive paths, not only status codes.
- Include secret-looking values in fixtures so accidental exposure is detectable.
- Check Livewire rendered output and public state when possible.
- For logs or queues, prefer fakes and explicit payload assertions.

