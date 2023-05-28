<?php

use App\Models\User;
use App\Models\Server;
use function Pest\Laravel\{actingAs, get, post, delete, assertDatabaseHas, assertDatabaseMissing};
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('can be created', function () {
    post('/servers', [
        'name' => 'new server',
    ])
    ->assertRedirect();

    assertDatabaseHas(Server::class, [
        'name' => 'new server',
    ]);
});

it('can be viewed', function () {
    $server = Server::factory()
        ->hasAttached(User::factory()->count(3))
        ->create();

    get('/servers/'.$server->id)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Servers/Show')
            ->has('server', fn (Assert $page) => $page
                ->where('name', $server->name)
                ->has('users', 3)
            )
        );
});

it('can be deleted', function () {
    $server = Server::factory()->create();

    delete('/servers/'.$server->id)
        ->assertRedirect('/');

    assertDatabaseMissing(Server::class, [
        'id' => $server->id,
    ]);
});