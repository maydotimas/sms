<?php

use Illuminate\Database\Seeder;

class PaymentModeTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_mode_types')->delete();
        
        \DB::table('payment_mode_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Annual',
                'code' => '2020 Payment Mode Annual1605542129',
                'description' => '2020 Payment Mode',
                'percentage' => '0',
                'payable_in' => '1',
                'payment_mode_id' => 1,
                'created_at' => '2020-11-16 15:55:29',
                'updated_at' => '2020-11-16 15:55:29',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Semestral',
                'code' => 'semestral1605542147',
                'description' => 'Semestral',
                'percentage' => '5',
                'payable_in' => '2',
                'payment_mode_id' => 1,
                'created_at' => '2020-11-16 15:55:47',
                'updated_at' => '2020-11-16 15:55:47',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Trimestral',
                'code' => 'trimestral1605542157',
                'description' => 'Trimestral',
                'percentage' => '7',
                'payable_in' => '3',
                'payment_mode_id' => 1,
                'created_at' => '2020-11-16 15:55:57',
                'updated_at' => '2020-11-16 15:55:57',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Quarterly',
                'code' => 'quarterly1605542169',
                'description' => 'Quarterly',
                'percentage' => '9',
                'payable_in' => '4',
                'payment_mode_id' => 1,
                'created_at' => '2020-11-16 15:56:09',
                'updated_at' => '2020-11-16 15:56:09',
            ),
        ));
        
        
    }
}