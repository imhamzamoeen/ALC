<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRescheduleRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reschedule_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Student::class, 'student_id');
            $table->foreignIdFor(\App\Models\User::class, 'teacher_id');
            $table->foreignIdFor(\App\Models\WeeklyClass::class, 'weekly_class_id');
            $table->integer('reschedule_slot_id');
            $table->dateTime('reschedule_date');
            $table->string('status')->default('pending');    
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('reschedule_requests');
    }
}
