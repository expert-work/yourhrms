<?php

namespace Database\Seeders;

use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Models\Role\Role;
use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use App\Models\Hrm\Department\Department;
use App\Models\Hrm\Designation\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            'MD',
            'CEO',
            'CIO',
            'HR Manager',
            'IT Manager',
            'Marketing Manager',
            'Sales Manager',
            'Accounts Manager',
            'Finance Manager',
            'Team Lead',
            'Customer Service Executive (CSR)',
            'Production Approval Analyst',
            'Designer',
            'Project Manager',
            'Web Developer',
            'Sr. Web Developer',
            'Mobile Application Developer',
            'UI UX Designer',
            'Software Quality Assurance (SQA)',
            'Inventory Control Executive',
            'Business Operation Officer',
            'Social Communication Executive',
            'Marketing Executive',
            'Production Manager', 
            'Digital Marketing Executive',
            'Vendor Executive',
            'Business Analyst',
            'Content Writer',
            'PR & Media Branding Manager',
        ];
        $companies = Company::all();
        foreach ($companies as $company) {
            foreach ($designations as $designation) {
                $s = new Designation();
                $s->company_id = $company->id;
                $s->title = $designation;
                $s->status_id =    1;
                $s->save();
            }
        }
        $departments = [
            'Management',
            'HR',
            'IT',
            'Marketing',
            'Sales',
            'Accounts',
            'Finance',
            'Admin',
            'Customer Service',
            'Approval',
            'Graphics & Arts',
            'Inverntory',
            'Business',
            'Content Writer',
            'Manager'
        ];
        foreach ($companies as $company) {
            foreach ($departments as $department) {
                $s = new Department();
                $s->company_id = $company->id;
                $s->title = $department;
                $s->status_id =    1;
                $s->save();
            }
        }
    }
}
