<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('pf')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('project_id')->nullable();
            $table->foreign('project_id')->references('job')->on('projects')->onUpdate('cascade');
            $table->date('set_date');
            $table->string('description');
            $table->string('remark');
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
        Schema::dropIfExists('actions');
    }
}
