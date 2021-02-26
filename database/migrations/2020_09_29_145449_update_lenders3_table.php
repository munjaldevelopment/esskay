<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLenders3Table extends Migration
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

            $table->string('slug')->after('code');
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
