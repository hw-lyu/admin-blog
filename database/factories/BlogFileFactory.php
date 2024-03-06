<?php

namespace Database\Factories;

use App\Models\BlogFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogFileFactory extends Factory
{
    protected $model = BlogFile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => 'placehold.co/600x400@2x.png',
            'file_name' => '600x400@2x.png',
            'file_size' => $this->faker->randomDigit(),
            'file_mine' => $this->faker->mimeType(),
//            'created_at' => now(),
//            'updated_at' => now(),
//            'deleted_at' => null
        ];
    }
}
