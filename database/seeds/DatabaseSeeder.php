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

        factory(App\User::class, 10)->create();
        factory(App\Category::class, 10)->create();
        factory(App\Book::class, 10)->create();
        factory(App\Rate::class,30)->create();
        factory(App\LeaseDetail::class,30)->create();
    }
}
