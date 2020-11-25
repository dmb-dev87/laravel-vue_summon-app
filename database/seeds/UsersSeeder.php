<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->addUser('johny_01', 'John Steve', 'john1@admin.com', 'john2@admin.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'Admin', 'Activate');
        $this->addUser('chris_01', 'Chris Steve', 'chris1@admin.com', 'chris2@admin.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'User', 'Activate');
        $this->addUser('demodulation463', 'Rubi Ortwein', 'rubi@ortwein.com', 'rubi2@ortwein.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'User', 'Activate');
        $this->addUser('undivorced341', 'Donnette Charania', 'donnette@charania.com', 'donnette2@charania.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'User', 'Deactivate');
        $this->addUser('bumbo426', 'Ardith Duffett', 'ardith@duffett.com', 'ardith2@duffett.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'User', 'Activate');
        $this->addUser('ectodactylism214', 'Antone Berman', 'antone@berman.com', 'antone2@berman.com', '1111111111', '2222222222', '33333333333', bcrypt('dev1121!'), 'User', 'Deactivate');
    }

    public function addUser(string $user_name, string $name, string $email, string $email2, string $phone1, string $phone2, string $phone3, string $password, string $role, string $status)
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'user_name' => $user_name,
                'name' => $name,
                'email2' => $email2,
                'phone_number1' => $phone1,
                'phone_number2' => $phone2,
                'phone_number3' => $phone3,
                'password' => $password,
                'role_name' => $role,
                'status' => $status,
            ]
        );

        return $user;
    }

}
