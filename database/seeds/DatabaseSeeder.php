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
        factory(App\Models\User::class, 2)->create();
        factory(App\Models\ProductType::class, 10)->create();
        factory(App\Models\Product::class, 100)->create();
    }
}
