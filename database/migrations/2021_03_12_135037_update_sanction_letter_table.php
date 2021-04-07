<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class updateSanctionLetterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanction_letter_revisions', function (Blueprint $table) {
            $table->string('bank_name')->after('sanction_letter_id');

            $table->string('type_facility')->nullable()->after('bank_name');
            $table->string('facility_amount')->nullable()->after('type_facility');
            $table->string('roi')->nullable()->after('facility_amount');
            $table->string('all_incluside_roi')->nullable()->after('roi');
            $table->string('processing_fees')->nullable()->after('all_incluside_roi');
            $table->string('arranger_fees')->nullable()->after('processing_fees');
            $table->string('stanp_duty_fees')->nullable()->after('arranger_fees');
            $table->string('tenor')->nullable()->after('stanp_duty_fees');
            $table->string('security_cover')->nullable()->after('tenor');
            $table->string('cash_collateral')->nullable()->after('security_cover');
            $table->string('personal_guarantee')->nullable()->after('cash_collateral');
            $table->string('intermediary')->nullable()->after('personal_guarantee');
            $table->string('sanction_letter')->nullable()->after('intermediary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('transactions');
    }
}
