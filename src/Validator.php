<?php

/**
 * Validator rule
 * @package iqomp/enum
 * @version 1.2.0
 */

namespace Iqomp\Enum;

use Iqomp\Config\Fetcher as Config;

class Validator
{
    public static function enum($val, $opt)
    {
        if (is_null($val)) {
            return null;
        }

        $enum = Config::get('enum', 'enums', $opt);
        if (!$enum) {
            return ['22.0'];
        }

        if (!is_array($val)) {
            if (array_key_exists($val, $enum)) {
                return null;
            }
            return ['22.1'];
        }

        foreach ($val as $va) {
            if (!array_key_exists($va, $enum)) {
                return ['22.2'];
            }
        }

        return null;
    }
}
