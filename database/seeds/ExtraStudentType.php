<?php

use Illuminate\Database\Seeder;

class ExtraStudentType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extra_students_type')->truncate();

        $extra_students_type = [
            ['name' => 'Transferee'],
            ['name' => 'New Student'],
        ];

        DB::table('extra_students_type')->insert($extra_students_type);
    }
}
