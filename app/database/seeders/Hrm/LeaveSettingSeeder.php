<?php

namespace Database\Seeders\Hrm;

use App\Models\Hrm\Leave\LeaveSetting;
use Illuminate\Database\Seeder;

class LeaveSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveSetting::create([
            'sandwich_leave' => 0,
            'month' => 1,
            'prorate_leave' => 0,
            'company_id' => 1
        ]);

    }
}
