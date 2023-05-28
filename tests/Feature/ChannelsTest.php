<?php

use App\Models\User;
use App\Models\Server;
use App\Models\Channel;
use App\Models\Category;
use App\Enums\ChannelType;
use function Pest\Laravel\{actingAs, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);

    $this->server = Server::factory()->create();

    $this->category = Category::factory()
        ->for($this->server)
        ->create();
});

it('can be created', function () {
    post('/servers/'.$this->server->id.'/channels', [
        'name' => 'new channel',
        'type' => ChannelType::VOICE->value,
        'category_id' => $this->category->id,
    ])
    ->assertRedirect();

    assertDatabaseHas(Channel::class, [
        'name' => 'new channel',
        'type' => ChannelType::VOICE->value,
        'category_id' => $this->category->id,
    ]);
});

it('can be updated', function () {
    $channel = Channel::factory()->create([
        'name' => 'old channel name',
    ]);

    put('/servers/'.$this->server->id.'/channels/'.$channel->id, [
        'name' => 'new channel name',
    ])
    ->assertRedirect();

    assertDatabaseHas(Channel::class, [
        'id' => $channel->id,
        'name' => 'new channel name',
    ]);
});

it('can be deleted', function () {
    $channel = Channel::factory()->create();

    delete('/servers/'.$this->server->id.'/channels/'.$channel->id)
        ->assertRedirect('/servers/'.$this->server->id);

    assertDatabaseMissing(Channel::class, [
        'id' => $channel->id,
    ]);
});