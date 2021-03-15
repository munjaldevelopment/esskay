<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class updateTransactionsDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_document_type_id')->after('transaction_id');
            
            $table->foreign('transaction_document_type_id')
                ->references('id')
                ->on('transaction_document_types')
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
        //Schema::dropIfExists('transactions');
    }
}
