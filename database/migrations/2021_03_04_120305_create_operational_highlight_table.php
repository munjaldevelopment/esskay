<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationalHighlightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_highlights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('operation_row1_value')->nullable();
            $table->string('operation_row1_income')->nullable();
            $table->string('operation_row2_value')->nullable();
            $table->string('operation_row2_income')->nullable();
            $table->string('operation_row3_value')->nullable();

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
