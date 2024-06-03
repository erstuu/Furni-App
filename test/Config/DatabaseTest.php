<?php

namespace Restugedepurnama\Furni\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConnection(): void
    {
        $connection = Database::getConnection("test");
        $this->assertNotNull($connection);
    }

    public function testGetConnectionSingleton(): void
    {
        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();
        $this->assertSame($connection1, $connection2);
    }
}
