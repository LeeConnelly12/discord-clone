<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::all();

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
            'name' => $request->name,
        ]);

        return to_route('servers.show', $server);
    }

    public function show(Server $server)
    {
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
