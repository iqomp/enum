# iqomp/enum

Static data enum provider. This module provide list of enums that may used by
application. This module use `iqomp/config` to collect all application enum data

## Installation

```bash
composer require iqomp/enum
```

## Configuration

To add new enum data or modify exists one, create new file under folder `iqomp/config`
with name `enum.php` with content as below inside of module main directory:

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

Register the config directory on your module `composer.json` file as below:

```json
{
    "extra": {
        "iqomp/config": "iqomp/config/"
    }
}
```

## Translation

If you want the enum label to be translated, make sure to install module
[iqomp/locale](https://github.com/iqomp/locale). Add new translation on your
module directory with domain `enum.[enum-name]`. Register the translation in
your `composer.json` file as below:

```json
{
    "extra": {
        "iqomp/locale": "locale/"
    }
}
```

And create translation domain with name `enum.[enum-name].php` under folder
`locale/`:

```php
<?php
// enum.gender.php

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
$enum = new Enum('gender', '2', 'str');

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

## Unit Test

Run below script to run unit test:

```bash
composer test
```

## Linter

Run below script to run psr-12 linter:

```bash
composer lint
```

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
        'enum' => 'gender'
    ]
    // ...
```

## TODO

1. Formatter
