<?php

use Illuminate\Database\Seeder;

class AboutSeeds extends Seeder
{
    public function run()
    {
        DB::table('maintenance_abouts')->truncate();

        $maintenance_abouts = [
            ['id' => '1', 'picture' => 'gcc-img-6.jpg'],
            ['id' => '2', 'picture' => 'gcc-img-7.jpg'],
        ];

        DB::table('maintenance_abouts')->insert($maintenance_abouts);
    }
}
