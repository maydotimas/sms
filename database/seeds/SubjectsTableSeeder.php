<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subjects')->delete();
        
        \DB::table('subjects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Reading Comprehension',
                'code' => 'reading comprehension1605542103',
                'description' => 'Reading Comprehension',
                'created_at' => '2020-11-16 15:55:03',
                'updated_at' => '2020-11-16 15:55:03',
                'category_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Filipino I',
                'code' => 'filipino i1605542112',
                'description' => 'Filipino I',
                'created_at' => '2020-11-16 15:55:12',
                'updated_at' => '2020-11-16 15:55:12',
                'category_id' => 2,
            ),
        ));
        
        
    }
}