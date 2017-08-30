<?php

namespace Anthill\Bitmap;


class BitmapOffset
{
    /**
     * @var int
     */
    private $chunkSize;

    /**
     * BitmapOffset constructor.
     * @param int $chunkSize
     * @throws \RangeException
     */
    public function __construct($chunkSize)
    {
        if ($chunkSize <= 0) {
            throw new \RangeException(sprintf('Chunk size must be greater than 0 got %s', $chunkSize));
        }

        $this->chunkSize = $chunkSize;
    }

    /**
     * @param $offset
     * @return int
     */
    public function getSegmentNumber($offset)
    {
        return (int)ceil($offset / $this->chunkSize);
    }

    /**
     * @param $offset
     * @return int
     */
    public function getSegmentOffset($offset)
    {
        $chunkOffset = ($offset % $this->chunkSize);
        if ($chunkOffset === 0) {
            return $this->chunkSize;
        }

        return $chunkOffset;
    }
}