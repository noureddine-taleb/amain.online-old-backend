<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('alerts', function (Blueprint $table) {
        //     $table->Increments('id');
        //     $table->unsignedInteger('project_id'); 
        //         $table->foreign('project_id')->references('id')->on('projects');
        //     $table->unsignedInteger('frequency_id')->default(1);
        //         $table->foreign('frequency_id')->references('id')->on('frequencies');
        //     $table->unsignedInteger('priority');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
