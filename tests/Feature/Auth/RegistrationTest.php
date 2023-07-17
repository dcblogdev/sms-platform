<?php

use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;

test('can see register page', function () {
    $this->get(route('register'))->assertOk();
});

test('users cannot register with invalid password', function () {
    $this->post(route('register'), [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => '',
    ]);

    $this->assertGuest();
});

test('users cannot register with existing email', function () {
    $user = User::factory()->create();
    $password = 'ght73A3!$^DS';

    $this->post(route('register'), [
        'name' => fake()->name(),
        'email' => $user->email,
        'password' => $password,
        'confirmPassword' => $password,
    ])->assertInvalid();

    $this->assertGuest();
});

test('users cannot register without matching password', function () {
    $user = User::factory()->create();
    $password = 'ght73A3!$^DS';

    $this->post(route('register'), [
        'name' => fake()->name(),
        'email' => $user->email,
        'password' => $password,
        'confirmPassword' => 'other',
    ])->assertInvalid();

    $this->assertGuest();
});

test('users can register', function () {

    $password = 'ght73A3!$^DS';
    $email = fake()->email();

    $this
        ->post(route('register'), [
            'name' => fake()->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])
        ->assertValid()
        ->assertRedirect(RouteServiceProvider::HOME);

    $user = User::where('email', $email)->first();
    $tenant = Tenant::where('owner_id', $user->id)->first();

    $this->assertDatabaseHas('tenants', ['owner_id' => $user->id]);
    $this->assertDatabaseHas('tenant_users', [
        'tenant_id' => $tenant->id,
        'user_id' => $user->id,
    ]);
    $this->assertDatabaseHas('users', ['tenant_id' => $tenant->id]);

    expect($tenant->owner_id)->toBe($user->id);
    expect($tenant->owner->id)->toBe($user->id);
});
