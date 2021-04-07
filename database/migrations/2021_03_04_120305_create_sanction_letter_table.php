<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanctionLetterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_letters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('bank_name');
            $table->string('type_facility')->nullable();
            $table->string('facility_amount')->nullable();
            $table->string('roi')->nullable();
            $table->string('all_incluside_roi')->nullable();
            $table->string('processing_fees')->nullable();
            $table->string('arranger_fees')->nullable();
            $table->string('stanp_duty_fees')->nullable();
            $table->string('tenor')->nullable();
            $table->string('security_cover')->nullable();
            $table->string('cash_collateral')->nullable();
            $table->string('personal_guarantee')->nullable();
            $table->string('intermediary')->nullable();
            $table->string('sanction_letter')->nullable();
            
            $table->tinyinteger('approved_by1')->nullable();
            $table->tinyinteger('approved_by2')->nullable();
            $table->tinyinteger('approved_by3')->nullable();
            
            $table->tinyinteger('status')->nullable();
            

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
        Schema::dropIfExists('sanction_letters');
    }
}
