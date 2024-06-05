<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Student::class, 'student_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::PENDING);
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
        Schema::dropIfExists('trial_requests');
    }
}
