<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidity', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('quarter');
            $table->decimal('amount1', 8, 2)->nullable();
            $table->decimal('amount2', 8, 2)->nullable();
            $table->decimal('amount3', 8, 2)->nullable();
            $table->decimal('amount4', 8, 2)->nullable();
            $table->decimal('amount5', 8, 2)->nullable();
            $table->decimal('amount6', 8, 2)->nullable();
            $table->decimal('amount7', 8, 2)->nullable();
            $table->decimal('amount8', 8, 2)->nullable();
            $table->decimal('amount9', 8, 2)->nullable();

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
