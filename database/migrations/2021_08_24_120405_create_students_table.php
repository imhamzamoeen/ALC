<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::Active);
            $table->string('timezone');
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');;
            $table->foreignIdFor(\App\Models\Course::class, 'course_id')->nullable()->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');;
            $table->foreignId('user_subcription_id')->nullable();
            $table->string('subscription_status')->default(\App\Classes\Enums\StatusEnum::NotSubscribed);
            $table->integer('vacation_mode')->default(0);
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
        Schema::dropIfExists('students');
    }
}
