<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductConcentrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_concentrations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('geographical_diversification');
            $table->decimal('amount1', 8, 2)->nullable();
            $table->decimal('amount_percentage1', 8, 2)->nullable();
            $table->decimal('amount2', 8, 2)->nullable();
            $table->decimal('amount_percentage2', 8, 2)->nullable();
            $table->decimal('amount3', 8, 2)->nullable();
            $table->decimal('amount_percentage3', 8, 2)->nullable();
            $table->decimal('amount4', 8, 2)->nullable();
            $table->decimal('amount_percentage4', 8, 2)->nullable();
            $table->decimal('amount5', 8, 2)->nullable();
            $table->decimal('amount_percentage5', 8, 2)->nullable();
            $table->decimal('amount6', 8, 2)->nullable();
            $table->decimal('amount_percentage6', 8, 2)->nullable();
            $table->decimal('amount7', 8, 2)->nullable();
            $table->decimal('amount_percentage7', 8, 2)->nullable();
            $table->decimal('amount8', 8, 2)->nullable();
            $table->decimal('amount_percentage8', 8, 2)->nullable();
            $table->decimal('amount9', 8, 2)->nullable();
            $table->decimal('amount_percentage9', 8, 2)->nullable();

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
        Schema::dropIfExists('insights');
    }
}
