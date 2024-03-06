<?php

namespace Database\Factories;

use App\Models\BlogMenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogMenuFactory extends Factory
{

    protected $model = BlogMenu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'name_eng' => $this->faker->word(),
            'is_blind' => $this->faker->numberBetween(0,1),
            'sort' =>1,
            'depth' =>1,
        ];
    }
}
