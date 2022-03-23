<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Model\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Post::create([
            'title' => $faker->sentence(3),
            'body' => $faker->paragraph(5)
        ]);
    }
}
