<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionsToTrialClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            //
            $table->string('zoom_link')->nullable()->change();
            $table->boolean('teacher_presence')->nullable()->default(false);
            $table->boolean('student_presence')->nullable()->default(false);
            $table->string('class_duration', 10)->nullable()->default('00:00:00');
            $table->string('Session_Id', 50)->nullable()->unique();
            $table->uuid('session_key')->nullable()->unique();
            $table->string('student_status')->default(\App\Classes\Enums\StatusEnum::SCHEDULED);
            $table->string('teacher_status')->default(\App\Classes\Enums\StatusEnum::SCHEDULED);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trial_classes', function (Blueprint $table) {
            //
    
            $table->dropColumn('class_duration');
            $table->dropColumn('teacher_presence');
            $table->dropColumn('student_presence');
            $table->dropColumn('Session_Id');
            $table->dropColumn('session_key');
            $table->dropColumn('student_status');
            $table->dropColumn('teacher_status');
        });
    }
}
