<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConfirmationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_confirmation_codes');
        Schema::create('user_confirmation_codes', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->smallInteger('type');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->smallInteger('number_of_attempts')->default(0);
            $table->smallInteger('number of attempts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_confirmation_codes');
    }
}
