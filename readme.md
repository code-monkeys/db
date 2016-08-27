# Record

Tiny mysql library.


[![Travis Status](https://api.travis-ci.org/dotser/record.svg?branch=master)](https://travis-ci.org/dotser/record)
[![Latest Stable Version](https://poser.pugx.org/dotser/record/v/stable)](https://packagist.org/packages/dotser/record)
[![Total Downloads](https://poser.pugx.org/dotser/record/downloads)](https://packagist.org/packages/dotser/record)
[![Coverage Status](https://coveralls.io/repos/github/dotser/record/badge.svg?branch=master)](https://coveralls.io/github/dotser/record?branch=master)


### Usage

```php
<?php
use Dotser\Record;

// Define connection details
Record::config([
    "host" => "db01.internal",
    "user" => "web",
    "pass" => "secret",
    "db"   => "shop",
]);

// Use mysql object
$rec  = new Record();
$rows = $rec->query("SELECT * FROM cart WHERE user_id = 123");
print_r($rows); // array of rows

$ok = $rec->update("UPDATE cart SET updated = NOW() WHERE id = 456");
print_r($ok); // boolean
```

The config can also come from a URL string:

```php
use Dotser\Record;

Record::fromUrl("mysql://username:password@localhost/test");
$rec  = new Record();
$rows = $rec->query("SELECT * FROM cart WHERE user_id = 123");
print_r($rows); // array of rows
```

### API

```php
class RecordInterface
{

    public static function config($name = null, $value = null, $default = null);
    public static function fromUrl(string $url): void;

    public function read(string $sql): array;
    public function write(string $sql): int;

}
```
