<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrongLiabilityProfileRatioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strong_liability_profile_ratio', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('financial_year');
            $table->decimal('amount1', 8, 2)->nullable();
            $table->decimal('amount2', 8, 2)->nullable();
            $table->decimal('amount3', 8, 2)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strong_liability_profile_ratio');
    }
}
