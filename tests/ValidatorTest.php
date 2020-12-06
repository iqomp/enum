<?php
declare(strict_types=1);

namespace Iqomp\Enum\Tests;

use PHPUnit\Framework\TestCase;
use Iqomp\Validator\Validator;

final class ValidatorTest extends TestCase
{
    public function testEnumNotFound() {
        $object = (object)['gender' => 1];
        $rules  = [
            'gender' => [
                'rules' => [
                    'enum' => 'non-exists-enum'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $this->assertArrayHasKey('gender', $error);
    }

    public function testEnumNotFoundCode() {
        $object = (object)['gender' => 1];
        $rules  = [
            'gender' => [
                'rules' => [
                    'enum' => 'non-exists-enum'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $code = $error['gender']->code;
        $this->assertEquals('22.0', $code);
    }

    public function testSingleValueNotFound(): void{
        $object = (object)[
            'gender' => 12
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);
        $this->assertArrayHasKey('gender', $error);
    }

    public function testSingleValueNotFoundCode(): void{
        $object = (object)[
            'gender' => 12
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $code = $error['gender']->code;
        $this->assertEquals('22.1', $code);
    }

    public function testArrayValueNotFound(): void{
        $object = (object)[
            'gender' => [1,12]
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);
        $this->assertArrayHasKey('gender', $error);
    }

    public function testArrayValueNotFoundCode(): void{
        $object = (object)[
            'gender' => [2,12]
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $code = $error['gender']->code;
        $this->assertEquals('22.2', $code);
    }

    public function testSuccess(): void
    {
        $object = (object)[
            'gender' => 2
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $this->assertEquals([], $error);
    }

    public function testSuccessNull(): void
    {
        $object = (object)[
            'gender' => null
        ];
        $rules = [
            'gender' => [
                'rules' => [
                    'enum' => 'std-gender'
                ]
            ]
        ];

        list($result, $error) = Validator::validate($rules, $object);

        $this->assertEquals([], $error);
    }
}
