<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSafeToDailyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_states', function (Blueprint $table) {
            $table->decimal('safe_debited')->default(0)->after('register_start');
            $table->decimal('safe_received')->default(0)->after('register_start');
            $table->decimal('safe_start')->after('register_start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_states', function (Blueprint $table) {
            //
        });
    }
}
