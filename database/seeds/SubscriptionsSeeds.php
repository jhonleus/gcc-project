<?php

use Illuminate\Database\Seeder;

class SubscriptionsSeeds extends Seeder
{
    public function run()
    {
        DB::table('maintenance_subscriptions')->truncate();

        $maintenance_subscriptions = [
            [
                'title' => 'Free',
                'plan_name' => 'free',
                 'price' => '0',
                  'limit' => '1',
                  'expiration' => '10',
                  'check_limit' => '0',
                  'check_applicant' => '0',
                  'check_profile' => '0',
                  'check_reserve' => '0',
                  'check_technical' => '0',
                  'check_email' => '0',],

            ['title' => 'Gold',
            'plan_name' => 'gold',
             'price' => '12',
             'limit' => '10',
             'expiration' => '30',
             'check_limit' => '0',
             'check_applicant' => '0',
             'check_profile' => '0',
             'check_reserve' => '1',
             'check_technical' => '1',
             'check_email' => '1',],

            ['title' => 'Platinum',
            'plan_name' => 'platinum',
             'price' => '20',
             'limit' => '999',
             'expiration' => '60',
             'check_limit' => '1',
             'check_applicant' => '1',
             'check_profile' => '1',
             'check_reserve' => '1',
             'check_technical' => '1',
             'check_email' => '1',],

        
        ];

        DB::table('maintenance_subscriptions')->insert($maintenance_subscriptions);
    }
}
