<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'IT Department',
            'contact_list' => '2,3,5',
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Sales Team',
            'contact_list' => '1,2,6',
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Management Team',
            'contact_list' => '1,4,6',
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Broadcast',
            'contact_list' => '1,3,5',
        ]);
    }
}
