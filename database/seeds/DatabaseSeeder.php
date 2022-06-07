<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class,10000)->create();
        factory(App\Post::class,600)->create();
        factory(App\Comment::class,1000)->create();
    }
}
