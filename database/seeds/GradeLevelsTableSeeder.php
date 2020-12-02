<?php

use Illuminate\Database\Seeder;

class GradeLevelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grade_levels')->delete();
        
        \DB::table('grade_levels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Preparatory',
                'code' => 'preparatory1605541388',
                'description' => 'Preparatory',
                'created_at' => '2020-11-16 15:43:08',
                'updated_at' => '2020-11-16 15:43:08',
                'department_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Kindergarten',
                'code' => 'kindergarten1605541426',
                'description' => 'Kindergarten Description',
                'created_at' => '2020-11-16 15:43:46',
                'updated_at' => '2020-11-16 15:43:46',
                'department_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Grade I',
                'code' => 'grade i1605541438',
                'description' => 'Grade I',
                'created_at' => '2020-11-16 15:43:58',
                'updated_at' => '2020-11-16 15:43:58',
                'department_id' => 2,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Grade II',
                'code' => 'grade ii1605541444',
                'description' => 'Grade II',
                'created_at' => '2020-11-16 15:44:04',
                'updated_at' => '2020-11-16 15:44:04',
                'department_id' => 2,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Grade III',
                'code' => 'grade iii1605541450',
                'description' => 'Grade III',
                'created_at' => '2020-11-16 15:44:10',
                'updated_at' => '2020-11-16 15:44:10',
                'department_id' => 2,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Grade IV',
                'code' => 'grade iv1605541460',
                'description' => 'Grade IV',
                'created_at' => '2020-11-16 15:44:20',
                'updated_at' => '2020-11-16 15:44:20',
                'department_id' => 3,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Grade V',
                'code' => 'grade v1605541468',
                'description' => 'Grade V',
                'created_at' => '2020-11-16 15:44:28',
                'updated_at' => '2020-11-16 15:44:28',
                'department_id' => 3,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Grade VI',
                'code' => 'grade vi1605541484',
                'description' => 'Grade VI',
                'created_at' => '2020-11-16 15:44:44',
                'updated_at' => '2020-11-16 15:44:44',
                'department_id' => 3,
            ),
        ));
        
        
    }
}