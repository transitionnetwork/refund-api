<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddProviderIdToFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funds', function (Blueprint $table) {

            $table->integer('provider_id')->unsigned();

            $table->foreign('provider_id')->references('id')->on('fund_providers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funds', function (Blueprint $table) {

            $table->dropForeign('funds_provider_id_foreign');

            $table->dropColumn('provider_id');

        });
    }
}
