<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnClassDuratoin extends Migration
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
            $table->renameColumn('class_duratoin', 'class_duration');
       
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
            $table->renameColumn('class_duration', 'class_duratoin');
        });
    }
}
