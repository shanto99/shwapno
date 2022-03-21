<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserManager', function (Blueprint $table) {
            $table->string('UserID')->primary();
            $table->string('UserName')->unique();
            $table->string('Email')->unique()->default('');
            $table->string('Phone')->unique()->default('');
            $table->string('UserType')->default('');
            $table->string('UserNID')->nullable();
            $table->string('UserLicense')->nullable();
            $table->string('Password');
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
        Schema::dropIfExists('users');
    }
}
