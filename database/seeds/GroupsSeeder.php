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
            'name' => 'IT Department'
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Sales Team'
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Management Team'
        ]);
        Group::firstOrCreate([        
            'user_id' => 1,
            'name' => 'Broadcast'
        ]);
    }
}
