<?php

use Illuminate\Database\Seeder;

class SpecializationSeeds extends Seeder
{
    public function run()
    {
        DB::table('extra_specializations')->truncate();

        $extra_specializations = [
            ['name' => 'Audit & Taxation Jobs '],
            ['name' => 'Banking/Financial Jobs'],
            ['name' => 'Corporate Finance/Investment Jobs'],
            ['name' => 'General/Cost Accounting Jobs'],
            ['name' => 'Clerical/Administrative Jobs'],
            ['name' => 'Human Resources Jobs'],
            ['name' => 'Secretarial Jobs'],
            ['name' => 'Top Management Jobs'],
            ['name' => 'Advertising Jobs'],
            ['name' => 'Arts/Creative Design Jobs'],
            ['name' => 'Entertainment Jobs'],
            ['name' => 'Public Relations Jobs'],
            ['name' => 'Architect/Interior Design Jobs'],
            ['name' => 'Civil Engineering/Construction Jobs'],
            ['name' => 'Property/Real Estate Jobs'],
            ['name' => 'Quantity Surveying Jobs'],
            ['name' => 'IT - Hardware Jobs'],
            ['name' => 'IT - Network/Sys/DB Admin Jobs'],
            ['name' => 'IT - Software Jobs'],
            ['name' => 'Education Jobs'],
            ['name' => 'Training & Dev. Jobs'],
            ['name' => 'Chemical Engineering Jobs'],
            ['name' => 'Electrical Engineering Jobs'],
            ['name' => 'Electronics Engineering Jobs'],
            ['name' => 'Environmental Engineering Jobs'],
            ['name' => 'Industrial Engineering Jobs'],
            ['name' => 'Mechanical/Automotive Engineering Jobs'],
            ['name' => 'Oil/Gas Engineering Jobs'],
            ['name' => 'Other Engineering Jobs'],
            ['name' => 'Doctor/Diagnosis Jobs'],
            ['name' => 'Pharmacy Jobs'],
            ['name' => 'Nurse/Medical Support Jobs'],
            ['name' => 'Food/Beverage/Restaurant Jobs'],
            ['name' => 'Hotel/Tourism Jobs'],
            ['name' => 'Maintenance Jobs'],
            ['name' => 'Manufacturing Jobs'],
            ['name' => 'Process Design & Control Jobs'],
            ['name' => 'Purchasing/Material Mgmt Jobs'],
            ['name' => 'Quality Assurance Jobs'],
            ['name' => 'General Work Jobs'],
            ['name' => 'Journalist/Editors Jobs'],
            ['name' => 'Publishing Jobs'],
            ['name' => 'Others Jobs'],
            ['name' => 'Digital Marketing Jobs'],
            ['name' => 'Sales - Corporate Jobs'],
            ['name' => 'E-commerce Jobs'],
            ['name' => 'Marketing/Business Dev Jobs'],
            ['name' => 'Merchandising Jobs'],
            ['name' => 'Retail Sales Jobs'],
            ['name' => 'Sales - Eng/Tech/IT Jobs'],
            ['name' => 'Sales - Financial Services Jobs'],
            ['name' => 'Telesales/Telemarketing Jobs'],
            ['name' => 'Actuarial/Statistics Jobs'],
            ['name' => 'Agriculture Jobs'],
            ['name' => 'Aviation Jobs'],
            ['name' => 'Biomedical Jobs'],
            ['name' => 'Biotechnology Jobs'],
            ['name' => 'Chemistry Jobs'],
            ['name' => 'Food Tech/Nutritionist Jobs'],
            ['name' => 'Geology/Geophysics Jobs'],
            ['name' => 'Science & Technology Jobs'],
            ['name' => 'Security/Armed Forces Jobs'],
            ['name' => 'Customer Service Jobs'],
            ['name' => 'Logistics/Supply Chain Jobs'],
            ['name' => 'Law/Legal Services Jobs'],
            ['name' => 'Personal Care Jobs'],
            ['name' => 'Social Services Jobs'],
            ['name' => 'Tech & Helpdesk Support Jobs'],
        ];

        DB::table('extra_specializations')->insert($extra_specializations);
    }
}
