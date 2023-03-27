<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveUniqueFromApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
              DB::statement("ALTER TABLE applications DROP FOREIGN KEY applications_o_id_foreign");
              DB::statement("ALTER TABLE applications DROP KEY applications_o_id_c_id_unique");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            DB::statement("ALTER TABLE applications DROP FOREIGN KEY applications_o_id_foreign");
            DB::statement("ALTER TABLE applications DROP KEY applications_o_id_c_id_unique");
        });
    }
}