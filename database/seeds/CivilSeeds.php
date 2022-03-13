<?php

use Illuminate\Database\Seeder;

class CivilSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_civils')->truncate();

        $extra_civils = [
            ['name' => 'Single'],
            ['name' => 'Married'],
            ['name' => 'Divorced'],
            ['name' => 'Separated'],
            ['name' => 'Widowed'],
        ];

        DB::table('extra_civils')->insert($extra_civils);
    }
}
