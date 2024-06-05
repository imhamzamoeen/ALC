<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value');
            $table->string('status')->default(\App\Classes\Enums\StatusEnum::Active);
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->default(1);
            $table->foreignIdFor(\App\Models\User::class, 'updated_by')->default(1);
            $table->string('category')->default('general');
            $table->string('type')->default('text');
            $table->integer('is_required')->default(1);
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
        Schema::dropIfExists('settings');
    }
}
