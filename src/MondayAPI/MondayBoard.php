<?php

namespace TBlack\MondayAPI;

use TBlack\MondayAPI\ObjectTypes\Board;
use TBlack\MondayAPI\ObjectTypes\BoardKind;
use TBlack\MondayAPI\ObjectTypes\Column;
use TBlack\MondayAPI\ObjectTypes\Item;
use TBlack\MondayAPI\ObjectTypes\SubItem;
use TBlack\MondayAPI\Querying\Query;

class MondayBoard
{
    protected ?int $board_id = null;

    protected ?int $group_id = null;

    protected $api;

    public const TYPE_QUERY = 'query';

    public const TYPE_MUTATION = 'mutation';

    public function __construct(MondayAPI $api = null)
    {
        $this->api = $api ?? new MondayAPI();
    }

    /**
     * @deprecated Inject a MondayAPI instance with token already set.
     */
    public function setToken(Token $token): self
    {
        $this->api->setToken($token);

        return $this;
    }

    public function on(int $board_id): self
    {
        $this->board_id = $board_id;

        return $this;
    }

    public function group(string $group_id): self
    {
        $this->group_id = $group_id;

        return $this;
    }

    public function create(string $board_name, string $board_kind = BoardKind::PRV, array $optionals = []): mixed
    {
        $Board = new Board();

        $arguments = array_merge(['board_name' => $board_name], $optionals);

        $create = Query::create(
            'create_board',
            $Board->getArguments($arguments, Board::$create_item_arguments, ' board_kind:'.$board_kind.', '),
            $Board->getFields(['id'])
        );

        return $this->api->request($create, self::TYPE_MUTATION);
    }

    public function archiveBoard(array $fields = [])
    {
        $Board = new Board();

        $arguments = [
            'board_id' => $this->board_id,
        ];

        $create = Query::create(
            'archive_board',
            $Board->getArguments($arguments, Board::$archive_arguments),
            $Board->getFields($fields)
        );

        return $this->api->request($create, self::TYPE_MUTATION);
    }

    public function getBoards(array $arguments = [], array $fields = [])
    {
        $Board = new Board();

        if ($this->board_id !== null && ! isset($arguments['ids'])) {
            $arguments['ids'] = $this->board_id;
        }

        $boards = Query::create(
            Board::$scope,
            $Board->getArguments($arguments),
            $Board->getFields($fields)
        );

        return $this->api->request($boards, self::TYPE_QUERY);
    }

    public function getColumns(array $fields = [])
    {
        $Column = new Column();
        $Board = new Board();

        $columns = Query::create(
            Column::$scope,
            '',
            $Column->getFields($fields)
        );

        $boards = Query::create(
            Board::$scope,
            $Board->getArguments(['ids' => $this->board_id]),
            [$columns]
        );

        return $this->api->request($boards, self::TYPE_QUERY);
    }

    public function addItem(string $item_name, array $items = [], $create_labels_if_missing = false)
    {
        if (! $this->board_id) {
            throw new \InvalidArgumentException('Board ID is required.');
        }

        $arguments = [
            'board_id' => $this->board_id,
            'item_name' => $item_name,
            'column_values' => Column::newColumnValues($items),
        ];

        if (isset($this->group_id)) {
            $arguments['group_id'] = $this->group_id;
        }

        $Item = new Item();

        $create = Query::create(
            'create_item',
            $Item->getArguments($arguments, Item::$create_item_arguments),
            $Item->getFields(['id'])
        );

        if ($create_labels_if_missing) {
            $create = str_replace('}"){', '}", create_labels_if_missing:true){', $create);
        }

        return $this->api->request($create, self::TYPE_MUTATION);
    }

    public function addSubItem(int $parent_item_id, string $item_name, array $items = [])
    {
        $arguments = [
            'parent_item_id' => $parent_item_id,
            'item_name' => $item_name,
            'column_values' => Column::newColumnValues($items),
        ];

        $SubItem = new SubItem();

        $create = Query::create(
            'create_subitem',
            $SubItem->getArguments($arguments, SubItem::$create_item_arguments),
            $SubItem->getFields(['id'])
        );

        return $this->api->request($create, self::TYPE_MUTATION);
    }

    public function archiveItem(int $item_id)
    {
        $Item = new Item();

        $archive = Query::create(
            'archive_item',
            $Item->getArguments(['item_id' => $item_id], Item::$archive_delete_arguments),
            $Item->getFields(['id'])
        );

        return $this->api->request($archive, self::TYPE_MUTATION);
    }

    public function deleteItem(int $item_id)
    {
        $Item = new Item();

        $delete = Query::create(
            'delete_item',
            $Item->getArguments(['item_id' => $item_id], Item::$archive_delete_arguments),
            $Item->getFields(['id'])
        );

        return $this->api->request($delete, self::TYPE_MUTATION);
    }

    public function changeMultipleColumnValues(int $item_id, array $column_values = [])
    {
        if (! $this->board_id || ! $this->group_id) {
            return -1;
        }

        $arguments = [
            'board_id' => $this->board_id,
            'item_id' => $item_id,
            'column_values' => Column::newColumnValues($column_values),
        ];

        $Item = new Item();

        $create = Query::create(
            'change_multiple_column_values',
            $Item->getArguments($arguments, Item::$change_multiple_column_values),
            $Item->getFields(['id'])
        );

        return $this->api->request($create, self::TYPE_MUTATION);
    }

    public function customQuery($query)
    {
        return $this->api->request($query, self::TYPE_QUERY);
    }

    public function customMutation($query, $variables = null)
    {
        return $this->api->request($query, self::TYPE_MUTATION, $variables);
    }
}
