<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($ctr = 0; $ctr < 20; $ctr++) {
            DB::table('categories')->insert([
                'name' => Str::random(10),
                'code' => Str::random(10),
                'description' => Str::random(10),
            ]);
            DB::table('departments')->insert([
                'name' => Str::random(10),
                'code' => Str::random(10),
                'description' => Str::random(10),
            ]);
            DB::table('subjects')->insert([
                'name' => 'subject: '.Str::random(10),
                'code' => Str::random(10),
                'description' => Str::random(10),
                'category_id' => 1,
            ]);
        }

    }
}
