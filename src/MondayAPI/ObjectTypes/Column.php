<?php

namespace TBlack\MondayAPI\ObjectTypes;

class Column extends ObjectModel
{
    public static string $scope = 'columns';

    // Fields
    public static array $fields = [
        'archived' => ['type' => '!Boolean'],
        'id' => ['type' => '!ID'],
        'pos' => ['type' => 'String'],
        'settings_str' => ['type' => '!String'],
        'title' => ['type' => '!String'],
        'type' => ['type' => '!String'],
        'width' => ['type' => 'Int'],
    ];

    public static function newColValue($id_column, $value)
    {
        return $value;
    }

    public static function newColumnValues($itens)
    {
        $column_values = [];
        if (! empty($itens)) {
            foreach ($itens as $key => $value) {
                $column_values[$key] = self::newColValue($key, $value);
            }
        }

        return addslashes(json_encode($column_values));
    }
}
