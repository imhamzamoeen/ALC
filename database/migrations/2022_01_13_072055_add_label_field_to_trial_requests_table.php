<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelFieldToTrialRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_requests', function (Blueprint $table) {
            $table->text('reason')->nullable()->after('status');
            $table->string('label')->nullable()->after('status');
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
            $table->dropColumn('label');
            $table->dropColumn('reason');
        });
    }
}
