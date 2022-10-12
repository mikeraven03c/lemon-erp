<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('table_name');
            $table->unsignedBigInteger('virtual_group_id')->nullable();
            $table->foreign('virtual_group_id')->references('id')->on('virtual_groups')->onDelete('cascade');
            $table->json('data')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('virtual_models');
    }
}
