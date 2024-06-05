<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnToRescheduleRequestMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reschedule_requests', function (Blueprint $table) {
            //
            $table->morphs('Requestable');  //either user or student has requeste for it 
            $table->string('updated_by',30)->default('teacher')->change();   //whether a user has perforemd last update or teacher 
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reschedule_requests', function (Blueprint $table) {
            //
            $table->dropColumn('Requestable_type');
            $table->dropColumn('Requestable_id');
            $table->dropColumn('updated_by');
            

        });
    }
}
