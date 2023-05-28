<?php

namespace App\Http\Controllers;

use App\Enums\ChannelType;
use App\Models\Channel;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ServerChannelController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Server $server)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'type' => ['required', new Enum(ChannelType::class)],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($server) {
                return $query->where('server_id', $server->id);
            })],
        ]);

        $server->channels()->create([
            'name' => $request->name,
            'type' => $request->type,
            'category_id' => $request->category_id,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Server $server)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Server $server, Channel $channel)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $channel->update([
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server, Channel $channel)
    {
        $channel->delete();

        return to_route('servers.show', $server);
    }
}
