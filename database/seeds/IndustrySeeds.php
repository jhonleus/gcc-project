<?php

use Illuminate\Database\Seeder;

class IndustrySeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_industries')->truncate();

        $extra_industries = [
            ['name' => 'Accounting / Tax Services'],
            ['name' => 'Advertising / Marketing / PR'],
            ['name' => 'Agriculture / Poultry / Fisheries'],
            ['name' => 'Apparel'],
            ['name' => 'Architecture / Interior Design'],
            ['name' => 'Arts / Design / Fashion'],
            ['name' => 'Automobile / Automotive'],
            ['name' => 'Aviation / Airline'],
            ['name' => 'Banking / Finance'],
            ['name' => 'Beauty / Fitness'],
            ['name' => 'BioTech / Pharmaceutical'],
            ['name' => 'Business / Management Consulting'],
            ['name' => 'Call Center / BPO'],
            ['name' => 'Chemical / Fertilizers'],
            ['name' => 'Construction / Building'],
            ['name' => 'Consumer Products / FMCG'],
            ['name' => 'Education'],
            ['name' => 'Electrical & Electronics'],
            ['name' => 'Engineering / Technical Consulting'],
            ['name' => 'Entertainment / Media'],
            ['name' => 'Environment / Health / Safety'],
            ['name' => 'Exhibitions / Event Management'],
            ['name' => 'Food & Beverage'],
            ['name' => 'General & Wholesale Trading'],
            ['name' => 'Government / Defence'],
            ['name' => 'Healthcare / Medical'],
            ['name' => 'Heavy Industrial / Machinery'],
            ['name' => 'Hotel / Hospitality'],
            ['name' => 'HR Management / Consulting'],
            ['name' => 'Insurance'],
            ['name' => 'IT / Hardware'],
            ['name' => 'IT / Software'],
            ['name' => 'Journalism'],
            ['name' => 'Law / Legal'],
            ['name' => 'Library / Museum'],
            ['name' => 'Manufacturing / Production'],
            ['name' => 'Marine / Aquaculture'],
            ['name' => 'Mining'],
            ['name' => 'Oil / Gas / Petroleum'],
            ['name' => 'Polymer / Rubber'],
            ['name' => 'Printing / Publishing'],
            ['name' => 'Property / Real Estate'],
            ['name' => 'R&D'],
            ['name' => 'Repair / Maintenance'],
            ['name' => 'Retail / Merchandise'],
            ['name' => 'Science & Technology'],
            ['name' => 'Security / Law Enforcement'],
            ['name' => 'Semiconductor'],
            ['name' => 'Social Services / NGO'],
            ['name' => 'Sports'],
            ['name' => 'Stockbroking / Securities'],
            ['name' => 'Telecommunication'],
            ['name' => 'Textiles / Garment'],
            ['name' => 'Tobacco'],
            ['name' => 'Transportation / Logistics'],
            ['name' => 'Travel / Tourism'],
            ['name' => 'Utilities / Power'],
            ['name' => 'Wood / Fibre / Paper'],
        ];

        DB::table('extra_industries')->insert($extra_industries);
    }
}
