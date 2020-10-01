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
        $faker = \Faker\Factory::create();
        for ($ctr = 0; $ctr < 100; $ctr++) {
//            DB::table('categories')->insert([
//                'name' => $faker->name,
//                'code' => $faker->words,
//                'description' => $faker->words,
//            ]);
//            DB::table('departments')->insert([
//                'name' => 'Department: '.$faker->word(),
//                'code' => $faker->words,
//                'description' =>$faker->words,
//            ]);
//            DB::table('subjects')->insert([
//                'name' => 'Subject: '.$faker->word(),
//                'code' => $faker->words,
//                'description' => $faker->words,
//                'category_id' => 1,
//            ]);

            DB::table('student_parents')->insert([
                'parent_no' => 'PN-' . Str::random(10),
                'first_name' => $faker->name,
                'middle_name' =>$faker->name,
                'last_name' => $faker->name,
                'suffix' => Str::random(10),
                'occupation' => $faker->word(),
                'office_address' => $faker->address,
                'email' => $faker->email,
                'mobile' =>  $faker->phoneNumber,
                'avatar' => Str::random(10),
                'type' => 'Father'
            ]);
            DB::table('student_parents')->insert([
                'parent_no' => 'PN-' . Str::random(10),
                'first_name' => $faker->name,
                'middle_name' =>$faker->name,
                'last_name' => $faker->name,
                'suffix' => Str::random(10),
                'occupation' => $faker->word(),
                'office_address' => $faker->address,
                'email' => $faker->email,
                'mobile' =>  $faker->phoneNumber,
                'avatar' => Str::random(10),
                'type' => 'Mother'
            ]);
            DB::table('student_parents')->insert([
                'parent_no' => 'PN-' . Str::random(10),
                'first_name' => $faker->name,
                'middle_name' =>$faker->name,
                'last_name' => $faker->name,
                'suffix' => Str::random(10),
                'occupation' => $faker->word(),
                'office_address' => $faker->address,
                'email' => $faker->email,
                'mobile' =>  $faker->phoneNumber,
                'avatar' => Str::random(10),
                'type' => 'Guardian'
            ]);


        }

    }
}
