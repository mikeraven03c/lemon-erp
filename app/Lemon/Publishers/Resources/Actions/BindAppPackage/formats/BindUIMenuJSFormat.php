<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats;

use App\Lemon\Publishers\Resources\Actions\BindAppPackage\BindFileFormatClass;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\BindFileFormatTrait;

class BindUIMenuJSFormat extends BindFileFormatClass
{
    use BindFileFormatTrait;

    const NAME = 'ui-menu';

    public function getOpeningBind()
    {
        return '{';
    }

    public function getClosingBind()
    {
        return '},';
    }

    public function getContent() : array
    {
        return [
            'title: "' . '$NAME$",',
            'link: "' . '$KEBABNAME$"'
        ];
    }

    public function getContentSpacing()  : int
    {
        return 4;
    }

    public function getOpenAndCloseSpacing() : int
    {
        return 2;
    }

    public function getTarget()
    {
        return ']';
    }

    public function getPath() : string
    {
        return base_path('ui/src/router/menu-extended.js');
    }

    public function beforeTarget() {
        return true;
    }
}
