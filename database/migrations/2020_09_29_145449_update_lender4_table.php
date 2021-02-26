<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLender4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//DB::statement('UPDATE lenders SET email = NULL;');
		
        Schema::table('lenders', function (Blueprint $table) {
			// receivables	Security required	Fixed Deposit Required	Personal Guarantee	Type of Lender	Type of Insturment	Type of Facility
			$table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
				
			//$table->dropUnique('guests_email_unique');
				
			//$table->unique('email');
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
