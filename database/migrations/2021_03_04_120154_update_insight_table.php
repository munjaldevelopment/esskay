<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateInsightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insight_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->nullable()->after('id');
            $table->integer('lft')->unsigned()->nullable()->after('parent_id');
            $table->integer('rgt')->unsigned()->nullable()->after('lft');
            $table->integer('depth')->unsigned()->nullable()->after('rgt');
        });

        Schema::table('insights', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->nullable()->after('id');
            $table->integer('lft')->unsigned()->nullable()->after('parent_id');
            $table->integer('rgt')->unsigned()->nullable()->after('lft');
            $table->integer('depth')->unsigned()->nullable()->after('rgt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
