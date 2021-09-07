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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('pf')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position');
            $table->integer('department_id')->default(0);
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('type');
            $table->boolean('active')->default(true);
            $table->string('password');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('about')->nullable();
            $table->string('picture')->nullable();
            $table->date('dob')->nullable();
            $table->string('created_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
