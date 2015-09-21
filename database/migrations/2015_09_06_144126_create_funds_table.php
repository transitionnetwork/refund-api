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

            $table->string('name');

            $table->string('location');

            $table->string('website');

            $table->boolean('status')->default(false);

            $table->longText('focus');

            $table->double('min_size')->unsigned();

            $table->double('max_size')->unsigned();

            $table->double('loan_rate')->unsigned();

            $table->integer('investment_term')->unsigned();

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
