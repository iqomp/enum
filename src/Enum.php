<?php

/**
 * Enum object
 * @package iqcomp/enum
 * @version 0.0.1
 */

namespace Iqomp\Enum;

use Iqomp\Config\Fetcher as Config;
use Iqomp\Locale\Locale;

class Enum implements \JsonSerializable
{
    protected $label;
    protected $value;
    protected $options;

    public function __construct(string $name, $value = null, string $type = null)
    {
        $options = Config::get('enum', 'enums', $name);

        if (!$options) {
            return;
        }

        $this->options = $options;
        if (is_null($value)) {
            return;
        }

        if ($type) {
            switch ($type) {
                case 'int':
                    $value = (int)$value;
                    break;
                case 'str':
                    $value = (string)$value;
                    break;
            }
        }

        $this->value = $value;
        $this->label = $options[$value] ?? null;

        if ($this->label && class_exists('Iqomp\\Locale\\Locale')) {
            $this->label = Locale::translate($this->label, [], 'enum.' . $name);
        }
    }

    public function __get($name)
    {
        if (!in_array($name, ['value','label','options'])) {
            return null;
        }

        return $this->$name;
    }

    public function __toString()
    {
        return $this->label;
    }

    public function jsonSerialize()
    {
        return [
            'label' => $this->label,
            'value' => $this->value
        ];
    }
}
