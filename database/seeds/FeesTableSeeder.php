<?php

use Illuminate\Database\Seeder;

class FeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fees')->delete();
        
        \DB::table('fees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Kinder Fees',
                'code' => 'kinder fees1604587224',
                'description' => 'Kinder Fees',
                'created_at' => '2020-11-05 14:40:24',
                'updated_at' => '2020-11-05 14:40:24',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Elementary Fees',
                'code' => 'elementary fees1604587282',
                'description' => 'Elementary Fees',
                'created_at' => '2020-11-05 14:41:22',
                'updated_at' => '2020-11-05 14:41:22',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Intermediate Fees',
                'code' => 'intermediate fees1604587301',
                'description' => 'Intermediate Fees',
                'created_at' => '2020-11-05 14:41:41',
                'updated_at' => '2020-11-05 14:41:41',
            ),
        ));
        
        
    }
}