<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedFieldToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
        Schema::table('shared_libraries', function (Blueprint $table) {
            $table->integer('is_locked')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('shared_libraries', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
    }
}
