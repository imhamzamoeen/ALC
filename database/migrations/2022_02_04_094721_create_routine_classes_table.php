<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Student::class, 'student_id');
            $table->foreignIdFor(\App\Models\User::class, 'teacher_id');
            $table->foreignIdFor(\App\Models\AvailabilitySlot::class, 'slot_id');
            $table->text('class_link');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::Active);
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
        Schema::dropIfExists('routine_classes');
    }
}
