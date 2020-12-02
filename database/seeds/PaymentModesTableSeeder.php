<?php

use Illuminate\Database\Seeder;

class PaymentModesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_modes')->delete();
        
        \DB::table('payment_modes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '2020 Payment Mode',
                'code' => '2020 payment mode1605542128',
                'description' => '2020 Payment Mode',
                'created_at' => '2020-11-16 15:55:28',
                'updated_at' => '2020-11-16 15:55:28',
            ),
        ));
        
        
    }
}