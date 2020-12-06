<?php
declare(strict_types=1);

namespace Iqomp\Enum\Tests;

use PHPUnit\Framework\TestCase;
use Iqomp\Enum\Enum;
use Iqomp\Config\Fetcher;
use Iqomp\Enum\EnumNotFoundException;

final class EnumTest extends TestCase
{
    public function testEnumNotFound(): void
    {
        $this->expectException(EnumNotFoundException::class);
        $enum = new Enum('not', '1');
    }

    public function testValue(): void{
        $enum = new Enum('std-gender', '1');
        $this->assertEquals('1', $enum->value);
    }

    public function testValueStr(): void{
        $enum = new Enum('std-gender', 1, 'str');
        $this->assertIsString($enum->value);
    }

    public function testValueInt(): void{
        $enum = new Enum('std-gender', '1', 'int');
        $this->assertIsInt($enum->value);
    }

    public function testLabel(): void{
        $enum = new Enum('std-gender', '1');
        $this->assertEquals('Male', $enum->label);
    }

    public function testLabelToString(): void{
        $enum = new Enum('std-gender', '1');
        $this->assertEquals('Male', (string)$enum);
    }

    public function testJsonString(): void{
        $enum = new Enum('std-gender', '1', 'int');
        $this->assertJsonStringEqualsJsonString(
            json_encode($enum),
            json_encode(['label'=>'Male','value'=>1])
        );
    }
}
