<?php

use Illuminate\Database\Seeder;

class ReligionSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_religions')->truncate();

        $extra_religions = [
            ['name' => 'Christianity'],
            ['name' => 'Islam'],
            ['name' => 'Nonreligious'],
            ['name' => 'Hinduism'],
            ['name' => 'Chinese traditional religion'],
            ['name' => 'Buddhism '],
            ['name' => 'Others'],
        ];

        DB::table('extra_religions')->insert($extra_religions);
    }
}
