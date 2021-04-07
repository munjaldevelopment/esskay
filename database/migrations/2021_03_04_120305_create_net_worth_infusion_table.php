<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetWorthInfusionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_worth_infusions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('month');
            $table->decimal('capital_infusion', 8, 2)->nullable();
            $table->text('investors')->nullable();

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
        Schema::dropIfExists('net_worth_infusions');
    }
}
