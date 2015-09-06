<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFundActivityTypeIdToFundActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_activity', function (Blueprint $table) {
            $table->integer('activity_type_id')->unsigned()->index();

            $table->foreign('activity_type_id')->references('id')->on('fund_activity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_activity', function (Blueprint $table) {
            $table->dropForeign('fund_activity_activity_type_id');
            $table->dropColumn('activity_type_id');
        });
    }
}
