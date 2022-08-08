<?php

namespace App\Lemon\Publishers\Resources\Actions\MakeResource;

class FormatColumnsMappingAction
{
    public function __invoke(string $tbName, string $type, array $columns)
    {
        $format = [];
        foreach ($columns as $column) {
            switch ($type) {
                case 'request':
                    $format[] = $this->requestFormat($tbName, $column);
                    break;
                case 'resource':
                    $format[] = $this->resourceFormat($column);
                    break;
                case 'factory':
                    $format[] = $this->factoryFormat($column);
                    break;
                case 'dto':
                    $format[] = $this->dtoFormat($column);
                    break;
                case 'dtoRequest':
                    $format[] = $this->dtoRequestFormat($column);
                    break;
                default:
                    $format[] = "'" . $column[0] . "',";
            }
        }

        return $format
            ? array_filter($format, fn ($value) => !is_null($value))
            : $columns;
    }

    public function requestFormat(string $tbName, array $field)
    {
        $rules = [];
        $name = $field[0];
        $format = "'" . $name . "' => [";

        $type = $this->requestType($field[1]);

        if ($type == null) {
        } else {
            $rules[] = "'$type'";
        }

        if (count($field) > 2) {
            $isRequired = true;
            if ($field[2] == 'nullable') {
                $isRequired = false;
                $rules[] = "'nullable'";
            } else if ($field[2] == 'unique') {
                $rules[] = "'unique:" . $tbName . "," . $name . "'";
            }

            if (count($field) > 3) {
                if ($field[3] == 'nullable') {
                    $isRequired = false;
                    $rules[] = "'nullable'";
                } else if ($field[3] == 'unique') {
                    $rules[] = "'unique:" . $tbName . "," . $name . "'";
                }
            }

            if ($isRequired) {
                $rules[] = "'required'";
            }
        } else if (count($field) == 2) {
            $rules[] = "'required'";
        }

        if ($rules) {
            return $format . implode(', ', $rules) . "],";
        }

        return null;
    }

    public function requestType($type)
    {
        switch ($type) {
            case 'string':
                return 'string';
            case 'integer':
                return 'numeric';
            case 'double':
                return 'numeric';
            case 'text':
                return 'string';
            case 'boolean':
                return 'boolean';
            case 'date':
                return 'date';
            case 'datetime':
                return 'date_format: Y-m-d H:i:s';
            default:
                return null;
        }
    }

    public function resourceFormat(array $field)
    {
        $name = $field[0];
        return "'" . $name . "' => $" . "this->" . $name . ",";
    }

    public function factoryFormat(array $field)
    {

        $name = $field[0];
        $type = $this->factoryType($field[0], $field[1]);

        if ($type == null) {
            return null;
        }
        return "'" . $name . "' => fake()->" . $type . ",";
    }

    public function factoryType($name, $type)
    {
        switch ($type) {
            case 'string':
                if ($name == 'name') return 'name()';
                else if ($name == 'email') return 'safeEmail()';
                return 'region()';
            case 'integer':
            case 'double':
                return 'randomNumber(1000, 5000)';
            case 'text':
                return 'realText(50, 2)';
            case 'boolean':
                return 'boolean()';
            case 'date':
                return 'date()';
            case 'datetime':
                return 'dateTime()';
            default:
                return null;
        }
    }

    public function dtoFormat($field)
    {
        $name = $field[0];
        $type = $this->dtoType($field[1]);
        $nullable = '';

        if (count($field) == 2) {
            $isRequired = true;
            if ($field[2] == 'nullable') {
                $nullable = '?';
            }
        } else if (count($field) > 3) {
            if ($field[3] == 'nullable') {
                $nullable = '?';
            }
        }

        if ($type != null) {
            $dataType = $nullable . $type;
        }

        return 'public ' . $dataType . ' $' . $name . ',';
    }

    public function dtoRequestFormat($field)
    {
        return '$request[' . "'" . $field[0] . "'],";
    }

    public function dtoType($type)
    {
        switch ($type) {
            case 'string':
                return 'string';
            case 'integer':
                return 'int';
            case 'double':
                return 'float';
            case 'text':
                return 'string';
            case 'boolean':
                return 'bool';
            case 'date':
                return 'string';
            case 'datetime':
                return 'string';
            default:
                return null;
        }
    }
}
