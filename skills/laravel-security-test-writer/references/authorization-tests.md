# Authorization Tests

Use these patterns with Pest or PHPUnit, adapting to the app's conventions.

## Feature Test Shape

```php
it('prevents users from viewing another teams project', function () {
    $user = User::factory()->create();
    $otherTeam = Team::factory()->create();
    $project = Project::factory()->for($otherTeam)->create();

    $this->actingAs($user)
        ->get(route('projects.show', $project))
        ->assertForbidden();
});
```

## Permission Test Shape

```php
it('requires billing permission to manage billing', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $this->actingAs($user)
        ->get(route('billing.index', $team))
        ->assertForbidden();
});
```

## Policy Test Shape

```php
expect($user->can('update', $otherTeamsProject))->toBeFalse();
expect($owner->can('update', $ownedProject))->toBeTrue();
```

## Rules

- Test denial across ownership boundaries.
- Test permission absence, not only unauthenticated access.
- Use route names when the app uses route names.
- Assert `403` for authenticated unauthorized users.
- Assert redirect or `401` for unauthenticated users according to app behavior.

