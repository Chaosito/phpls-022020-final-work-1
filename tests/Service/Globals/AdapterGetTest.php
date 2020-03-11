<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\Globals\AdapterGet;
use Service\Globals\GlobalsInterface;

final class AdapterGetTest extends TestCase
{
    const TEST_KEY = 'test_key';
    const TEST_VAL = 'test_val';

    public function testValidInterfaceOfAdapter(): void
    {
        $this->assertInstanceOf(
            GlobalsInterface::class,
            new AdapterGet()
        );
    }

    public function testEqualsValues(): void
    {
        $adapter = new AdapterGet();
        $adapter->set(self::TEST_KEY, self::TEST_VAL);

        $this->assertEquals(
            self::TEST_VAL,
            $adapter->get(self::TEST_KEY, null)
        );

        $this->assertEquals(
            $_GET[self::TEST_KEY],
            $adapter->get(self::TEST_KEY, null)
        );
    }
}