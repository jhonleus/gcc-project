<?php

use Illuminate\Database\Seeder;

class GenderSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_genders')->truncate();

        $extra_genders = [
            ['name' => 'Male'],
            ['name' => 'Female'],
        ];

        DB::table('extra_genders')->insert($extra_genders);
    }
}
