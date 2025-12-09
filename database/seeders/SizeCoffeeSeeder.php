<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeCoffeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('size_coffees')->insert([
            ['name' => 'Small', 'ml' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'ml' => 250, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Large', 'ml' => 500, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
