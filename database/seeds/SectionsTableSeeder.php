<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Prep-A',
                'code' => 'prep-a1605541502',
                'description' => 'Prep-A',
                'created_at' => '2020-11-16 15:45:02',
                'updated_at' => '2020-11-16 15:45:02',
                'grade_level_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Prep-B',
                'code' => 'prep-b1605541534',
                'description' => 'Prep-B',
                'created_at' => '2020-11-16 15:45:34',
                'updated_at' => '2020-11-16 15:45:34',
                'grade_level_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Kinder-A',
                'code' => 'kinder-a1605541547',
                'description' => 'Kinder-A',
                'created_at' => '2020-11-16 15:45:47',
                'updated_at' => '2020-11-16 15:45:47',
                'grade_level_id' => 2,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Kinder-B',
                'code' => 'kinder-b1605541553',
                'description' => 'Kinder-B',
                'created_at' => '2020-11-16 15:45:53',
                'updated_at' => '2020-11-16 15:45:53',
                'grade_level_id' => 2,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Paul',
                'code' => 'paul1605541564',
                'description' => 'Paul',
                'created_at' => '2020-11-16 15:46:04',
                'updated_at' => '2020-11-16 15:46:04',
                'grade_level_id' => 3,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Peter',
                'code' => 'peter1605541573',
                'description' => 'Peter',
                'created_at' => '2020-11-16 15:46:13',
                'updated_at' => '2020-11-16 15:46:13',
                'grade_level_id' => 3,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'John',
                'code' => 'john1605541580',
                'description' => 'John',
                'created_at' => '2020-11-16 15:46:20',
                'updated_at' => '2020-11-16 15:46:20',
                'grade_level_id' => 3,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Zuckerberg',
                'code' => 'zuckerberg1605541594',
                'description' => 'Zuckerberg',
                'created_at' => '2020-11-16 15:46:34',
                'updated_at' => '2020-11-16 15:46:34',
                'grade_level_id' => 4,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Bezos',
                'code' => 'bezos1605541601',
                'description' => 'Bezos',
                'created_at' => '2020-11-16 15:46:41',
                'updated_at' => '2020-11-16 15:46:41',
                'grade_level_id' => 4,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Gates',
                'code' => 'gates1605541607',
                'description' => 'Gates',
                'created_at' => '2020-11-16 15:46:47',
                'updated_at' => '2020-11-16 15:46:47',
                'grade_level_id' => 4,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Linux',
                'code' => 'linux1605541615',
                'description' => 'Linux',
                'created_at' => '2020-11-16 15:46:55',
                'updated_at' => '2020-11-16 15:46:55',
                'grade_level_id' => 5,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Windows',
                'code' => 'windows1605541657',
                'description' => 'Windows',
                'created_at' => '2020-11-16 15:47:37',
                'updated_at' => '2020-11-16 15:47:37',
                'grade_level_id' => 5,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'High Sierra',
                'code' => 'high sierra1605541675',
                'description' => 'High Sierra',
                'created_at' => '2020-11-16 15:47:55',
                'updated_at' => '2020-11-16 15:47:55',
                'grade_level_id' => 5,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Resilience',
                'code' => 'resilience1605541695',
                'description' => 'Resilience',
                'created_at' => '2020-11-16 15:48:15',
                'updated_at' => '2020-11-16 15:48:15',
                'grade_level_id' => 6,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Bravery',
                'code' => 'bravery1605541705',
                'description' => 'Bravery',
                'created_at' => '2020-11-16 15:48:25',
                'updated_at' => '2020-11-16 15:48:25',
                'grade_level_id' => 6,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Perseverance',
                'code' => 'perseverance1605541714',
                'description' => 'Perseverance',
                'created_at' => '2020-11-16 15:48:34',
                'updated_at' => '2020-11-16 15:48:34',
                'grade_level_id' => 6,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Mars',
                'code' => 'mars1605541738',
                'description' => 'Mars',
                'created_at' => '2020-11-16 15:48:58',
                'updated_at' => '2020-11-16 15:48:58',
                'grade_level_id' => 7,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Mercury',
                'code' => 'mercury1605541747',
                'description' => 'Mercury',
                'created_at' => '2020-11-16 15:49:07',
                'updated_at' => '2020-11-16 15:49:07',
                'grade_level_id' => 7,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Uranus',
                'code' => 'uranus1605541754',
                'description' => 'Uranus',
                'created_at' => '2020-11-16 15:49:14',
                'updated_at' => '2020-11-16 15:49:14',
                'grade_level_id' => 7,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Matrix',
                'code' => 'matrix1605541777',
                'description' => 'Matrix',
                'created_at' => '2020-11-16 15:49:37',
                'updated_at' => '2020-11-16 15:49:37',
                'grade_level_id' => 8,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Salt',
                'code' => 'salt1605541793',
                'description' => 'Salt',
                'created_at' => '2020-11-16 15:49:53',
                'updated_at' => '2020-11-16 15:49:53',
                'grade_level_id' => 8,
            ),
        ));
        
        
    }
}