<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('summon_id');            
            $table->foreignId('user_id');
            $table->foreignId('contact_id');
            $table->string('main_type', 50);                        // main_type: MAIL or PHONE
            $table->string('sub_type', 50)->nullable();             // sub_type: SMS, VOICE, WHATSAPP
            $table->string('status', 50);                           // status: SEND, NOTSEND, READ, NUREAD
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
        Schema::dropIfExists('histories');
    }
}
