<?php

namespace TBlack\MondayAPI\ObjectTypes;

class Item extends ObjectModel
{
    public static string $scope = 'items';

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
        'board_id' => 'Int',
        'group_id' => 'String',
        'item_name' => 'String',
        'column_values' => '!JSON',
    ];

    public static $change_multiple_column_values = [
        'board_id' => '!Int',
        'item_id' => 'Int',
        'column_values' => '!JSON',
    ];

    public static $archive_delete_arguments = [
        'item_id' => 'Int',
    ];
}
