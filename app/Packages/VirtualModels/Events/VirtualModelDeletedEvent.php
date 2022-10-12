<?php

namespace App\Packages\VirtualModels\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Packages\VirtualModels\Models\VirtualModel;

class VirtualModelDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /** @var VirtualModel */
    public $virtualModel;

    public function __construct($virtualModel)
    {
        $this->virtualModel = $virtualModel;
    }
}
