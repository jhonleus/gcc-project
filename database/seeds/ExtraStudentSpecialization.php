<?php

use Illuminate\Database\Seeder;

class ExtraStudentSpecialization extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extra_students_specialization')->truncate();

        $extra_students_specialization = [
            ['name' => 'Chemistry Department'],
            ['name' => 'Communication Department'],
        ];

        DB::table('extra_students_specialization')->insert($extra_students_specialization);
    }
}
