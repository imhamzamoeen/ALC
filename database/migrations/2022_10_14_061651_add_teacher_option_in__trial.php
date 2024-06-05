<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherOptionInTrial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_requests', function (Blueprint $table) {
            //
            $table->enum('teacher_preference', ['male', 'female', 'any'])->default('any');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trial_requests', function (Blueprint $table) {
            //
            $table->dropColumn('teacher_preference');
        });
    }
}
