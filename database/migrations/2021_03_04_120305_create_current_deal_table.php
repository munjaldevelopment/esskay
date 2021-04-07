<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentDealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_deals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('current_deal_category_id');
            
            $table->foreign('current_deal_category_id')
                ->references('id')
                ->on('current_deal_categories')
                ->onDelete('cascade');

            $table->string('current_deal_code')->unique();
            $table->string('name')->nullable();
            $table->string('product')->nullable();
            $table->string('rating')->nullable();
            $table->string('amount')->nullable();
            $table->string('pricing')->nullable();
            $table->string('tenure')->nullable();
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
        Schema::dropIfExists('current_deals');
    }
}
