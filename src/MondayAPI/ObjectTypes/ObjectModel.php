<?php

namespace TBlack\MondayAPI\ObjectTypes;

use TBlack\MondayAPI\Querying\Query;

class ObjectModel
{
    // Query scope
    public static string $scope = '';

    // Arguments
    public static array $arguments = [];

    // Fields
    public static array $fields = [];

    public function __construct()
    {
        return $this;
    }

    public function getFields(array $fields = [], $alt_fields = false): array
    {
        return [Query::buildFields(
            Query::buildFieldsArgs(
                (!$alt_fields ? static::$fields : $alt_fields),
                $fields
            )
        )];
    }

    public function getArguments(array $arguments = [], $alt_arguments = false, string $prepend_args = ''): string
    {
        return Query::buildArguments(
            Query::buildArgsFields(
                (!$alt_arguments ? static::$arguments : $alt_arguments),
                $arguments
            ),
            $prepend_args
        );
    }

    public function getBuildFieldsArgs()
    {
        //return '{ ... }';
        return false;
    }
}
