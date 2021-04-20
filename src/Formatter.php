<?php

/**
 * Formatter
 * @package iqomp\enum
 * @version 2.0.0
 */

namespace Iqomp\Enum;

class Formatter
{
    protected static $enumReq = '`enum` property format config is required';

    public static function enum($value, $fld, $obj, $format)
    {
        $name  = $format['enum'] ?? null;
        $vtype = $format['vtype'] ?? null;

        if (!$name) {
            throw new EnumNotFoundException(self::$enumReq);
        }

        return new Enum($name, $value, $vtype);
    }

    public static function multipleEnum($value, $fld, $obj, $format)
    {
        $name  = $format['enum'] ?? null;
        $vtype = $format['vtype'] ?? null;
        $sep   = $format['separator'] ?? PHP_EOL;

        if (!$name) {
            throw new EnumNotFoundException(self::$enumReq);
        }

        $result = [];
        $vals   = $value;

        if (is_string($value)) {
            $vals = [];

            if ($sep === 'json') {
                $vals = json_decode($value);
            } else {
                $vals = explode($sep, $value);
            }
        }

        if (!$vals || !is_array($vals)) {
            return [];
        }

        foreach ($vals as $val) {
            $result[] = new Enum($name, $val, $vtype);
        }

        return $result;
    }
}
