<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lenders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('rating');
            $table->unsignedBigInteger('asset_class_id');
			
			$table->foreign('asset_class_id')
                ->references('id')
                ->on('asset_classes')
                ->onDelete('cascade');
				
			$table->string('net_worth');
			$table->string('aum_total');
				
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
