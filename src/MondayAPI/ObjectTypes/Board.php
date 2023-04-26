<?php

namespace TBlack\MondayAPI\ObjectTypes;

class Board extends ObjectModel
{
    public static string $scope = 'boards';

    // Arguments
    public static array $arguments = [
        'limit' => ['type' => 'Int',     'validate' => 'isInt'],
        'page' => ['type' => 'Int',     'validate' => 'isInt'],
        'ids' => ['type' => '[Int]',   'validate' => 'isArrayInt'],
        'board_kind' => ['type' => 'BoardKind', 'validate' => 'isBoardKind'],  // (public / private / share)
        'state' => ['type' => 'State',   'validate' => 'isState'],  // (all / active / archived / deleted)
        'newest_first' => ['type' => 'Boolean',   'validate' => 'isBool'],
    ];

    // Fields
    public static array $fields = [
        'activity_logs' => ['type' => '[ActivityLogType]', 'object' => 'ActivityLogType'],
        'board_folder_id' => ['type' => 'Int'],
        'board_kind' => ['type' => 'BoardKind'],
        'columns' => ['type' => '[Column]', 'object' => 'Column'],
        'communication' => ['type' => 'JSON'],
        'description' => ['type' => 'String'],
        'groups' => ['type' => '[Group]', 'object' => 'Group'],
        'id' => ['type' => '!ID'],
        'items' => ['type' => '[Item]', 'object' => 'Item'],
        'name' => ['type' => '!String'],
        'owner' => ['type' => '!User', 'object' => 'User'],
        'permissions' => ['type' => '!String'],
        'pos' => ['type' => 'String'],
        'state' => ['type' => '!State'],
        'subscribers' => ['type' => '![User]', 'object' => 'User'],
        'tags' => ['type' => '[Tag]', 'object' => 'Tag'],
        'top_group' => ['type' => '!Group', 'object' => 'Group'],
        'updates' => ['type' => '[Update]', 'object' => 'Update'],
        'views' => ['type' => '[BoardView]', 'object' => 'BoardView'],
    ];

    public static $create_item_arguments = [
        'board_name' => '!String',
        'board_kind' => '!BoardKind',
        'folder_id' => 'Int',
        'workspace_id' => 'Int',
        'template_id' => 'Int',
    ];

    public static $change_multiple_column_values = [
        'board_id' => '!Int',
        'item_id' => 'Int',
        'column_values' => '!JSON',
    ];

    public static $archive_arguments = [
        'board_id' => '!Int',
    ];
}
