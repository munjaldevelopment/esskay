<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiabilityProfileSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liability_profile_slider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('liability_profile_category_id');
            
            $table->foreign('liability_profile_category_id')
                ->references('id')
                ->on('liability_profile_categories')
                ->onDelete('cascade');

            $table->string('slider_code')->unique();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
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
