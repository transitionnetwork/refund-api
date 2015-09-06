<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundOrganisationTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_organisation_type', function(Blueprint $table) {
            $table->integer('fund_id')->unsigned()->index();
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('cascade');

            $table->integer('organisation_type_id')->unsigned()->index();
            $table->foreign('organisation_type_id')->references('id')->on('organisation_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fund_organisation_type');
    }
}
