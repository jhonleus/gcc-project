<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PagecontentsTableSeeder::class,
            CivilSeeds::class,
            CountryTableSeeds::class,
            GenderSeeds::class,
            ReligionSeeds::class,
            LevelSeeds::class,
            HobbySeeds::class,
            CurrencySeeds::class,
            RoleSeeds::class,
            EmploymentSeeds::class,
            PositionSeeds::class,
            SpecializationSeeds::class,
            SubscriptionsSeeds::class,
            CompanyLogoTableSeeder::class,
            CustomerServiceSupportSeeder::class,
            IndustrySeeds::class,
            AboutSeeds::class,
			LocaleSeeds::class,
            ExtraStudentSpecialization::class,
            ExtraStudentType::class,
            EmailSeeds::class,
            TypesSeeds::class,
            BankSeeds::class,
        ]);
    }

}
