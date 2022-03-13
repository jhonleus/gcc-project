<?php

use Illuminate\Database\Seeder;

class PositionSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_positions')->truncate();

        $extra_positions = [
            ['name' => 'CEO/SVP/AVP/VP/Director'],
            ['name' => 'Assistant Manager/Manager'],
            ['name' => 'Supervisor/5 Yrs & Up Experienced Employee'],
            ['name' => '1-4 Yrs Experienced Employee'],
            ['name' => 'Less than 1 year experience'],
        ];

        DB::table('extra_positions')->insert($extra_positions);
    }
}
