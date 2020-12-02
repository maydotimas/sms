<?php

use Illuminate\Database\Seeder;

class SubFeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_fees')->delete();
        
        \DB::table('sub_fees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Regular',
                'code' => 'kinder fees1604587224',
                'description' => 'Regular fee for 15000',
                'type' => 'REGULAR',
                'misc' => '3000',
                'tuition' => '15000',
                'discount' => '0',
                'fee_id' => 1,
                'created_at' => '2020-11-05 14:40:26',
                'updated_at' => '2020-11-05 14:40:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'SIBLING DISCOUNT',
                'code' => 'sibling discount1604587240',
                'description' => 'SIBLING DISCOUNT',
                'type' => 'SIBLING',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '10',
                'fee_id' => 1,
                'created_at' => '2020-11-05 14:40:40',
                'updated_at' => '2020-11-05 14:40:40',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'VALEDICTORIAN',
                'code' => 'valedictorian1604587254',
                'description' => 'VALEDICTORIAN',
                'type' => 'DISCOUNT',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '100',
                'fee_id' => 1,
                'created_at' => '2020-11-05 14:40:54',
                'updated_at' => '2020-11-05 14:40:54',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Regular',
                'code' => 'elementary fees1604587282',
                'description' => 'Regular fee for 18000',
                'type' => 'REGULAR',
                'misc' => '5000',
                'tuition' => '18000',
                'discount' => '0',
                'fee_id' => 2,
                'created_at' => '2020-11-05 14:41:22',
                'updated_at' => '2020-11-05 14:41:22',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Regular',
                'code' => 'intermediate fees1604587301',
                'description' => 'Regular fee for 20000',
                'type' => 'REGULAR',
                'misc' => '5000',
                'tuition' => '20000',
                'discount' => '0',
                'fee_id' => 3,
                'created_at' => '2020-11-05 14:41:41',
                'updated_at' => '2020-11-05 14:41:41',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'SIBLING DISCOUNT',
                'code' => 'sibling discount1604587321',
                'description' => 'SIBLING DISCOUNT',
                'type' => 'SIBLING',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '12',
                'fee_id' => 1,
                'created_at' => '2020-11-05 14:42:01',
                'updated_at' => '2020-11-05 14:42:01',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'SIBLING',
                'code' => 'sibling1604588313',
                'description' => 'SIBLING',
                'type' => 'SIBLING',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '8',
                'fee_id' => 3,
                'created_at' => '2020-11-05 14:58:33',
                'updated_at' => '2020-11-05 14:58:33',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'valedictorian scholar',
                'code' => 'valedictorian scholar1604669574',
                'description' => 'valedictorian scholar',
                'type' => 'SCHOLAR',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '100',
                'fee_id' => 3,
                'created_at' => '2020-11-06 13:32:54',
                'updated_at' => '2020-11-06 13:32:54',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'SIBLING',
                'code' => 'sibling1604671909',
                'description' => 'SIBLING',
                'type' => 'SIBLING',
                'misc' => '0',
                'tuition' => '0',
                'discount' => '10',
                'fee_id' => 3,
                'created_at' => '2020-11-06 14:11:49',
                'updated_at' => '2020-11-06 14:11:49',
            ),
        ));
        
        
    }
}