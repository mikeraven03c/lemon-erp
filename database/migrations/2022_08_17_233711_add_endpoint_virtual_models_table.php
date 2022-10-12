<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Packages\VirtualModels\Models\VirtualModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtual_models', function($table) {
            $table->string('endpoint')->nullable()->after('name');
        });

        $virtualModels = VirtualModel::get();
        foreach ($virtualModels as $virtualModel) {
            DB::table('virtual_models')->where('id', $virtualModel->id)
                ->update([
                    'endpoint' => $virtualModel->endpoint,
                    'data' => DB::raw("JSON_REMOVE(data, 'endpoint')")
                ]);;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtual_models', function($table) {
            $table->dropColumn('endpoint');
        });
    }
};
