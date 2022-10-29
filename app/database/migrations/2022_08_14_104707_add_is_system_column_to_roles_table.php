<?php

use App\Models\Role\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSystemColumnToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'is_system')) {
                $table->boolean('is_system')->nullable()->default(0);
            }
        });
        $roles=Role::withoutGlobalScopes()->get();
        $system_slugs=['admin','hr','staff'];
        foreach($roles as $single_role){
            if (in_array($single_role->slug, $system_slugs)) {
                $single_role->is_system=1;
            }else{
                $single_role->is_system=0;
            }
            $single_role->save();
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
