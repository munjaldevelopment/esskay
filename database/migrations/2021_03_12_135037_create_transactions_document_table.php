<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_documents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('document_category_lender_id');
            $table->unsignedBigInteger('document_sub_category_lender_id');

            $table->unsignedBigInteger('transaction_id');
            
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->string('document_heading')->nullable();
            $table->string('document_name')->nullable();
            $table->string('document_guide')->nullable();
            $table->string('document_filename')->nullable();
            $table->string('document_date')->nullable();
            $table->string('document_pdf')->nullable();
            $table->date('expiry_date')->nullable();

            $table->tinyinteger('document_status')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
