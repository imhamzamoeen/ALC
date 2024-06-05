<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Student::class, 'student_id')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\RoutineClass::class, 'routine_class_id')->constrained()
                ->onUpdate('cascade');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::SCHEDULED);
            $table->string('student_status')->default(\App\Classes\Enums\StatusEnum::SCHEDULED);
            $table->string('teacher_status')->default(\App\Classes\Enums\StatusEnum::SCHEDULED);
            $table->dateTime('class_time');
            $table->text('class_link');
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
        Schema::dropIfExists('weekly_classes');
    }
}
