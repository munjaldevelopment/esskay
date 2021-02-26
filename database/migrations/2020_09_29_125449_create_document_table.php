<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('document_category_id');
			
			$table->foreign('document_category_id')
                ->references('id')
                ->on('document_category')
                ->onDelete('cascade');
				
			$table->string('document_name');
			$table->integer('document_type');
			$table->integer('document_filename');
			$table->timestamps();
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
