<?php

namespace Tegme\Utils;

class ArrayUtil
{
    /**
     * @param array $arr
     * @return bool
     */
    public static function isAssoc(array $arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
