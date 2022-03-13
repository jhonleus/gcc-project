<?php

use Illuminate\Database\Seeder;

class EmploymentSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_employments')->truncate();

        $extra_employments = [
            ['name' => 'Full Time'],
            ['name' => 'Part Time'],
            ['name' => 'Internship'],
            ['name' => 'Contract'],
            ['name' => 'Temporary'],
        ];

        DB::table('extra_employments')->insert($extra_employments);
    }
}
