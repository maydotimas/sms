<?php

use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('provinces')->delete();

        \DB::table('provinces')->insert(array (
            0 =>
            array (
                'id' => 1,
                'provCode' => '140100000',
                'provDesc' => 'ABRA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'provCode' => '160200000',
                'provDesc' => 'AGUSAN DEL NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'provCode' => '160300000',
                'provDesc' => 'AGUSAN DEL SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'provCode' => '60400000',
                'provDesc' => 'AKLAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'provCode' => '50500000',
                'provDesc' => 'ALBAY',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'provCode' => '60600000',
                'provDesc' => 'ANTIQUE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'provCode' => '148100000',
                'provDesc' => 'APAYAO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'provCode' => '37700000',
                'provDesc' => 'AURORA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'provCode' => '150700000',
                'provDesc' => 'BASILAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'provCode' => '30800000',
                'provDesc' => 'BATAAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'provCode' => '20900000',
                'provDesc' => 'BATANES',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'provCode' => '41000000',
                'provDesc' => 'BATANGAS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'provCode' => '141100000',
                'provDesc' => 'BENGUET',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'provCode' => '87800000',
                'provDesc' => 'BILIRAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'provCode' => '71200000',
                'provDesc' => 'BOHOL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'provCode' => '101300000',
                'provDesc' => 'BUKIDNON',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'provCode' => '31400000',
                'provDesc' => 'BULACAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'provCode' => '21500000',
                'provDesc' => 'CAGAYAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'provCode' => '51600000',
                'provDesc' => 'CAMARINES NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'provCode' => '51700000',
                'provDesc' => 'CAMARINES SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'provCode' => '101800000',
                'provDesc' => 'CAMIGUIN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'provCode' => '61900000',
                'provDesc' => 'CAPIZ',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'provCode' => '52000000',
                'provDesc' => 'CATANDUANES',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'provCode' => '42100000',
                'provDesc' => 'CAVITE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'provCode' => '72200000',
                'provDesc' => 'CEBU',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 =>
            array (
                'id' => 26,
                'provCode' => '99700000',
            'provDesc' => 'CITY OF ISABELA (Not a provinces)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 =>
            array (
                'id' => 27,
                'provCode' => '124700000',
            'provDesc' => 'COTABATO (NORTH COTABATO)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 =>
            array (
                'id' => 28,
                'provCode' => '129800000',
            'provDesc' => 'COTABATO CITY (Not a provinces)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 =>
            array (
                'id' => 29,
                'provCode' => '118200000',
            'provDesc' => 'DAVAO DE ORO (COMPOSTELA VALLEY)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 =>
            array (
                'id' => 30,
                'provCode' => '112300000',
                'provDesc' => 'DAVAO DEL NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 =>
            array (
                'id' => 31,
                'provCode' => '112400000',
                'provDesc' => 'DAVAO DEL SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 =>
            array (
                'id' => 32,
                'provCode' => '118600000',
                'provDesc' => 'DAVAO OCCIDENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 =>
            array (
                'id' => 33,
                'provCode' => '112500000',
                'provDesc' => 'DAVAO ORIENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 =>
            array (
                'id' => 34,
                'provCode' => '168500000',
                'provDesc' => 'DINAGAT ISLANDS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 =>
            array (
                'id' => 35,
                'provCode' => '82600000',
                'provDesc' => 'EASTERN SAMAR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 =>
            array (
                'id' => 36,
                'provCode' => '67900000',
                'provDesc' => 'GUIMARAS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 =>
            array (
                'id' => 37,
                'provCode' => '142700000',
                'provDesc' => 'IFUGAO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 =>
            array (
                'id' => 38,
                'provCode' => '12800000',
                'provDesc' => 'ILOCOS NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 =>
            array (
                'id' => 39,
                'provCode' => '12900000',
                'provDesc' => 'ILOCOS SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 =>
            array (
                'id' => 40,
                'provCode' => '63000000',
                'provDesc' => 'ILOILO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 =>
            array (
                'id' => 41,
                'provCode' => '23100000',
                'provDesc' => 'ISABELA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 =>
            array (
                'id' => 42,
                'provCode' => '143200000',
                'provDesc' => 'KALINGA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 =>
            array (
                'id' => 43,
                'provCode' => '13300000',
                'provDesc' => 'LA UNION',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 =>
            array (
                'id' => 44,
                'provCode' => '43400000',
                'provDesc' => 'LAGUNA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 =>
            array (
                'id' => 45,
                'provCode' => '103500000',
                'provDesc' => 'LANAO DEL NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 =>
            array (
                'id' => 46,
                'provCode' => '153600000',
                'provDesc' => 'LANAO DEL SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 =>
            array (
                'id' => 47,
                'provCode' => '83700000',
                'provDesc' => 'LEYTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 =>
            array (
                'id' => 48,
                'provCode' => '153800000',
                'provDesc' => 'MAGUINDANAO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 =>
            array (
                'id' => 49,
                'provCode' => '174000000',
                'provDesc' => 'MARINDUQUE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 =>
            array (
                'id' => 50,
                'provCode' => '54100000',
                'provDesc' => 'MASBATE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 =>
            array (
                'id' => 51,
                'provCode' => '104200000',
                'provDesc' => 'MISAMIS OCCIDENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 =>
            array (
                'id' => 52,
                'provCode' => '104300000',
                'provDesc' => 'MISAMIS ORIENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 =>
            array (
                'id' => 53,
                'provCode' => '144400000',
                'provDesc' => 'MOUNTAIN provinces',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 =>
            array (
                'id' => 54,
                'provCode' => '133900000',
                'provDesc' => 'National Capital Region',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 =>
            array (
                'id' => 55,
                'provCode' => '64500000',
                'provDesc' => 'NEGROS OCCIDENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 =>
            array (
                'id' => 56,
                'provCode' => '74600000',
                'provDesc' => 'NEGROS ORIENTAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 =>
            array (
                'id' => 57,
                'provCode' => '84800000',
                'provDesc' => 'NORTHERN SAMAR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 =>
            array (
                'id' => 58,
                'provCode' => '34900000',
                'provDesc' => 'NUEVA ECIJA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 =>
            array (
                'id' => 59,
                'provCode' => '25000000',
                'provDesc' => 'NUEVA VIZCAYA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 =>
            array (
                'id' => 60,
                'provCode' => '175100000',
                'provDesc' => 'OCCIDENTAL MINDORO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 =>
            array (
                'id' => 61,
                'provCode' => '175200000',
                'provDesc' => 'ORIENTAL MINDORO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 =>
            array (
                'id' => 62,
                'provCode' => '175300000',
                'provDesc' => 'PALAWAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 =>
            array (
                'id' => 63,
                'provCode' => '35400000',
                'provDesc' => 'PAMPANGA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 =>
            array (
                'id' => 64,
                'provCode' => '15500000',
                'provDesc' => 'PANGASINAN',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 =>
            array (
                'id' => 65,
                'provCode' => '45600000',
                'provDesc' => 'QUEZON',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 =>
            array (
                'id' => 66,
                'provCode' => '25700000',
                'provDesc' => 'QUIRINO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 =>
            array (
                'id' => 67,
                'provCode' => '45800000',
                'provDesc' => 'RIZAL',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 =>
            array (
                'id' => 68,
                'provCode' => '175900000',
                'provDesc' => 'ROMBLON',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 =>
            array (
                'id' => 69,
                'provCode' => '86000000',
            'provDesc' => 'SAMAR (WESTERN SAMAR)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 =>
            array (
                'id' => 70,
                'provCode' => '128000000',
                'provDesc' => 'SARANGANI',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 =>
            array (
                'id' => 71,
                'provCode' => '76100000',
                'provDesc' => 'SIQUIJOR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 =>
            array (
                'id' => 72,
                'provCode' => '56200000',
                'provDesc' => 'SORSOGON',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 =>
            array (
                'id' => 73,
                'provCode' => '126300000',
                'provDesc' => 'SOUTH COTABATO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 =>
            array (
                'id' => 74,
                'provCode' => '86400000',
                'provDesc' => 'SOUTHERN LEYTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 =>
            array (
                'id' => 75,
                'provCode' => '126500000',
                'provDesc' => 'SULTAN KUDARAT',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 =>
            array (
                'id' => 76,
                'provCode' => '156600000',
                'provDesc' => 'SULU',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 =>
            array (
                'id' => 77,
                'provCode' => '166700000',
                'provDesc' => 'SURIGAO DEL NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 =>
            array (
                'id' => 78,
                'provCode' => '166800000',
                'provDesc' => 'SURIGAO DEL SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 =>
            array (
                'id' => 79,
                'provCode' => '36900000',
                'provDesc' => 'TARLAC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 =>
            array (
                'id' => 80,
                'provCode' => '157000000',
                'provDesc' => 'TAWI-TAWI',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 =>
            array (
                'id' => 81,
                'provCode' => '37100000',
                'provDesc' => 'ZAMBALES',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 =>
            array (
                'id' => 82,
                'provCode' => '97200000',
                'provDesc' => 'ZAMBOANGA DEL NORTE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 =>
            array (
                'id' => 83,
                'provCode' => '97300000',
                'provDesc' => 'ZAMBOANGA DEL SUR',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 =>
            array (
                'id' => 84,
                'provCode' => '98300000',
                'provDesc' => 'ZAMBOANGA SIBUGAY',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
