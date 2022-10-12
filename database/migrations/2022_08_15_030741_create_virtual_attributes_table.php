<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('field');
            $table->string('type');
            $table->unsignedBigInteger('virtual_model_id');
            $table->foreign('virtual_model_id')->references('id')->on('virtual_models');
            $table->boolean('is_required');
            $table->string('tab')->nullable();
            $table->boolean('is_choices');
            $table->json('options')->nullable();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('virtual_attributes');
    }
}
