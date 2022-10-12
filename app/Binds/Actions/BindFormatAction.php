<?php

namespace Modules\Tenancy\Binds\Actions;

use Modules\Tenancy\Binds\BindFormatClass;

class BindFormatAction
{
    public function __invoke(BindFormatClass $formatter)
    {
        $content = $this->getContent($formatter->path);

        $bind = implode(PHP_EOL, $formatter->content);

        $target = $formatter->target;

        if ($formatter->beforeTarget) {
            $format = $bind . PHP_EOL . $target;
        } else {
            $format = $target . PHP_EOL . $bind;
        }
        $content = str_replace($target, $format, $content);

        file_put_contents($formatter->path, $content);
    }

    public function getContent($path)
    {
        return file_get_contents($path);
    }
}
