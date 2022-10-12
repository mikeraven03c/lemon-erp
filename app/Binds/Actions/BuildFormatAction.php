<?php

namespace Modules\Tenancy\Binds\Actions;

use Modules\Tenancy\Binds\Interfaces\FileFormatInterface;

class BuildFormatAction
{
    protected $property;

    public function __invoke(FileFormatInterface $format)
    {
        $spacing = str_repeat(' ', $format->getOpenAndCloseSpacing());
        $contentSpacing = str_repeat(' ', $format->getContentSpacing());

        $opening = $spacing . $format->getOpeningBind();
        $closing = $spacing . $format->getClosingBind();
        $content = array_map(function ($map) use ($contentSpacing) {
            return $contentSpacing . $map;
        }, $format->getContent());

        array_unshift(
            $content,
            $opening
        );

        array_push($content, $closing);


        return $content;
    }
}
