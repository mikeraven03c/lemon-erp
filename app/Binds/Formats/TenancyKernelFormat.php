<?php

namespace Modules\Tenancy\Binds\Formats;

use Modules\Tenancy\Binds\Interfaces\FileFormatInterface;

class TenancyKernelFormat implements FileFormatInterface
{
    public function getOpeningBind() : string
    {
        return "'tenant' => [";
    }

    public function getClosingBind() : string
    {
        return "],";
    }

    public function getContent() : array
    {
        return [
            "'web',",
            '\Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain::class'
        ];
    }

    public function getContentSpacing() : int
    {
        return 12;
    }

    public function getOpenAndCloseSpacing() : int
    {
        return 8;
    }

    public function getTarget() : string
    {
        return 'protected $middlewareGroups = [';
    }

    public function getPath() : string
    {
        return app_path('http/Kernel.php');
    }

    public function beforeTarget() : bool
    {
        return false;
    }
}
