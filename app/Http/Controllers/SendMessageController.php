<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Channel;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;

class SendMessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Server $server, Channel $channel)
    {
        $request->validate([
            'text' => ['required', 'string', 'max:200'],
        ]);

        $message = $channel->messages()->create([
            'user_id' => $request->user()->id,
            'server_id' => $server->id,
            'text' => $request->text,
        ]);

        MessageSent::broadcast($message)->toOthers();

        return back();
    }
}
