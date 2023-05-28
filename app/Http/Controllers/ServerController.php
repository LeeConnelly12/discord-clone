<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $servers = $request->user()->servers;

        return inertia('Servers/Index', [
            'servers' => ServerResource::collection($servers),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $server = Server::query()->create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
        ]);

        $server->users()->attach($request->user);

        return to_route('servers.show', $server);
    }

    public function show(Server $server)
    {
        $server->load('users');

        return inertia('Servers/Show', [
            'server' => new ServerResource($server),
        ]);
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return to_route('home');
    }
}
