<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name')->nullable();
            $table->string('email');
            $table->boolean('email_val1')->default('1');
            $table->string('email2')->nullable();
            $table->boolean('email_val2')->default('0');
            $table->string('phone_number1')->nullable();
            $table->boolean('phone_voice1')->default('0');
            $table->boolean('phone_sms1')->default('0');
            $table->boolean('phone_whatsapp1')->default('0');
            $table->string('phone_number2')->nullable();
            $table->boolean('phone_voice2')->default('0');
            $table->boolean('phone_sms2')->default('0');
            $table->boolean('phone_whatsapp2')->default('0');
            $table->string('phone_number3')->nullable();
            $table->boolean('phone_voice3')->default('0');
            $table->boolean('phone_sms3')->default('0');
            $table->boolean('phone_whatsapp3')->default('0');
            $table->tinyInteger('del_flag')->default('0');
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
        Schema::dropIfExists('contacts');
    }
}
