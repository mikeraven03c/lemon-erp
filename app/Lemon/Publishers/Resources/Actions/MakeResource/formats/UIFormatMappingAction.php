<?php

namespace App\Lemon\Publishers\Resources\Actions\MakeResource\Formats;

use App\Lemon\Publishers\Resources\Config\VariableResource;

class UIFormatMappingAction
{
    public function __invoke($field, $fileResource)
    {
        $variable = (new VariableResource)(['name' => $field[0]])->toArray();

        $props = [];
        $forms = [];

        $props['name'] = $this->wrap($field[0]);

        $isRequired = true;
        if (count($field) == 3) {
            if ($field[2] == 'nullable') {
                $isRequired = false;
            }
        } else if (count($field) > 4) {
            if ($field[3] == 'nullable') {
                $isRequired = false;
            }
        }

        $props['required'] = $isRequired ? "true" : "false";
        $props['label'] = $this->wrap($variable[VariableResource::LABELNAME]);
        $props['field'] = $this->wrap($field[0]);
        $props['sortable'] = "true";
        $props['type'] = $this->wrap($field[1]);
        $props['align'] = $this->alignProperty($field[1]);
        $props['size'] = $this->wrap("col-12");
        $props['showOnForm'] = "true";

        // $hasForm = isset($fileResource['hasForm'])
        //     ? $fileResource['hasForm']
        //     : false;

        // $forms['hasForm'] = $hasForm;
        // if ($hasForm) {
        //     $forms['size'] = $this->wrap("col-12");
        //     $forms['showOnForm'] = "true";
        //     $forms['readOnlyOnEdit'] = "true";
        // }

        return (new UIBuildFormatAction)(
            $props,
            $forms
        );
    }

    public function alignProperty($type)
    {
        if (in_array($type, ['integer', 'double', 'float'])) {
            return $this->wrap('right');
        }
        return $this->wrap('left');
    }

    public function wrap($text)
    {
        return '"' . $text . '"';
    }
}
