<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCovidReliefBorrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_relief_borrowers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('particulars');
            $table->string('april_20')->nullable();
            $table->string('may_20')->nullable();
            $table->string('june_20')->nullable();
            $table->string('july_20')->nullable();
            $table->string('august_20')->nullable();
            $table->string('sept_20')->nullable();
            
            $table->tinyinteger('covid_relief_borrower_status')->nullable();
            

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
        Schema::dropIfExists('covid_relief_borrowers');
    }
}
