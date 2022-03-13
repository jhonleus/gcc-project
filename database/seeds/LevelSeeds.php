<?php

use Illuminate\Database\Seeder;

class LevelSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_levels')->truncate();

        $extra_levels = [
            ['name' => 'High School Diploma'],
            ['name' => 'Vocational Diploma'],
            ['name' => "Bachelor's / College Degree"],
            ['name' => "Post Graduate Diploma / Master's Degree"],
            ['name' => 'Professional License'],
            ['name' => 'Doctorate Degree'],
        ];

        DB::table('extra_levels')->insert($extra_levels);
    }
}
