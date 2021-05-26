<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrongLiabilityProfileTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strong_liability_profile_tables', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('lender');
            $table->decimal('amount1', 8, 2)->nullable();
            $table->string('amount1_lender')->nullable();
            $table->decimal('amount2', 8, 2)->nullable();
            $table->string('amount2_lender')->nullable();
            $table->decimal('amount3', 8, 2)->nullable();
            $table->string('amount3_lender')->nullable();
            $table->decimal('amount4', 8, 2)->nullable();
            $table->string('amount4_lender')->nullable();
            $table->decimal('amount5', 8, 2)->nullable();
            $table->string('amount5_lender')->nullable();
            $table->decimal('amount6', 8, 2)->nullable();
            $table->string('amount6_lender')->nullable();
            $table->decimal('amount7', 8, 2)->nullable();
            $table->string('amount7_lender')->nullable();
            $table->decimal('amount8', 8, 2)->nullable();
            $table->string('amount8_lender')->nullable();
            
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
        Schema::dropIfExists('strong_liability_profiles');
    }
}
