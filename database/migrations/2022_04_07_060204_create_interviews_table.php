<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('a_id')->unique();
            $table->foreign('a_id')->references('id')->on('applications');
            $table->unsignedBigInteger('tl_id');
            $table->foreign('tl_id')->references('id')->on('admins');
            $table->dateTime('date');
            $table->boolean('status')->default(1)->comment("0=delete,1=active");
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
        Schema::dropIfExists('interviews');
    }
}
