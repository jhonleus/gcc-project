<?php

use Illuminate\Database\Seeder;

class CompanyLogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('company_logo')->truncate();

        $company_logo = [
            ['photo_name' => 'global-career-creation-logo-01.png'],
        	];
        DB::table('company_logo')->insert($company_logo);
    }
}
