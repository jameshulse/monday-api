<?php

namespace TBlack\MondayAPI\ObjectTypes;

class User extends ObjectModel
{
    // Query scope
    public static string $scope = 'owner';

    // Arguments
    public static array $arguments = [];

    // Fields
    public static array $fields = [];
}
