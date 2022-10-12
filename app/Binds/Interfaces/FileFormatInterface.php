<?php

namespace Modules\Tenancy\Binds\Interfaces;

interface FileFormatInterface
{
    public function getOpeningBind() : string;
    public function getClosingBind() : string;
    public function getContent() : array;
    public function getContentSpacing() : int;
    public function getOpenAndCloseSpacing() : int;
    public function getTarget() : string;
    public function getPath() : string;
    public function beforeTarget() : bool;
}
