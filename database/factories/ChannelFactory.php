<?php

namespace Database\Factories;

use App\Enums\ChannelType;
use App\Models\Category;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
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
            'category_id' => Category::factory(),
            'name' => fake()->text(25),
            'type' => fake()->randomElement(ChannelType::cases()),
        ];
    }
}
