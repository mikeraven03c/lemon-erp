<?php

// use App\Packages\Users\Contracts\UserContract;
// use App\Packages\Users\Repository\UserRepository;

namespace App\Lemon\Publishers\Resources\Actions;

use App\Lemon\Publishers\Resources\Config\VariableResource;

class BindAppPackagesAction
{
    public function __invoke($name)
    {
        $variable = $this->getVariableResource($name);

        $content = $this->getContent();

        $t = chr(9) . chr(9);
        $t2 = chr(9) . chr(9) . chr(9);

        $binds = [
            $t . '$this->app->bind(',
            $t2 . 'App\Packages\$PLURALNAME$\Contracts\$NAME$Contract::class,',
            $t2 . 'App\Packages\$PLURALNAME$\Repository\$NAME$Repository::class',
            $t . ');'
        ];

        foreach ($binds as &$bind) {
            $bind = str_replace([
                '$PLURALNAME$', '$NAME$'
            ], [
                $variable[VariableResource::PLURALNAME],
                $variable[VariableResource::NAME],
            ], $bind);
        }

        $bind = implode(PHP_EOL, $binds);

        $path = $this->getProviderPath();

        $target = $this->getTarget();

        $content = str_replace($target, $target . PHP_EOL . $bind, $content);

        file_put_contents($path, $content);
    }

    public function getVariableResource(string $name)
    {
        return (new VariableResource)([
            'name' => $name
        ])->all();
    }

    public function getProviderPath()
    {
        return app_path('Providers/AppPackageServiceProvider.php');
    }

    public function getContent()
    {
        return file_get_contents($this->getProviderPath());
    }

    public function getTarget()
    {
        return $this->target ?? '# BIND #';
    }
}
