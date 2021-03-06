# iqomp/enum

Static data enum provider. This module provide list of enums that may used by
application.

## Installation

```bash
composer require iqomp/enum
```

## Publishing Config

```bash
php bin/hyperf.php vendor:publish iqomp/enum
```

## Configuration

To add new enum data or modify exists one, modify file on
`/config/autoload/enum.php` to return data as below:

```php
<?php

return [
    'enums' => [
        'gender' => [
            '0' => 'Unknown',
            '1' => 'Male',
            '2' => 'Female',
            '3' => 'Non-Binary'
        ]
    ]
];
```

Or if you prefer to use file `ConfigProvider.php`, add data as below:

```php
<?php

// ...
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'enum' => [
                'enums' => [
                    'gender' => [
                        '0' => 'Unknown',
                        '1' => 'Male',
                        '2' => 'Female',
                        '3' => 'Non-Binary'
                    ]
                ]
            ]
        ];
    }
}
```

Make sure to update your `composer.json` file to let hyperf identify the config file:

```json
    "extra": {
        "hyperf": {
            "config": "Vendor\\Module\\ConfigProvider"
        }
    }
```

## Translation

If you want the enum label to be translated, make sure to install module
[hyperf/translation](https://github.com/hyperf/translation). Add new translation
on folder `storage/languages/vendor/enum/{locale}/{enum-name}.php`.

```php
<?php
// gender.php

return [
    'Unknown'    => 'Unknown',
    'Female'     => 'Female',
    'Male'       => 'Male',
    'Non-Binary' => 'Non Binary'
];
```

## Usage

Use class `Iqomp\Enum\Enum` to create enum object with specified value.

```php
<?php

use Iqomp\Enum\Enum;

// $enum = new Enum('gender', '1', 'int');
$enum = new Enum('std-gender', '2', 'str');

$enum->value;
$enum->options;
$enum->label;
```

## Method

List of method defined by this class object:

### __construct(string $name, $value=null, string $type=null): Enum

Create new Enum object. This method accept parameters:

1. `name::string` The name of enum datalist.
1. `value::int|str` The value of enum item.
1. `type::string` Convert provided value as `int` or `str`.

### __get($name): mixed

Get enum data property, accepted name are `value`, `label`, and `options`.

### __toString(): string

Return string enum label.

### jsonSerialize()

Convert the enum to json_encode ready parameter.

## Form Validator

If you're using validator [iqomp/validator](https://github.com/iqomp/validator/)
for your object or form validator, this module add new form validator rule named
`enum` to validate if user provided data is in registered enum.

### enum => name

Make sure user provided value is in registered enum, the value of user posted data
can be single int/str or array of it.

```php
    // ...
    'rules' => [
        'enum' => 'std-gender'
    ]
    // ...
```

## Linter

Run below script to run psr-12 linter:

```bash
composer lint
```

## Formatter

If you're using formatter [iqomp/formatter](https://github.com/iqomp/formatter/)
for your object formatter, this module add new object format type named `enum`
and `multiple-enum` that can be use to convert object property value to enum
object.

### enum

Convert current object property value to `Iqomp\Enum\Enum` object.


```php
    // ...
    '/field/' => [
        'type' => 'enum',
        'enum' => 'std-gender'
    ]
    // ...
```

### multiple-enum

Convert current object property value to array of `Iqomp\Enum\Enum` with custom
separator:

```php
    // ...
    '/field/' => [
        'type' => 'multiple-enum',
        'enum' => 'std-gender',
        'separator' => ',' // PHP_EOL, 'json'
    ]
    // ...
```

If property `separator` is not set, `PHP_EOL` will be used. It also accept
separator `'json'` that will use `json_decode` for separation. If the value of
object property is already array, no separation/explode will used.
