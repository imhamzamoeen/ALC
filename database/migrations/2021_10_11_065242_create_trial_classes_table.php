<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TrialRequest::class, 'trial_request_id');
            $table->string('teacher_name');
            $table->string('zoom_link');
            $table->dateTime('starts_at');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::TrialScheduled);
            $table->softDeletes();
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
        Schema::dropIfExists('trial_classes');
    }
}
