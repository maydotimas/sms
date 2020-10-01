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
        for ($ctr = 0; $ctr < 100; $ctr++) {
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
                'name' => 'subject: ' . Str::random(10),
                'code' => Str::random(10),
                'description' => Str::random(10),
                'category_id' => 1,
            ]);

            DB::table('student_parents')->insert([
                'parent_no' => 'subject: ' . Str::random(10),
                'first_name' => Str::random(10),
                'middle_name' => Str::random(10),
                'last_name' => Str::random(10),
                'suffix' => Str::random(10),
                'occupation' => Str::random(10),
                'office_address' => Str::random(10),
                'email' => Str::random(10),
                'mobile' => Str::random(10),
                'avatar' => Str::random(10),
                'type' => 'Father'
            ]);
            DB::table('student_parents')->insert([
                'parent_no' => 'subject: ' . Str::random(10),
                'first_name' => Str::random(10),
                'middle_name' => Str::random(10),
                'last_name' => Str::random(10),
                'suffix' => Str::random(10),
                'occupation' => Str::random(10),
                'office_address' => Str::random(10),
                'email' => Str::random(10),
                'mobile' => Str::random(10),
                'avatar' => Str::random(10),
                'type' => 'Mother'
            ]);
            DB::table('student_parents')->insert([
                'parent_no' => 'subject: ' . Str::random(10),
                'first_name' => Str::random(10),
                'middle_name' => Str::random(10),
                'last_name' => Str::random(10),
                'suffix' => Str::random(10),
                'occupation' => Str::random(10),
                'office_address' => Str::random(10),
                'email' => Str::random(10),
                'mobile' => Str::random(10),
                'avatar' => Str::random(10),
                'type' => 'Guardian'
            ]);


        }

    }
}
