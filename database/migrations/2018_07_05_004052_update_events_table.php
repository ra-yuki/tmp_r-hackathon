<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('dateTimeFrom');
            $table->dropColumn('dateTimeTo');
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->time('timeFrom');
            $table->time('timeTo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime("dateTimeFrom");
            $table->dateTime("dateTimeTo");
            $table->dropColumn('dateFrom');
            $table->dropColumn('dateTo');
            $table->dropColumn('timeFrom');
            $table->dropColumn('timeTo');
        });
    }
}
