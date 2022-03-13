<?php

use Illuminate\Database\Seeder;

class EmailSeeds extends Seeder
{
    public function run()
    {
        DB::table('maintenance_templates')->truncate();

        $maintenance_templates = [
            ['id' => '1', 'role' => 'application-approve', 'subject' => 'Application Approved in [application_name]', 'message' => 'You have been approved to [application_name]'],
            ['id' => '2', 'role' => 'application-reject', 'subject' => 'Application Rejected in [application_name]', 'message' => 'You have been rejected to [application_name]'],
        ];

        DB::table('maintenance_templates')->insert($maintenance_templates);
    }
}
