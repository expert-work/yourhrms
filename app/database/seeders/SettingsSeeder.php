<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use App\Models\coreApp\Setting\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'company_name',
            'company_logo_backend',
            'company_logo_frontend',
            'company_icon',
            'android_url',
            'ios_url',
            'language',
            'emailSettingsProvider',
            'emailSettings_from_name',
            'emailSettings_from_email',
            'site_under_maintenance'
        ];
        $values = [
            'HRM',
            'public/uploads/settings/logo/logo_white.png',
            'public/uploads/settings/logo/logo_black.png',
            'public/uploads/settings/logo/favicon.png',
            'https://play.google.com/store/apps/details?id=com.worx24hour.hrm',
            'https://apps.apple.com/us/app/24hourworx/id1620313188',
            'en',
            'smtp',
            'hrm@onest.com',
            'hrm@onest.com',
            '0'
        ];
        foreach ($array as $key => $item) {
            Setting::create([
                'name' => $item,
                'value' => $values[$key],
                'context' => 'app',
                'company_id' => 1,
            ]);
        }
    }
}
