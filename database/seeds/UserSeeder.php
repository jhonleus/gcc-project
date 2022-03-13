<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('users')->truncate();

        $users = [
            ['id' => '0', 'firstName' => 'jayvin', 'lastName' => 'jayvin', 'username' => 'jayvin', 'email' => 'jc.muring@mobixsystemsinc.com', 'password' => '123456'],
        ];

        DB::table('users')->insert($users);
    }
}
