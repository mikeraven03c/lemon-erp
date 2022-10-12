<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage;

use App\Lemon\Publishers\Resources\Config\VariableResource;

class BindFileFormatClass implements BindFileFormatInterface
{
    use BindFileFormatTrait;

    public function build($name)
    {
        $spacing = str_repeat(' ', $this->getOpenAndCloseSpacing());
        $contentSpacing = str_repeat(' ', $this->getContentSpacing());

        $opening = $spacing . $this->getOpeningBind();
        $closing = $spacing . $this->getClosingBind();
        $content = array_map(function ($map) use ($contentSpacing) {
            return $contentSpacing . $map;
        }, $this->format($name));

        if (!$this->noOpeningCloseTag()) {
            array_unshift(
                $content,
                $opening
            );

            array_push($content, $closing);
        }

        return $content;
    }

    private function format($name) {
        $contents = $this->getContent();
        $patterns = $this->getPattern($name);

        foreach ($contents as &$content) {
            $content = str_replace(
                array_keys($patterns),
                $patterns,
                $content
            );
        }

        return $contents;
    }


    private function getVariableResource(string $name)
    {
        return (new VariableResource)([
            'name' => $name
        ])->all();
    }

    private function getPattern($name) : array
    {
        $variable = $this->getVariableResource($name);

        return [
            '$PLURALNAME$' => $variable[VariableResource::PLURALNAME],
            '$NAME$' => $variable[VariableResource::NAME],
            '$LCNAME$' => $variable[VariableResource::LCNAME],
            '$KEBABNAME$' => $variable[VariableResource::KEBABNAME],
            '$LABELNAME$' => $variable[VariableResource::LABELNAME]
        ];
    }
}
