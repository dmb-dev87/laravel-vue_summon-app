<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('name')->nullable();
            $table->string('email')->unique();
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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role_name')->default('User');
            $table->string('languages')->nullable();
            $table->string('status')->default('Deactivate');
            $table->tinyInteger('del_flag')->default('0');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
