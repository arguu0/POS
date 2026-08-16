<?php

use App\Models\Store;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();

    $store = Store::factory()->create([
        'user_id' => $user->id,
    ]);

    $user->refresh();

    dump([
        'user_id' => $user->id,
        'store_id' => $store->id,
        'store_user_id' => $store->user_id,
        'relationship_store_id' => $user->store?->id,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
});