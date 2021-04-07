<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCovidReliefLenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_relief_lenders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('bank_name');
            $table->string('april_emi')->nullable();
            $table->string('may_emi')->nullable();
            
            $table->tinyinteger('covid_relief_lender_status')->nullable();
            

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
        Schema::dropIfExists('covid_relief_lenders');
    }
}
