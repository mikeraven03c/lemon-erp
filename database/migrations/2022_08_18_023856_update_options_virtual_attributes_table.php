<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtual_attributes', function($table) {
            $table->dropColumn('options');
        });
        Schema::table('virtual_attributes', function($table) {
            $table->text('options')->nullable()->after('is_choices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtual_attributes', function($table) {
            $table->dropColumn('options');
            $table->json('options')->nullable()->after('is_choices');
        });
    }
};
