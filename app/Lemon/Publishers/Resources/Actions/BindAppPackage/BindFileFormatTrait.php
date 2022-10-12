<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage;

trait BindFileFormatTrait
{
    public function getOpeningBind()
    {
        return '';
    }

    public function getClosingBind()
    {
        return '';
    }

    public function getContent()
    {
        return [];
    }

    public function getContentSpacing()  : int
    {
        return 12;
    }

    public function getOpenAndCloseSpacing() : int
    {
        return 8;
    }

    public function getTarget()
    {
        return '# BIND #';
    }

    public function getPath() : string
    {
        return app_path();
    }

    public function noOpeningCloseTag()
    {
        return false;
    }

    public function beforeTarget() {
        return false;
    }
}
