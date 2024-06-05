<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPresenceStatusToWeeklyCLassTable extends Migration
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
            $table->boolean('teacher_presence')->nullable()->default(false);
            $table->boolean('student_presence')->nullable()->default(false);
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
            $table->dropColumn('teacher_presence');
            $table->dropColumn('student_presence');

        });
    }
}
