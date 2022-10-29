<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Models\Hrm\AppSetting\AppScreen;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMeetingToAppScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $menus = [
            'Meeting','Video Conference' 
        ];
        foreach ($menus as $key => $menu) {
            $iconName = $menu . '.svg';
            $app_menu = AppScreen::where('slug', Str::slug($menu))->first();
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
