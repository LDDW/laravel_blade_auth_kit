<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;

uses(RefreshDatabase::class);

it('shows passkey sign-in on the login page when passkeys are enabled', function () {
    if (! Features::canManagePasskeys()) {
        $this->markTestSkipped('Passkeys feature is disabled.');
    }

    $this->get(route('login'))
        ->assertOk()
        ->assertSee(__('Sign in with passkey'), false)
        ->assertSee('autocomplete="username webauthn"', false);
});

it('shows passkey management on the profile page', function () {
    if (! Features::canManagePasskeys()) {
        $this->markTestSkipped('Passkeys feature is disabled.');
    }

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.show'))
        ->assertOk()
        ->assertSee(__('Passkeys'), false)
        ->assertSee(__('Add Passkey'), false)
        ->assertSee(__('You have not registered any passkeys yet.'), false);
});

it('redirects passkey confirm-access through password confirmation', function () {
    if (! Features::canManagePasskeys()) {
        $this->markTestSkipped('Passkeys feature is disabled.');
    }

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('passkeys.confirm-access'))
        ->assertRedirect(route('password.confirm'));
});
