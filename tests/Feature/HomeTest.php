<?php

use App\Models\User;
use function Pest\Laravel\{actingAs, get};
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('can be viewed', function () {
    get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Home')
        );
});
