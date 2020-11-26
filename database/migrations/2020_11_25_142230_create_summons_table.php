<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('location_id');
            $table->string('contact_list')->nullable();
            $table->string('group_list')->nullable();
            $table->timestamp('due_date')->useCurrent();
            $table->tinyinteger('del_flag')->default(0);
            $table->string('message')->nullable();
            $table->boolean('is_sent')->default('1');
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
        Schema::dropIfExists('summons');
    }
}
