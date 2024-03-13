<?php

namespace Database\Seeders;

use App\Models\BlogFile;
use App\Models\BlogInformation;
use App\Models\BlogMenu;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(1)->create();

        BlogFile::factory()->count(50)->create();

        BlogInformation::factory()
            ->count(50)
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'profile_file_id' => BlogFile::all()->random()['id'],
                    'cover_file_id' => BlogFile::all()->random()['id']
                ],
            ))
            ->create();

        BlogMenu::factory()
            ->count(5)
            ->sequence(fn(Sequence $sequence) => ['parent_id' => $sequence->index + 1])
            ->create();

        BlogPost::factory()
            ->count(50)
            ->state(new Sequence(fn(Sequence $sequence) => [
                'menu_id' => BlogMenu::all()->random()['id'],
                'write' => User::all()->random()['email'],
                'thumbnail_id' => BlogFile::all()->random()['id']
            ]
            ))
            ->create();
    }
}
