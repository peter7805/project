<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('account', 50);
            $table->string('userId', 50);
            $table->string('password', 100);
            $table->integer('balance')->nullable();
            $table->integer('login_failed')->nullable();
            $table->timestamp('login_time')->nullable();
            $table->timestamp('create_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
