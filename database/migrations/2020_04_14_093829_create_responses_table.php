<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->unique();
            $table->string('tag');
            $table->string('response');
            $table->timestamps();
        });

        DB::insert('insert into responses (status, tag, response) values (?, ?, ?)', [200, 'success', "done successfully"]);
        DB::insert('insert into responses (status, tag, response) values (?, ?, ?)', [201, 'created', "created successfully"]);
        DB::insert('insert into responses (status, tag, response) values (?, ?, ?)', [202, 'accepted', "accepted successfully"]);
        DB::insert('insert into responses (status, tag, response) values (?, ?, ?)', [207, 'delete', "deleted successfully"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
