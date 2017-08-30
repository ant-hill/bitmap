<?php

namespace Anthill\Bitmap\Tests;


use Anthill\Bitmap\BitmapOffset;
use PHPUnit_Framework_TestCase;

class BitmapOffsetTest extends PHPUnit_Framework_TestCase
{
    public function getterProvider()
    {
        return [
            [1],
            [2],
            [100500],
        ];
    }

    /**
     * @dataProvider getterProvider
     * @param $chunkSize
     */
    public function testGetter($chunkSize)
    {
        $class = new BitmapOffset($chunkSize);
        $this->assertSame($chunkSize, $class->getChunkSize());
    }

    public function offsetProvider()
    {
        return [
            [0],
            [-1],
        ];
    }

    /**
     * @dataProvider offsetProvider
     * @param int $chunkSize
     */
    public function testOffsetException($chunkSize)
    {
        $this->setExpectedException(\RangeException::class);
        new BitmapOffset($chunkSize);
    }


    public function segmentNumProvider()
    {
        return [
            [1, 1, 1],
            [1, 2, 2],
            [32, 33, 2],
            [32, 12, 1],
            [32, 32, 1],
            [32, 65, 3],
        ];
    }

    /**
     * @dataProvider segmentNumProvider
     * @param $chunkSize
     * @param $offset
     * @param $expected
     */
    public function testChunkNum($chunkSize, $offset, $expected)
    {
        $bm = new BitmapOffset($chunkSize);
        $this->assertSame($expected, $bm->getSegmentNumber($offset));
    }

    public function segmentOffsetProvider()
    {
        return [
            [1, 1, 1],
            [1, 2, 1],
            [1, 3, 1],
            [1, 4, 1],
            [32, 33, 1],
            [32, 12, 12],
            [32, 32, 32],
            [32, 65, 1],
            [4, 1, 1],
            [4, 2, 2],
            [4, 3, 3],
            [4, 4, 4],
            [4, 5, 1],
            [4, 6, 2],
            [4, 7, 3],
            [4, 8, 4],
            [4, 9, 1],
            [4, 10, 2],
            [4, 11, 3],
            [4, 12, 4],
            [2, 1, 1],
            [2, 2, 2],
            [2, 3, 1],
        ];
    }


    /**
     * @dataProvider segmentOffsetProvider
     * @param $chunkSize
     * @param $offset
     * @param $expected
     */
    public function testChunkOffset($chunkSize, $offset, $expected)
    {
        $bm = new BitmapOffset($chunkSize);
        $this->assertSame($expected, $bm->getSegmentOffset($offset));
    }
}