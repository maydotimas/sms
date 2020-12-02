<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Kindergarten',
                'code' => 'kindergarten1604587188',
                'description' => 'Kindergarten',
                'created_at' => '2020-11-05 14:39:48',
                'updated_at' => '2020-11-05 14:39:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Primary',
                'code' => 'primary1604587199',
                'description' => 'Primary',
                'created_at' => '2020-11-05 14:39:59',
                'updated_at' => '2020-11-05 14:39:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Intermediate',
                'code' => 'intermediate1604587208',
                'description' => 'Intermediate',
                'created_at' => '2020-11-05 14:40:08',
                'updated_at' => '2020-11-05 14:40:08',
            ),
        ));
        
        
    }
}