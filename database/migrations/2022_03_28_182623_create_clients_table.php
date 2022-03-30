<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->date('first_date');
            $table->date('last_date');
            $table->string('full_name');
            $table->boolean('site')->nullable();
            $table->boolean('recommendation')->nullable();
            $table->boolean('internet')->nullable();
            $table->boolean('totems')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('location_id')->nullable()->constrained();
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
        Schema::dropIfExists('clients');
    }
}
