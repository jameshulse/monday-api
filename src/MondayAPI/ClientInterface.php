<?php

namespace TBlack\MondayAPI;

interface ClientInterface
{
    public function request( $request, $type = 'query', $variables = null);
}