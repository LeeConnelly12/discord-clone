<?php

namespace App\Http\Controllers;

use App\Enums\ChannelType;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class ServerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'image' => ['nullable', File::types(['jpg', 'png', 'webp'])->max(5120)],
        ]);

        $server = Server::query()->create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
        ]);

       if ($request->hasFile('image')) {
            $server
                ->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        $server->users()->attach($request->user());

        $textCategory = $server->categories()->create([
             'name' => 'text channels',
        ]);

        $server->channels()->create([
            'category_id' => $textCategory->id,
            'name' => 'general',
            'type' => ChannelType::TEXT,
        ]);

        $voiceCategory = $server->categories()->create([
            'name' => 'voice channels',
        ]);

        $server->channels()->create([
            'category_id' => $voiceCategory->id,
            'name' => 'general',
            'type' => ChannelType::VOICE,
        ]);

        return to_route('servers.show', $server);
    }

    public function show(Request $request, Server $server)
    {
        $server->load('users:id,username', 'categories.channels', 'media');

        if (!$server->users()->where('users.id', $request->user()->id)->exists()) {
            $server->users()->attach($request->user());
        }

        return inertia('Servers/Show', [
            'server' => new ServerResource($server),
        ]);
    }

    public function update(Request $request, Server $server)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'image' => ['nullable', File::types(['jpg', 'png', 'webp'])->max(5120)],
        ]);

        $server->update([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image')) {
            $server
                ->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return back();
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return to_route('home');
    }
}
