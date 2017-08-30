<?php

namespace Anthill\Bitmap;


class BitMapArray
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var BitmapOffset
     */
    private $bitMapOffset;

    /**
     * BitMapArray constructor.
     * @param array $data
     * @throws \RangeException
     */
    public function __construct(BitmapOffset $bitmapOffset, array $data)
    {
        $this->data = $data;
        $this->bitMapOffset = $bitmapOffset;
    }

    public function get($segmentNum)
    {
        if (!isset($this->data[$segmentNum])) {
            return 0;
        }

        return $this->data[$segmentNum];
    }

    private function set($segmentNum, $value)
    {
        $this->data[$segmentNum] = $value;
    }

    private function getSegmentNum($offset)
    {
        return $this->bitMapOffset->getSegmentNumber($offset) - 1;
    }

    /**
     * @param $offset
     * @return $this
     * @throws \RangeException
     */
    public function add($offset)
    {
        $segmentOffset = $this->bitMapOffset->getSegmentOffset($offset);
        $segmentNum = $this->getSegmentNum($offset);
        $mask = $this->get($segmentNum);
        $val = BitHelper::add($segmentOffset, $mask);
        $this->set($segmentNum, $val);

        return $this;
    }

    /**
     * @param $offset
     * @return $this
     * @throws \RangeException
     */
    public function del($offset)
    {
        $segmentOffset = $this->bitMapOffset->getSegmentOffset($offset);
        $segmentNum = $this->getSegmentNum($offset);
        $mask = $this->get($segmentNum);
        $val = BitHelper::del($segmentOffset, $mask);
        $this->set($segmentNum, $val);

        return $this;
    }

    /**
     * @param $offset
     * @return bool
     * @throws \RangeException
     */
    public function has($offset)
    {
        $segmentOffset = $this->bitMapOffset->getSegmentOffset($offset);
        $segmentNum = $this->getSegmentNum($offset);
        $mask = $this->get($segmentNum);

        return BitHelper::has($segmentOffset, $mask);
    }

    /**
     * @return array
     */
    public function offsets()
    {
        $size = $this->bitMapOffset->getChunkSize();
        $offsets = [];
        foreach ($this->data as $k => $offset) {
            if ($offset === 0) {
                continue;
            }
            for ($i = 1; $i <= $size; $i++) {
                if (BitHelper::has($i, $offset)) {
                    $offsets[] = ($k * $size) + $i;
                }
            }
        }

        return $offsets;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}