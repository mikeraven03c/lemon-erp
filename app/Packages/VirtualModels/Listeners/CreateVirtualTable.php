<?php

namespace App\Packages\VirtualModels\Listeners;

use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Packages\VirtualModels\Events\VirtualModelCreatedEvent;

class CreateVirtualTable implements ShouldQueue
{
    public function __construct()
    {
    }
    public function handle(VirtualModelCreatedEvent $event)
    {
        $virtualModel = $event->virtualModel;

        $tableName = config('virtual.table.prefix') . $virtualModel->table_name;
        if (!Schema::connection('mysql')->hasTable($tableName)) {
            Schema::connection('mysql')->create($tableName, function($table)
            {
                $table->increments('id');
                $table->json('data')->nullable();
                $table->timestamps();
            });
        }
    }
}
