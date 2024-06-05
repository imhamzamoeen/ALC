<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassDurationToWeeklyClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_classes', function (Blueprint $table) {
            //
            $table->string('class_duratoin', 10)->nullable()->default('00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weekly_classes', function (Blueprint $table) {
            //
            $table->dropColumn('class_duratoin');
        });
    }
}
