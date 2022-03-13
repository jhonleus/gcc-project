<?php

use Illuminate\Database\Seeder;

class CurrencySeeds extends Seeder
{

    public function run()
    {
        DB::table('extra_currencies')->truncate();

        $extra_currencies = [
            ['name' => 'MYR'],
            ['name' => 'SGD'],
            ['name' => 'PHP'],
            ['name' => 'USD'],
            ['name' => 'INR'],
            ['name' => 'AUD'],
            ['name' => 'IDR'],
            ['name' => 'THB'],
            ['name' => 'HKD'],
            ['name' => 'EUR'],
            ['name' => 'CNY'],
            ['name' => 'JPY'],
            ['name' => 'GBP'],
            ['name' => 'VND'],
            ['name' => 'BDT'],
            ['name' => 'NZD'],
        ];

        DB::table('extra_currencies')->insert($extra_currencies);
    }
}
