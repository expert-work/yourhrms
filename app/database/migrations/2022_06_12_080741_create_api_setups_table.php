<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_setups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->nullable();
            $table->string('secret')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('docs_url')->nullable();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses');

            $table->timestamps();
        });

        // $companies= DB::table('companies')->get();
        // $apis=[
        //     'google','barikoi'
        // ];
        // foreach ($companies as $key => $company) {
        //     foreach ($apis as $key => $api) {
        //         DB::table('api_setups')->insert([
        //             'name' => $api,
        //             'company_id' => $company->id,
        //             'status_id' => 1,
        //         ]);
        //     }
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_setups');
    }
}
