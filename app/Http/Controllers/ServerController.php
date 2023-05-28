<?php

namespace App\Http\Controllers;

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

        return to_route('servers.show', $server);
    }

    public function show(Server $server)
    {
        $server->load('users:id,username', 'media');

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
