<?php

use App\Models\Traits\StatusTrait;
use Illuminate\Support\Facades\Schema;
use App\Models\coreApp\Status\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrmVersionUpdateToV34 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add New Status to table
        $statuses = StatusTrait::allStatus();
        foreach ($statuses as $status) {
            $exist=Status::where('name',$status['name'])->first();
            if (!$exist) {
                Status::create([
                    'name' => $status['name'],
                    'class' => $status['class'],
                    'color_code' => $status['color_code'],
                ]);
            }
        }

        // Database Update for v3.4
        Schema::table('location_binds', function ($table) {
            if (!Schema::hasColumn('location_binds', 'is_office')) {
                // $table->int('is_office')->default(33);
                $table->foreignId('is_office')->index('is_office')->default(33)->constrained('statuses')->cascadeOnDelete()->comment('33=Yes,22=No');
            }
        });
        
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
