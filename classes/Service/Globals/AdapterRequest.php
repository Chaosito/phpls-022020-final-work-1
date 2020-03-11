<?php
namespace Service\Globals;

class AdapterRequest implements GlobalsInterface
{
    public function get($indexName, $defaultValue)
    {
        return $_REQUEST[$indexName] ?? $defaultValue;
    }

    public function set($indexName, $value)
    {
        return $_REQUEST[$indexName] = $value;
    }
}