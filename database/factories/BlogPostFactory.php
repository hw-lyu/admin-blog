<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagList = $this->faker->randomElements(['태그1', '태그2', '태그3', '태그4', '태그5']);

        return [
            'name' => $this->faker->word(),
            'content' => $this->faker->paragraph(),
            'is_blind' => $this->faker->numberBetween(0, 1),
            'tag_list' => json_encode($tagList),
            'view_count' => $this->faker->randomNumber()
        ];
    }
}
