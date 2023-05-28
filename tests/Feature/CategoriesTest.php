<?php

use App\Models\User;
use App\Models\Server;
use App\Models\Category;
use function Pest\Laravel\{actingAs, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);

    $this->server = Server::factory()
        ->for($this->user)
        ->create();
});

it('can be created', function () {
    post('/servers/'.$this->server->id.'/categories', [
        'name' => 'new category',
    ])
    ->assertRedirect();

    assertDatabaseHas(Category::class, [
        'server_id' => $this->server->id,
        'name' => 'new category',
    ]);
});

it('can be updated', function () {
    $category = Category::factory()
        ->for($this->server)
        ->create(['name' => 'old name']);

    put('/servers/'.$this->server->id.'/categories/'.$category->id, [
        'name' => 'new name',
    ])
    ->assertRedirect();

    assertDatabaseHas(Category::class, [
        'id' => $category->id,
        'name' => 'new name',
    ]);
});

it('can be deleted', function () {
    $category = Category::factory()
        ->for($this->server)
        ->create();

    delete('/servers/'.$this->server->id.'/categories/'.$category->id)
        ->assertRedirect('/servers/'.$this->server->id);

    assertDatabaseMissing(Category::class, [
        'id' => $category->id,
    ]);
});