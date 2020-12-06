<?php
declare(strict_types=1);

namespace Iqomp\Enum\Tests;

use PHPUnit\Framework\TestCase;
use Iqomp\Enum\Enum;
use Iqomp\Formatter\Formatter;
use Iqomp\Enum\EnumNotFoundException;

final class FormatterTest extends TestCase
{
    public function testEnumSingleNotSet(): void
    {
        $format = [
            'gender' => [
                'type' => 'enum'
            ]
        ];
        $object = (object)[
            'gender' => 1
        ];

        $this->expectException(EnumNotFoundException::class);

        $res = Formatter::formatApply($format, [$object]);
    }

    public function testEnumSingleNotFound(): void
    {
        $format = [
            'gender' => [
                'type' => 'enum',
                'enum' => 'not-exists'
            ]
        ];
        $object = (object)[
            'gender' => 1
        ];

        $this->expectException(EnumNotFoundException::class);

        $res = Formatter::formatApply($format, [$object]);
    }

    public function testEnumSingle()
    {
        $format = [
            'gender' => [
                'type' => 'enum',
                'enum' => 'std-gender'
            ]
        ];
        $object = (object)[
            'gender' => 1
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertInstanceOf(Enum::class, $res->gender);
    }

    public function testEnumSingleVTypeStr()
    {
        $format = [
            'gender' => [
                'type' => 'enum',
                'enum' => 'std-gender',
                'vtype' => 'str'
            ]
        ];
        $object = (object)[
            'gender' => 1
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsString($res->gender->value);
    }

    public function testEnumSingleVTypeInt()
    {
        $format = [
            'gender' => [
                'type' => 'enum',
                'enum' => 'std-gender',
                'vtype' => 'int'
            ]
        ];
        $object = (object)[
            'gender' => '1'
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsInt($res->gender->value);
    }

    public function testEnumMultipleNoSet(): void
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum'
            ]
        ];
        $object = (object)[
            'gender' => [1]
        ];

        $this->expectException(EnumNotFoundException::class);

        $res = Formatter::formatApply($format, [$object]);
    }

    public function testEnumMultipleNotFound(): void
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum',
                'enum' => 'not-exists'
            ]
        ];
        $object = (object)[
            'gender' => '1,2'
        ];

        $this->expectException(EnumNotFoundException::class);

        $res = Formatter::formatApply($format, [$object]);
    }

    public function testEnumMultiple()
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum',
                'enum' => 'std-gender'
            ]
        ];
        $object = (object)[
            'gender' => "1\n2"
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsArray($res->gender);

        foreach($res->gender as $gen)
            $this->assertInstanceOf(Enum::class, $gen);
    }

    public function testEnumMultipleNLSep()
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum',
                'enum' => 'std-gender',
                'separator' => PHP_EOL
            ]
        ];
        $object = (object)[
            'gender' => "1\n2"
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsArray($res->gender);

        foreach($res->gender as $gen)
            $this->assertInstanceOf(Enum::class, $gen);
    }

    public function testEnumMultipleNLComma()
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum',
                'enum' => 'std-gender',
                'separator' => ','
            ]
        ];
        $object = (object)[
            'gender' => "1,2"
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsArray($res->gender);

        foreach($res->gender as $gen)
            $this->assertInstanceOf(Enum::class, $gen);
    }

    public function testEnumMultipleJSONComma()
    {
        $format = [
            'gender' => [
                'type' => 'multiple-enum',
                'enum' => 'std-gender',
                'separator' => 'json'
            ]
        ];
        $object = (object)[
            'gender' => "[1,2]"
        ];

        $res = Formatter::formatApply($format, [$object]);
        $res = $res[0];

        $this->assertIsArray($res->gender);

        foreach($res->gender as $gen)
            $this->assertInstanceOf(Enum::class, $gen);
    }
}
