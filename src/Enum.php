<?php

/**
 * Enum object
 * @package iqomp/enum
 * @version 2.0.0
 */

namespace Iqomp\Enum;

use Hyperf\Utils\ApplicationContext;
use Hyperf\Contract\TranslatorInterface;

class Enum implements \JsonSerializable
{
    protected $label;
    protected $value;
    protected $options;

    public function __construct(string $name, $value = null, string $type = null)
    {
        $options = config('enum.enums.' . $name);

        if (!$options) {
            throw new EnumNotFoundException('Selected enum not found');
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
        $this->label = $options[$value] ?? 'unknown';

        if (function_exists('trans')) {
            $translator = ApplicationContext::getContainer()->get(TranslatorInterface::class);
            $translator->addNamespace('enum', 'enum');
            $trans_key = vsprintf('%s::%s.%s', ['enum', $name, $this->label]);
            $label = trans($trans_key);

            if ($trans_key != $label) {
                $this->label = $label;
            }
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
