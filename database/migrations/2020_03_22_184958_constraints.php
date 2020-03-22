<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Constraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared('
        // CREATE OR REPLACE TRIGGER tr_user_delete INSTEAD OF DELETE ON `users` FOR EACH ROW
        //     BEGIN
        //         ROLLBACK;
        //         UPDATE `users` SET `status` = 0 WHERE `id` = OLD.id ;
        //     END
        // ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER IF EXISTS `tr_user_delete`');
    }
}
