<?php

use Illuminate\Database\Seeder;

class PagecontentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pagecontents')->truncate();

        $pagecontents = [
            ['head' => 'gcc-img-10-01.jpg',
            'picture1' => 'gcc-img-7.jpg',
            'picture2' => 'gcc-img-7.jpg',
            'login' => 'gcc-img-4.png',
            'register' => 'gcc-img-4.png',
            'feedback' => 'gcc-img-13.jpg',
            'contact' => 'gcc-img-14.jpg'],
        ];

        DB::table('pagecontents')->insert($pagecontents);
    }
}
