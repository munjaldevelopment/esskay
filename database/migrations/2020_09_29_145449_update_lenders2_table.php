<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLenders2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lenders', function (Blueprint $table) {
			// receivables	Security required	Fixed Deposit Required	Personal Guarantee	Type of Lender	Type of Insturment	Type of Facility

            $table->string('lot_name')->after('code');
            $table->date('availment_date')->after('lot_name')->nullable();
            $table->date('sanction_date')->after('availment_date')->nullable();
            $table->string('sanction_amount')->after('sanction_date');
            $table->string('principal_assigned')->after('sanction_amount');
            $table->string('outstanding')->after('principal_assigned');
            $table->string('interest_rate')->after('outstanding');
            $table->string('inclusive_irr')->after('interest_rate');
            $table->string('processing_fee')->after('inclusive_irr');
            $table->string('principal_repayment_frequency')->after('processing_fee');
            $table->string('interest_payment_frequency')->after('principal_repayment_frequency');
            $table->string('door_to_door')->after('interest_payment_frequency');
            $table->date('maturity_date')->after('door_to_door')->nullable();
            $table->string('security_margin_receivables')->after('maturity_date');
            $table->string('security_required')->after('security_margin_receivables');
            $table->string('fixed_deposit_required')->after('security_required');
            $table->string('personal_guarantee')->after('fixed_deposit_required');
			
			$table->unsignedBigInteger('lender_type_id')->after('personal_guarantee');
			
			$table->foreign('lender_type_id')
                ->references('id')
                ->on('lender_type')
                ->onDelete('cascade');
				
			$table->unsignedBigInteger('instrument_type_id')->after('lender_type_id');
			
			$table->foreign('instrument_type_id')
                ->references('id')
                ->on('instrument_type')
                ->onDelete('cascade');
				
			$table->unsignedBigInteger('facility_type_id')->after('instrument_type_id');
			
			$table->foreign('facility_type_id')
                ->references('id')
                ->on('facility_type')
                ->onDelete('cascade');
        });
    }

    /**
		* Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lenders');
    }
}
