<?php

use Illuminate\Database\Seeder;
use App\Contact;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::firstOrCreate([
            'user_id' => 1,
            'contact_user_id' => 2,
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'contact_user_id' => 3,
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'contact_user_id' => 4,
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'contact_user_id' => 5,
        ]);
    }
}
