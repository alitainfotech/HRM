<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openings', function (Blueprint $table) {
            $table->id();
            $table->string('title',60);
            $table->text('description');
            $table->integer('number_openings');
            $table->text('image');
            $table->string('min_experience',200)->nullable()->comment("in months");
            $table->string('max_experience',200)->nullable()->comment("in months");
            $table->boolean('fresher')->comment("0=false,1=true");
            $table->boolean('status')->default(1)->comment("0=delete,1=active,2=inactive");
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
        Schema::dropIfExists('openings');
    }
}
