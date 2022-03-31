<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_states', function (Blueprint $table) {
            $table->id();
            $table->decimal('register_start');
            $table->decimal('expenses_cash')->default(0);
            $table->decimal('incomes_cash')->default(0);

            $table->integer('voucher_no')->default(0);
            $table->integer('technical_no')->default(0);

            $table->decimal('reg_cash')->default(0);
            $table->decimal('reg_check')->default(0);
            $table->decimal('reg_card')->default(0);
            $table->decimal('reg_firm')->default(0);

            $table->decimal('tech_cash')->default(0);
            $table->decimal('tech_check')->default(0);
            $table->decimal('tech_card')->default(0);
            $table->decimal('tech_invoice')->default(0);

            $table->decimal('agency')->default(0);
            $table->decimal('voucher')->default(0);
            $table->decimal('adm')->default(0);

            $table->foreignId('location_id')->constrained();
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
        Schema::dropIfExists('daily_states');
    }
}
