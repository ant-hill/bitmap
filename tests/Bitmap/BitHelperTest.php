<?php

namespace Anthill\Bitmap\Tests;


use PHPUnit_Framework_TestCase;
use Anthill\Bitmap\BitHelper;

class BitHelperTest extends PHPUnit_Framework_TestCase
{
    public function offsetProvider()
    {
        return [
            ['add', 0],
            ['add', -1],
            ['del', 0],
            ['del', -1],
            ['has', 0],
            ['has', -1],
        ];
    }

    /**
     * @dataProvider offsetProvider
     */
    public function testOffsetException($method, $offset)
    {
        $this->setExpectedException(\RangeException::class);
        BitHelper::$method($offset, 1);
    }

    public function valueProvider()
    {
        return [
            ['add', -1],
            ['del', -1],
            ['has', -1],
        ];
    }

    /**
     * @dataProvider valueProvider
     */
    public function testValueException($method, $value)
    {
        $this->setExpectedException(\RangeException::class);
        BitHelper::$method(1, $value);
    }

    public function testAdd()
    {
        $this->assertEquals(1, BitHelper::add(1, 0));
        $this->assertEquals(3, BitHelper::add(1, 2));
        $this->assertEquals(7, BitHelper::add(3, BitHelper::add(2, BitHelper::add(1, 1))));
    }

    public function testHas()
    {
        $this->assertTrue(BitHelper::has(1, 1));
        $this->assertTrue(BitHelper::has(2, 2));
        $this->assertTrue(BitHelper::has(3, 4));
        $this->assertTrue(BitHelper::has(1, 7));
        $this->assertTrue(BitHelper::has(2, 7));
        $this->assertTrue(BitHelper::has(3, 7));
        $this->assertFalse(BitHelper::has(4, 7));
    }

    public function testDelete()
    {
        $this->assertSame(1, BitHelper::del(2, 3));
        $this->assertSame(6, BitHelper::del(1, 7));
    }
}