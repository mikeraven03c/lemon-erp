<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats;

use App\Lemon\Publishers\Resources\Actions\BindAppPackage\BindFileFormatClass;

class BindUIRoutesJSFormat extends BindFileFormatClass
{
    const NAME = 'ui-vue';

    public function noOpeningCloseTag()
    {
        return true;
    }

    public function getContent() : array
    {
        $path = 'src/packages/$LCNAME$/$NAME$Index.vue';
        return [
            '{ path: "$KEBABNAME$", component: () => import("' . $path . '") },',
        ];
    }

    public function getContentSpacing()  : int
    {
        return 6;
    }

    public function getTarget()
    {
        return 'children: [';
    }

    public function getPath() : string
    {
        return base_path('ui/src/router/routes.js');
        // return app_path('Providers/AppPackageServiceProvider.php');
    }
}
