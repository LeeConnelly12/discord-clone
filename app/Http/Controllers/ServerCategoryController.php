<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Category;
use Illuminate\Http\Request;

class ServerCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Server $server)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $server->categories()->create([
            'name' => $request->name,
        ]);

        return back();
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
    public function update(Request $request, Server $server, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server, Category $category)
    {
        $category->delete();

        return to_route('servers.show', $server);
    }
}
