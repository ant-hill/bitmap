<?php

namespace Anthill\Bitmap;

use RangeException;

class BitHelper
{
    /**
     * @param $val
     * @throws \RangeException
     */
    private static function checkOffset($val)
    {
        if ($val <= 0) {
            throw new RangeException(sprintf('Offset must be greater than 0 got %s', $val));
        }
    }

    /**
     * @param $val
     * @throws \RangeException
     */
    private static function checkValue($val)
    {
        if ($val < 0) {
            throw new RangeException(sprintf('Value must be greater or equal 0 got %s', $val));
        }
    }

    /**
     * @param int $position
     * @param int $value
     * @return int
     * @throws \RangeException
     */
    public static function add($position, $value)
    {
        self::checkOffset($position);
        self::checkValue($value);
        $value |= (1 << ($position - 1));

        return $value;
    }

    /**
     * @param $position
     * @param $value
     * @return int
     * @throws \RangeException
     */
    public static function del($position, $value)
    {
        self::checkOffset($position);
        self::checkValue($value);
        $value &= ~(1 << ($position - 1));

        return $value;
    }

    /**
     * @param $position
     * @param $value
     * @return bool
     * @throws \RangeException
     */
    public static function has($position, $value)
    {
        self::checkOffset($position);
        self::checkValue($value);

        $result = $value & (1 << ($position - 1));

        return $result > 0;
    }
}
