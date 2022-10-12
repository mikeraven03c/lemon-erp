<?php
namespace App\Lemon\Publishers\Resources\Actions;

use App\Lemon\Publishers\Resources\Actions\BindAppPackage\BindFileFormatClass;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats\BindAppPackgeFormat;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats\BindUIRoutesJSFormat;

class BindFormatAction
{
    public function __invoke($name, BindFileFormatClass $formatter)
    {
        $content = $this->getContent($formatter->getPath());

        $binds = $formatter->build($name);

        $bind = implode(PHP_EOL, $binds);

        $target = $formatter->getTarget();

        if ($formatter->beforeTarget()) {
            $format = $bind . PHP_EOL . $target;
        } else {
            $format = $target . PHP_EOL . $bind;
        }
        $content = str_replace($target, $format, $content);

        file_put_contents($formatter->getPath(), $content);
    }

    public function getContent($path)
    {
        return file_get_contents($path);
    }

    public function getTarget()
    {
        return $this->target ?? '# BIND #';
    }
}
