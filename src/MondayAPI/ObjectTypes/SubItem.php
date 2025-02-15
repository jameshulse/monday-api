<?php

namespace TBlack\MondayAPI\ObjectTypes;

class SubItem extends ObjectModel
{
    public static string $scope = 'subitems';

    // Arguments
    public static array $arguments = [
        'limit' => ['type' => 'Int',     'validate' => 'isInt'],
        'page' => ['type' => 'Int',     'validate' => 'isInt'],
        'ids' => ['type' => '[Int]',   'validate' => 'isArrayInt'],
        'newest_first' => ['type' => 'Boolean',   'validate' => 'isBool'],
    ];

    // Fields
    public static array $fields = [
        'assets' => ['type' => '[Asset]', 'object' => 'Asset'],
        'board' => ['type' => 'Board', 'object' => 'Board'],
        'column_values' => ['type' => '[ColumnValue]', 'object' => 'ColumnValue'],
        'created_at' => ['type' => 'String'],
        'creator' => ['type' => 'User', 'object' => 'User'],
        'creator_id' => ['type' => '!String'],
        'group' => ['type' => 'Group', 'object' => 'Group'],
        'id' => ['type' => '!ID'],
        'name' => ['type' => '!String'],
        'state' => ['type' => 'State', 'object' => 'State'],
        'subscribers' => ['type' => '![User]', 'object' => 'User'],
        'updated_at' => ['type' => 'String'],
        'updates' => ['type' => '[Update]', 'object' => 'Update'],
    ];

    public static $create_item_arguments = [
        'parent_item_id' => 'Int',
        'item_name' => 'String',
        'column_values' => '!JSON',
    ];
}
