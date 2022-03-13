<?php

use Illuminate\Database\Seeder;

class RoleSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_roles')->truncate();

        $extra_roles = [
            ['id' => '0', 'name' => 'Admin', 'prefix' => 'admin'],
            ['id' => '1', 'name' => 'Applicant', 'prefix' => 'applicant'],
            ['id' => '2', 'name' => 'Accepting Organization/Company', 'prefix' => 'employer'],
            ['id' => '3', 'name' => 'Sending Organization', 'prefix' => 'organization'],
            ['id' => '4', 'name' => 'School', 'prefix' => 'school'],
            ['id' => '5', 'name' => 'Student', 'prefix' => 'student'],
            ['id' => '6', 'name' => 'Research Support Organization', 'prefix' => 'student'],
        ];

        DB::table('extra_roles')->insert($extra_roles);
    }
}
