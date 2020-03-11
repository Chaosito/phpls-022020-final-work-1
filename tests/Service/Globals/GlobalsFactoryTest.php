<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\Globals\GlobalsFactory;
use Service\Globals\GlobalsInterface;

class AdapterMock implements GlobalsInterface
{
    private $adapter = [];

    public function get($indexName, $defaultValue)
    {
        return $this->adapter[$indexName] ?? $defaultValue;
    }

    public function set($indexName, $value)
    {
        return $this->adapter[$indexName] = $value;
    }
}

final class GlobalsFactoryTest extends TestCase
{
    const TEST_KEY = 'test_key';
    const TEST_VAL = 'test_val';

    public function testEqualsMockValues(): void
    {
        $mock = new AdapterMock();
        $mock->set(self::TEST_KEY, self::TEST_VAL);

        GlobalsFactory::init($mock);

        $this->assertEquals(
            $mock->get(self::TEST_KEY, 0),
            GlobalsFactory::get(self::TEST_KEY, -1)
        );

    }
}