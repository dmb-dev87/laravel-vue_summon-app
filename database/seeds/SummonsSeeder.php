<?php

use Illuminate\Database\Seeder;

use App\Summon;

class SummonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Summon::firstOrCreate([        
            'user_id' => 1,
            'location_id' => 1,
            'group_list' => '1,2',
            'contact_list' => '1,4,6',
            'message' => 'We have meeting today',
        ]);
        Summon::firstOrCreate([        
            'user_id' => 1,
            'location_id' => 2,
            'group_list' => '3',
            'message' => 'Send me schedule today',
        ]);
        Summon::firstOrCreate([        
            'user_id' => 1,
            'location_id' => 3,
            'contact_list' => '2,3,5',
            'message' => 'I would like to have meeting today',
        ]);
    }
}
