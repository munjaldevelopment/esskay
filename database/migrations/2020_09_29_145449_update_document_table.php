<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
			// receivables	Security required	Fixed Deposit Required	Personal Guarantee	Type of Lender	Type of Insturment	Type of Facility

			$table->unsignedBigInteger('document_sub_category_id')->after('document_category_id');
			
			$table->foreign('document_sub_category_id')
                ->references('id')
                ->on('document_category')
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
