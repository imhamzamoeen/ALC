<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TrialClass::class, 'trial_class_id');
            $table->integer('communication')->default(1);
            $table->integer('teaching')->default(1);
            $table->integer('behaviour')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trial_reviews');
    }
}
