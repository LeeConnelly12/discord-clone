<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'server_id' => Server::factory(),
            'channel_id' => Channel::factory(),
            'user_id' => User::factory(),
            'text' => fake()->text(200),
        ];
    }
}
