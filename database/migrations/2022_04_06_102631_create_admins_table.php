<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('full_name',60);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('dob',50)->nullable();
            $table->string('phone')->nullable();
            $table->string('designation',250)->nullable();
            $table->unsignedBigInteger('d_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->text('bio')->nullable();
            $table->text('address')->nullable();
            $table->string('image',250)->nullable();
            $table->tinyInteger('status')->default('1')->comment('0=>Delete ,1=>Active');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
