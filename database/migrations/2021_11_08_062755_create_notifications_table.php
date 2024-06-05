<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('normal');
            $table->integer('from')->default(0);
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(\App\Models\Student::class, 'student_id')->nullable();
            $table->text('html');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::Active);
            $table->bigInteger('remindable')->default(0);
            $table->dateTime('remind_at')->nullable();
            $table->bigInteger('is_seen')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
