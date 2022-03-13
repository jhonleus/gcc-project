<?php

use Illuminate\Database\Seeder;

class CustomerServiceSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('customerservicesupports')->truncate();

        $customerservicesupports = [
            ['email' => 'test.gcc000@gmail.com',
            'password' => '123456',
            'address' => 'qewrerer',
            'password' => '1234_qwer',
            'phone' => '234324555',
            'telephone' => '234234555'],
        ];
        DB::table('customerservicesupports')->insert($customerservicesupports);
    }
}
