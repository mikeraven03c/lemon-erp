<?php

namespace App\Packages\VirtualModels\Listeners;

use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Packages\VirtualModels\Events\VirtualModelCreatedEvent;

class DeleteVirtualTable implements ShouldQueue
{
    public function __construct()
    {
    }
    public function handle(VirtualModelCreatedEvent $event)
    {
        $virtualModels = $event->virtualModel;

        foreach ($virtualModels as $virtualModel) {
            $tableName = config('virtual.table.prefix')
                . $virtualModel->table_name;

            Schema::connection('mysql')->dropIfExists($tableName);
        }
    }
}
