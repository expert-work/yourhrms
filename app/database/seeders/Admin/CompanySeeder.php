<?php

namespace Database\Seeders\Admin;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // superadmin/administrator
        Company::create([
            'country_id' => 17, // Bangladesh
            'name' => 'Super Admin',
            'company_name' => 'Company1',
            'email' => 'superadmin@demo.com',
            'phone' => '+8801910077628',
            'total_employee' => 10,
            'business_type' => 'Service',
            'is_main_company' => 'yes',
        ]);

        // company user
        Company::create([
            'country_id' => 17, // United States
            'name' => 'Admin',
            'company_name' => 'Admin',
            'email' => 'admin@onesttech.com',
            'phone' => '+880177777777',
            'total_employee' => 400,
            'business_type' => 'Service',
            'is_main_company' => 'no',
        ]);

        // company user
        // Company::create([
        //     'country_id' => 17, //  Bangladesh
        //     'name' => 'Company2',
        //     'company_name' => 'Company2 Ltd',
        //     'email' => 'admin@company2.com',
        //     'phone' => '+8809638111333',
        //     'total_employee' => 60,
        //     'business_type' => 'Service',
        //     'is_main_company' => 'no',
        // ]);

    }
}
