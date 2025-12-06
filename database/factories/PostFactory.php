<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'title' => fake()->sentence(6),
            'slug' => fake()->slug(6),
            'excerpt' => fake()->text(100),
            'featured_image' => fake()->imageUrl(640, 480, 'nature'),
            'content' => fake()->text(1000),
            'status' => fake()->randomElement(['published', 'draft']),
        ];
    }
}
