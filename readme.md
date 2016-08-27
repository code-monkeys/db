# Record

A small mysql library.


### Usage

```php
<?php
use M\Record;

// Configure the connection
Record::config([
    "host" => "db01.internal",
    "user" => "web",
    "pass" => "secret",
    "db"   => "shop",
]);

// Create/extend an object
$rec = new Record();

// Reads data, returns array of associative arrays
$res = $rec->read("SELECT * FROM cart WHERE user_id = 123");
print_r($res);

// Writes stuff, returns number of affected rows
$num = $rec->write("UPDATE cart SET updated = NOW() WHERE id = 456");
print_r($num);
```

The config can also be parsed from a URL string:

```php
use Dotser\Record;

Record::fromUrl("mysql://username:password@localhost/test");
$user   = Record::config("user");                       // get one item back
$config = Record::config();                             // get all current config back
$old    = Record::config("host", "db02.internal");      // change one item, returns old value
```

### API

```php
interface RecordInterface
{

    public static function config($name = null, $value = null);
    public static function fromUrl(string $url): void;

    public function read(string $sql): array;
    public function write(string $sql): int;

}
```


### Status

[![Travis Status](https://api.travis-ci.org/dotser/record.svg?branch=master)](https://travis-ci.org/dotser/record)
[![Latest Stable Version](https://poser.pugx.org/dotser/record/v/stable)](https://packagist.org/packages/dotser/record)
[![Total Downloads](https://poser.pugx.org/dotser/record/downloads)](https://packagist.org/packages/dotser/record)
[![Coverage Status](https://coveralls.io/repos/github/dotser/record/badge.svg?branch=master)](https://coveralls.io/github/dotser/record?branch=master)
