<?php

use Illuminate\Database\Seeder;

class BankSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_banks')->truncate();

        $extra_banks = [
            ['bank' => 'BDO', 'number' => '1234123412341234', 'name' => 'Sample A'],
            ['bank' => 'BPI', 'number' => '1234123412341234', 'name' => 'Sample B'],
        ];

        DB::table('extra_banks')->insert($extra_banks);
    }
}
