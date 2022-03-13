<?php

use Illuminate\Database\Seeder;

class BankDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('maintenance_bankdetails')->truncate();

        $maintenance_bankdetails = [
            ['account_number' => '324234234',
            'account_name' => 'Admin name',
            'expiration' => '2020-11-03',
            'cvv' => '123'],
        ];
        DB::table('maintenance_bankdetails')->insert($maintenance_bankdetails);
    }
}
