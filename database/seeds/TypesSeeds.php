<?php

use Illuminate\Database\Seeder;

class TypesSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maintenance_type')->truncate();

        $name = [
            [   'id'            => '1', 
                'name'  		=> 'Sending Organization', 
                'roleId'        => '3', 
                'isAll'         => '0',  
                'allowDelete'   => '0'
            ],

            [
                'id'          	=> '2', 
                'name' 			=> 'Accepting Organization', 
                'roleId'     	=> '3', 
                'isAll'       	=> '1',  
                'allowDelete' 	=> '0'
            ],

            [
                'id'           	=> '3', 
                'name'  		=> 'Register Support Organization', 
                'roleId'       	=> '3', 
                'isAll'        	=> '1',
                'allowDelete'  	=> '0'
            ],

            [
                'id'           	=> '4', 
                'name'  		=> 'Accepting Company', 
                'roleId'       	=> '2', 
                'isAll'        	=> '1',  
                'allowDelete'  	=> '0'
            ],

            [
                'id'          	=> '5', 
                'name'  		=> 'Local Company', 
                'roleId'      	=> '2', 
                'isAll'       	=> '0',  
                'allowDelete' 	=> '0'
            ],

            [
                'id'           	=> '6', 
                'name'  		=> 'Japanese Language School', 
                'roleId'       	=> '4', 
                'isAll'        	=> '1', 
                'allowDelete'  	=> '0'
            ],

            [
                'id'           	=> '7', 
                'name'  		=> 'University', 
                'roleId'       	=> '4', 
                'isAll'        	=> '1',  
                'allowDelete'  	=> '0'
            ],

            [
                'id'            => '8', 
                'name'	 		=> 'Skill Training Center', 
                'roleId'        => '4', 
                'isAll'         => '1', 
                'allowDelete'   => '0'
            ],

            [
                'id'            => '9', 
                'name'          => 'TITP', 
                'roleId'        => '1', 
                'isAll'         => '0', 
                'allowDelete'   => '0'
            ],

            [
                'id'            => '10', 
                'name'          => 'Skill Worker', 
                'roleId'        => '1', 
                'isAll'         => '0', 
                'allowDelete'   => '0'
            ],
        ];

        DB::table('maintenance_type')->insert($name);
    }
}
