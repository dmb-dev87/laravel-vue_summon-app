<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Location::firstOrCreate([
            'user_id' => 1,
            'name' => '1st Floot meeting rooms'
        ]);
        Location::firstOrCreate([
            'user_id' => 1,
            'name' => 'Main office'
        ]);
        Location::firstOrCreate([
            'user_id' => 1,
            'name' => 'CE office'
        ]);
        Location::firstOrCreate([
            'user_id' => 1,
            'name' => 'IT senior Manager office'
        ]);

    }
}
