<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('provider_id')->unsigned()->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');

            $table->string('name');
            $table->string('website');
            $table->string('investment_term');
            $table->string('loans_rate');

            $table->integer('min_size')->default(0);
            $table->integer('max_size')->default(0);

            $table->text('focus');

            $table->smallInteger('status')->default(0);

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
        Schema::drop('funds');
    }
}
