<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicals', function (Blueprint $table) {
            $table->id();
            $table->date('tech_date');
            $table->string('reg_number');
            
            $table->decimal('reg_cash')->nullable();
            $table->decimal('reg_check')->nullable();
            $table->decimal('reg_card')->nullable();
            $table->decimal('reg_firm')->nullable();

            $table->decimal('tech_cash')->nullable();
            $table->decimal('tech_check')->nullable();
            $table->decimal('tech_card')->nullable();
            $table->decimal('tech_invoice')->nullable();

            $table->decimal('agency')->nullable();
            $table->decimal('voucher')->nullable();
            $table->decimal('adm')->nullable();

            $table->decimal('policy');
            $table->foreignId('insurance_company_id')->constrained()->onDelete('restrict');

            $table->foreignId('location_id')->constrained()->onDelete('restrict');

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
        Schema::dropIfExists('technicals');
    }
}
