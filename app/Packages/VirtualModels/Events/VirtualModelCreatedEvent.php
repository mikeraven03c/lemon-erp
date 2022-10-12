<?php

namespace App\Packages\VirtualModels\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Packages\VirtualModels\Models\VirtualModel;

class VirtualModelCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public VirtualModel $virtualModel;

    public function __construct(VirtualModel $model)
    {
        $this->virtualModel = $model;
    }
}
