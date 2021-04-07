<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionEfficiencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_efficiency', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('geographical_diversification');
            $table->string('heading_graph1');
            $table->decimal('amount_graph1', 8, 2)->nullable();
            $table->string('heading_graph2');
            $table->decimal('amount_graph2', 8, 2)->nullable();
            $table->string('heading_graph3');
            $table->decimal('amount_graph3', 8, 2)->nullable();

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
        Schema::dropIfExists('insights');
    }
}
