<?php
namespace Service\Globals;

interface GlobalsInterface
{
    public function get($indexName, $defaultValue);
    public function set($indexName, $value);
}