<?php

use App\Models\Server;
use function Pest\Laravel\{get, post, delete, assertDatabaseHas, assertDatabaseMissing};
use Inertia\Testing\AssertableInertia as Assert;

it('can be listed', function () {
    $servers = Server::factory()->count(3)->create();

    get('/servers')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Servers/Index')
            ->has('servers', 3, fn (Assert $page) => $page
                ->where('name', $servers->first()->name)
            )
        );
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
    $server = Server::factory()->create();

    get('/servers/'.$server->id)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Servers/Show')
            ->has('server', 1)
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