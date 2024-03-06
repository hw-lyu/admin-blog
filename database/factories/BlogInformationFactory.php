<?php

namespace Database\Factories;

use App\Models\BlogInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogInformationFactory extends Factory
{
    protected $model = BlogInformation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'nick_name' => $this->faker->userName(),
            'introduce' => $this->faker->paragraph(2)
        ];
    }
}
