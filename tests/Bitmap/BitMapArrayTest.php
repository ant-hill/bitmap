<?php

namespace Anthill\Bitmap\Tests;


use PHPUnit_Framework_TestCase;
use Anthill\Bitmap\BitMapArray;
use Anthill\Bitmap\BitmapOffset;

class BitMapArrayTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param array $data
     * @param int $chunk
     * @return BitMapArray
     */
    protected function getBitMapArray(array $data, $chunk = 4)
    {
        return new BitMapArray(new BitmapOffset($chunk), $data);
    }

    public function addProvider()
    {
        return [
            [4, [], 1, [1]],
            [4, [], 2, [2]],
            [4, [], 3, [4]],
            [4, [], 4, [8]],
            [4, [1], 1, [1]],
            [4, [1], 2, [3]],
            [4, [1], 3, [5]],
            [4, [1], 8, [1, 8]],
            [4, [], 8, [1 => 8]],
            [4, [], 15, [3 => 4]],
        ];
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($chunk, array $data, $offset, array $expected)
    {
        $bitArray = $this->getBitMapArray($data, $chunk);
        $this->assertSame($expected, $bitArray->add($offset)->toArray());

    }


    public function hasProvider()
    {
        return [
            [4, [1], 1, true],
            [4, [], 2, false],
            [4, [], 100500, false],
            [4, [3], 1, true],
            [4, [3], 2, true],
            [4, [3], 3, false],
            [4, [2 => 3, 10 => 1], 10, true],
            [4, [2 => 3, 5 => 1], 21, true],
            [4, [2 => 3, 5 => 1], 24, false],
        ];
    }

    /**
     * @dataProvider hasProvider
     */
    public function testHas($chunk, array $data, $offset, $expected)
    {
        $bitArray = $this->getBitMapArray($data, $chunk);
        $this->assertSame($expected, $bitArray->has($offset));
    }

    public function checkDoesntCorruptData()
    {
        $bitArray = $this->getBitMapArray([1], 4);
        $bitArray->has(5);
        $this->assertSame([1], $bitArray->toArray());
    }

    public function delProvider()
    {
        return [
            [4, [1], 1, [0]],
            [4, [2], 1, [2]],
            [4, [5], 1, [4]],
            [4, [0 => 5, 3 => 7], 3, [0 => 1, 3 => 7]],
            [4, [0 => 5, 3 => 7], 15, [0 => 5, 3 => 3]],
        ];
    }

    /**
     * @dataProvider delProvider
     */
    public function testDel($chunk, array $data, $offset, array $expected)
    {
        $bitArray = $this->getBitMapArray($data, $chunk);
        $this->assertSame($expected, $bitArray->del($offset)->toArray());
    }

}