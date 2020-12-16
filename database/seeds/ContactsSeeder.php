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
            'name' => 'Chris Steve',
            'email'=>'chris1@admin.com',
            'email2' => 'chris2@admin.com',
            'phone_number1' => '+13152150723',
            'phone_number2' => '+2222222222',
            'phone_number3' => '+3333333333',
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'name' => 'Donnette Charania',
            'email'=>'donnette@charania.com',
            'email2' => 'donnette2@charania.com',
            'phone_number1' => '+1111111111',
            'phone_number2' => '+2222222222',
            'phone_number3' => '+3333333333',
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'name' => 'Rubi Ortwein',
            'email'=>'rubi@ortwein.com',
            'email2' => 'rubi2@ortwein.com',
            'phone_number1' => '+1111111111',
            'phone_number2' => '+2222222222',
            'phone_number3' => '+3333333333',
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'name' => 'Ardith Duffett',
            'email'=>'ardith@duffett.com',
            'email2' => 'ardith2@duffett.com',
            'phone_number1' => '+1111111111',
            'phone_number2' => '+2222222222',
            'phone_number3' => '+3333333333',
        ]);

        Contact::firstOrCreate([
            'user_id' => 1,
            'name' => 'Antone Berman',
            'email'=>'antone@berman.com',
            'email2' => 'antone2@berman.com',
            'phone_number1' => '+1111111111',
            'phone_number2' => '+2222222222',
            'phone_number3' => '+3333333333',
        ]);
    }
}
