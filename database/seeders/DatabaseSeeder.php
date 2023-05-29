<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Server;
use App\Models\Channel;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Server::factory()
            ->count(3)
            ->for($user)
            ->hasAttached($user)
            ->has(
                Category::factory()
                    ->count(2)
                    ->has(Channel::factory())
            )
            ->create();
    }
}
