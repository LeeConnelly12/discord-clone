<?php

use App\Models\User;
use App\Models\Server;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{actingAs, get, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

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

it('can be created with an image', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('image.jpg');

    post('/servers', [
        'name' => 'new server',
        'image' => $image,
    ])
    ->assertRedirect();

    assertDatabaseHas(Server::class, [
        'name' => 'new server',
    ]);

    Storage::assertExists('1/'.$image->name);
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
                ->where('image_thumbnail', $server->getFirstMediaUrl('image', 'thumb'))
                ->has('users', 3)
            )
        );
});

it('can be updated', function () {
    $server = Server::factory()->create([
        'name' => 'old server name',
    ]);

    put('/servers/'.$server->id, [
        'name' => 'new server name',
    ])
    ->assertRedirect();

    assertDatabaseHas(Server::class, [
        'name' => 'new server name',
    ]);
});

it('can be updated with an image', function () {
    Storage::fake();

    $server = Server::factory()->create();
    $image = UploadedFile::fake()->image('new-image.jpg');

    put('/servers/'.$server->id, [
        'name' => 'new server name',
        'image' => $image,
    ])
    ->assertRedirect();

    assertDatabaseHas(Server::class, [
        'name' => 'new server name',
    ]);

    Storage::assertExists('2/'.$image->name);
});

it('can be deleted', function () {
    $server = Server::factory()->create();

    delete('/servers/'.$server->id)
        ->assertRedirect('/');

    assertDatabaseMissing(Server::class, [
        'id' => $server->id,
    ]);
});
