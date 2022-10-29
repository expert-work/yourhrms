<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_setups', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('ip_address');
            $table->foreignId('status_id')->default(1)->constrained('statuses');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('is_office')->index('is_office')->default(33)->constrained('statuses')->comment('33=Yes,22=No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_setups');
    }
}
