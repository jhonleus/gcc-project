<?php

use Illuminate\Database\Seeder;

class HobbySeeds extends Seeder
{

    public function run()
    {
        DB::table('extra_hobbies')->truncate();

        $extra_hobbies = [
            ['name' => 'Reading'],
            ['name' => 'Watching TV'],
            ['name' => 'Family Time'],
            ['name' => 'Going to Movies'],
            ['name' => 'Fishing'],
            ['name' => 'Computer'],
            ['name' => 'Gardening'],
            ['name' => 'Renting Movies'],
            ['name' => 'Walking'],
            ['name' => 'Exercise'],
            ['name' => 'Listening to Music'],
            ['name' => 'Entertaining'],
            ['name' => 'Hunting'],
            ['name' => 'Team Sports'],
            ['name' => 'Shopping'],
            ['name' => 'Traveling'],
            ['name' => 'Sleeping'],
            ['name' => 'Socializing'],
            ['name' => 'Sewing'],
            ['name' => 'Golf'],
            ['name' => 'Church Activities'],
            ['name' => 'Relaxing'],
            ['name' => 'Playing Music'],
            ['name' => 'Housework'],
            ['name' => 'Crafts'],
            ['name' => 'Watching Sports'],
            ['name' => 'Bicycling'],
            ['name' => 'Playing Cards'],
            ['name' => 'Hiking'],
            ['name' => 'Cooking'],
            ['name' => 'Eating Out'],
            ['name' => 'Dating Online'],
            ['name' => 'Swimming'],
            ['name' => 'Camping'],
            ['name' => 'Skiing'],
            ['name' => 'Working on Cars'],
            ['name' => 'Writing'],
            ['name' => 'Boating'],
            ['name' => 'Motorcycling'],
            ['name' => 'Animal Care'],
            ['name' => 'Bowling'],
            ['name' => 'Painting'],
            ['name' => 'Running'],
            ['name' => 'Dancing'],
            ['name' => 'Horseback Riding'],
            ['name' => 'Tennis'],
            ['name' => 'Theater'],
            ['name' => 'Billiards'],
            ['name' => 'Beach'],
            ['name' => 'Volunteer Work'],
        ];

        DB::table('extra_hobbies')->insert($extra_hobbies);
    }
}
