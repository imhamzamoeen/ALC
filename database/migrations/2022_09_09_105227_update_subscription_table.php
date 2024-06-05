<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {            
            $table->renameColumn('name', 'student_id');
            $table->string("payment_name");
            $table->string("payer_id");
            $table->renameColumn('stripe_id', 'payment_id');
            $table->renameColumn('stripe_status', 'payment_status');
            $table->renameColumn('stripe_price', 'price');
            $table->renameColumn('trial_ends_at', 'start_at');
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function($table) {
            $table->renameColumn('student_id', 'name');
            $table->dropColumn('payment_name');
            $table->dropColumn('payer_id');
            $table->renameColumn('payment_id', 'stripe_id');
            $table->renameColumn('payment_status', 'stripe_status');
            $table->renameColumn('price', 'stripe_price');
            $table->renameColumn('start_at', 'trial_end_at');

        });
    }
}
