<?php
namespace Service\Globals;

class GlobalsFactory
{
    /** @var GlobalsInterface */
    private static $adapter;

    public static function init(GlobalsInterface $adapter)
    {
        self::$adapter = $adapter;
    }

    public static function get($indexName, $defaultValue)
    {
        return self::$adapter->get($indexName, $defaultValue);
    }

    public static function set($indexName, $value)
    {
        return self::$adapter->set($indexName, $value);
    }
}