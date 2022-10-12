<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats;

use App\Lemon\Publishers\Resources\Actions\BindAppPackage\BindFileFormatClass;

class BindAppPackgeFormat extends BindFileFormatClass
{
    const NAME = 'app-package';

    public function getOpeningBind()
    {
        return '$this->app->bind(';
    }

    public function getClosingBind()
    {
        return ');';
    }

    public function getContent() : array
    {
        return [
            '\App\Packages\$PLURALNAME$\Contracts\$NAME$Contract::class,',
            '\App\Packages\$PLURALNAME$\Repositories\$NAME$Repository::class'
        ];
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
        return app_path('Providers/AppPackageServiceProvider.php');
    }
}
