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

Register the config directory on your `composer.json` file as below:

```json
{
    "extra": {
        "iq-config": "iqomp/config/"
    }
}
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


## TODO

1. Form Validator
1. Formatter
