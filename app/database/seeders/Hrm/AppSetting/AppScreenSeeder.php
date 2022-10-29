<?php

namespace Database\Seeders\Hrm\AppSetting;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Hrm\AppSetting\AppScreen;

class AppScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            'support', 'attendance', 'notice', 'expense', 'leave', 'approval', 'phonebook', 'visit', 'appointments', 'break','report','meeting' 
        ];
        foreach ($menus as $key => $menu) {
            $iconName = $menu . '.svg';
            $app_menu = AppScreen::where('slug', $menu)->first();
            if (!$app_menu) {
                AppScreen::create([
                    'name' => ucfirst($menu),
                    'slug' => Str::slug($menu),
                    'position' => $key + 1,
                    'icon' => "public/uploads/appSettings/icon/{$iconName}",
                    'status_id' => 1
                ]);
            }
        }
    }
}
