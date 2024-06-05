<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes_requests', function (Blueprint $table) {
            $table->id();
            $table->text('reason')->nullable();
            $table->foreignId('course_id')->nullable()->constrained('courses','id')->onUpdate('cascade');
            $table->foreignId('student_id')->constrained('students','id')->onUpdate('cascade');
            $table->enum('change_type', ['teacher_change', 'course_change']);
            $table->string('status',90)->nullable()->default('pending');
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
        Schema::dropIfExists('changes_requests');
    }
}
