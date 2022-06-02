<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('c_id');
            $table->foreign('c_id')->references('id')->on('users');
            $table->unsignedBigInteger('o_id');
            $table->unique(['o_id', 'c_id']);
            $table->foreign('o_id')->references('id')->on('openings');
            $table->string('cv',250);
            $table->string('experience',100);
            $table->text('description');
            $table->boolean('status')->default(0)->comment("0=pending,1=review,2=selected,3=rejected");
            $table->text('reason')->nullable();
            $table->boolean('app_status')->default(1)->comment("0=delete,1=active");
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
        Schema::dropIfExists('applications');
    }
}
