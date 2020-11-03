<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountInfo', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('number');
            $table->double('amount', 10, 2);
            $table->double('money', 10, 2);
            $table->double('balance', 10, 2);
            $table->integer('type');
            $table->string('remark', 320)->nullable();
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
        Schema::dropIfExists('accountInfo');
    }
}
