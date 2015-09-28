<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundProvisionTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_provision_type', function(Blueprint $table) {
            $table->integer('fund_id')->unsigned()->index();
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('cascade');
            $table->integer('provision_type_id')->unsigned()->index();
            $table->foreign('provision_type_id')->references('id')->on('provision_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fund_provision_type');
    }
}
