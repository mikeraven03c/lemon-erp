<?php

namespace App\Lemon\Publishers\Resources\Actions\MakeResource\Formats;

class UIBuildFormatAction
{
    protected $propertySpacing = '';
    protected $baseSpacing = '';

    public function __invoke(
        $props,
        $forms,
        $hasForm = false
    )
    {
        $spc = str_repeat(" ", 2);
        $spcProperty = str_repeat(" ", 4);
        $items = [];
        $spcForm = str_repeat(" ", 6);
        $fields = [
            'name',
            'required',
            'label',
            'align',
            'field',
            'sortable',
            'type',
            'size',
            'showOnForm'
        ];

        $formFields = [
            'size',
            'showOnlyForm',
            'readOnlyOnEdit'
        ];


        foreach ($fields as $field) {
            $items[$field] = $spcProperty
                . $this->buildProperty($props, $field);
        }

        // if ($hasForm) {
        //     foreach ($formFields as $field) {
        //         $forms[$field] = $spcForm
        //             . $this->buildProperty($forms, $field);
        //         }
        // }

        // $items = $hasForm
        //     ? array_merge(
        //         [$spc . '{'],
        //         $props,
        //         [$spcProperty . "form: {"],
        //         $forms,
        //         [
        //             $spcProperty . "}",
        //             $spc . '}'
        //         ]
        //     )
        //     : array_merge(
        //         [$spc . '{'],
        //         $props,
        //         [$spc . '},']
        //     );

        // $stack = array_merge(
        //     [$spc . '{'],
        //     $items,
        //     [$spc . '},']
        // );
        $items = array_values($items);
        array_unshift($items, $spc . '{');
        array_push($items, $spc . '},');
        // logger(['stack' => $items]);

        return implode(PHP_EOL, $items);
    }

    public function buildProperty($props, $field)
    {
        return $field . ": " . $props[$field] . ",";
    }
}
