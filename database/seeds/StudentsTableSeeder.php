<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('students')->delete();
        
        \DB::table('students')->insert(array (
            0 => 
            array (
                'id' => 1,
                'lrn' => '123',
                'student_no' => '22-02567',
                'first_name' => 'ERLINDA MAY',
                'middle_name' => 'MARINO',
                'last_name' => 'DOTIMAS',
                'suffix' => NULL,
                'nickname' => 'MAY',
                'handedness' => 'Ambidextrous',
                'religion' => 'Jehovah\'s Witness',
                'street' => 'MCARTHUR HIWAY',
                'brgy' => '31407015',
                'town' => '31407000',
                'gender' => 'Female',
                'birthdate' => '2020-11-01T16:00:00.000Z',
                'province' => '31400000',
                'email' => 'DOTIMASMAY@GMAIL.COM',
                'mobile' => '09958510836',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-15 16:03:21',
                'updated_at' => '2020-11-15 16:03:21',
            ),
            1 => 
            array (
                'id' => 2,
                'lrn' => '12345',
                'student_no' => '2020-0002',
                'first_name' => 'JUNMAR',
                'middle_name' => 'CAMPOS',
                'last_name' => 'MARINO',
                'suffix' => NULL,
                'nickname' => 'JM',
                'handedness' => 'Left',
                'religion' => 'Jehovah\'s Witness',
                'street' => '43',
                'brgy' => '31407021',
                'town' => '31407000',
                'gender' => 'Male',
                'birthdate' => '2020-11-02T16:00:00.000Z',
                'province' => '31400000',
                'email' => 'junmar@gmail.com',
                'mobile' => '123456789',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-19 15:57:12',
                'updated_at' => '2020-11-19 15:57:12',
            ),
            2 => 
            array (
                'id' => 3,
                'lrn' => '666666',
                'student_no' => '2020-0003',
                'first_name' => 'LARRY',
                'middle_name' => NULL,
                'last_name' => 'LOBSTER',
                'suffix' => NULL,
                'nickname' => NULL,
                'handedness' => 'Left',
                'religion' => 'Jehovah\'s Witness',
                'street' => 'sttreet',
                'brgy' => '31407008',
                'town' => '31407000',
                'gender' => 'Male',
                'birthdate' => '2020-11-01T16:00:00.000Z',
                'province' => '31400000',
                'email' => 'email@gmgail.com',
                'mobile' => '1234567890',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-19 16:01:06',
                'updated_at' => '2020-11-19 16:01:06',
            ),
            3 => 
            array (
                'id' => 4,
                'lrn' => '000000',
                'student_no' => '2020-0004',
                'first_name' => 'BABY',
                'middle_name' => NULL,
                'last_name' => 'PINEDA',
                'suffix' => NULL,
                'nickname' => NULL,
                'handedness' => 'Left',
                'religion' => 'Born Again',
                'street' => 'street',
                'brgy' => '31407015',
                'town' => '31407000',
                'gender' => 'Male',
                'birthdate' => '2020-11-01T16:00:00.000Z',
                'province' => '31400000',
                'email' => 'kk@gmail.com',
                'mobile' => '99999999999',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-19 16:03:13',
                'updated_at' => '2020-11-19 16:03:13',
            ),
            4 => 
            array (
                'id' => 5,
                'lrn' => '33333',
                'student_no' => '2020-0005',
                'first_name' => 'SPONGEBOB',
                'middle_name' => NULL,
                'last_name' => 'SQUAREPANTS',
                'suffix' => NULL,
                'nickname' => NULL,
                'handedness' => 'Ambidextrous',
                'religion' => 'Jehovah\'s Witness',
                'street' => 'Street',
                'brgy' => '35419007',
                'town' => '35419000',
                'gender' => 'Female',
                'birthdate' => '2020-11-01T16:00:00.000Z',
                'province' => '35400000',
                'email' => 'spongebob@mail.com',
                'mobile' => '999999999999',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-19 16:04:49',
                'updated_at' => '2020-11-19 16:04:49',
            ),
            5 => 
            array (
                'id' => 6,
                'lrn' => '88888',
                'student_no' => '2020-0006',
                'first_name' => 'PATRICK',
                'middle_name' => NULL,
                'last_name' => 'STARR',
                'suffix' => NULL,
                'nickname' => NULL,
                'handedness' => 'Ambidextrous',
                'religion' => 'Jehovah\'s Witness',
                'street' => 'Street',
                'brgy' => '31410056',
                'town' => '31410000',
                'gender' => 'Male',
                'birthdate' => '2020-11-01T16:00:00.000Z',
                'province' => '31400000',
                'email' => 'living@gmail.com',
                'mobile' => '09958510836',
                'avatar' => 'uploads\\default.png',
                'emergency_contact' => NULL,
                'created_at' => '2020-11-19 16:07:15',
                'updated_at' => '2020-11-19 16:07:15',
            ),
        ));
        
        
    }
}