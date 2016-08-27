# Record

A small mysql library.



## Installation

```
composer require m/record
```


## Usage

```php
use M\Record;

Record::config([
    "host" => "db01.internal",
    "user" => "web",
    "pass" => "secret",
    "db"   => "shop",
]);

$rows = Record::read("SELECT * FROM cart WHERE user_id = 123");
// returns array of associative arrays

$num = Record::write("UPDATE cart SET updated = NOW() WHERE id = 456");
// returns number of affected rows
```

## API

```php
interface RecordInterface
{
    public static function config($name = null, $value = null);
    public static function fromUrl(string $url): void;

    public function read(string $sql): array;
    public function write(string $sql): int;
}
```


Extend the class:

```php
class Dao extends Record
{
    protected function exec($sql)
    {
        // Now you can intercept the queries and so on
        parent::exec($sql);
    }

    public function save($id, array $data)
    {
        // $sql = "INSERT ...";
        parent::write($sql);
    }
}
```


The config can be parsed from a URL string and changed at will:

```php
Record::fromUrl("mysql://username:password@localhost/test");
$user   = Record::config("user");                   // get one item back
$config = Record::config();                         // get all current config back
$old    = Record::config("host", "db02.internal");  // change one item, returns old value
```


## Status

[![Travis Status](https://api.travis-ci.org/dotser/record.svg?branch=master)](https://travis-ci.org/dotser/record)
[![Latest Stable Version](https://poser.pugx.org/m/record/v/stable)](https://packagist.org/packages/m/record)
[![Total Downloads](https://poser.pugx.org/m/record/downloads)](https://packagist.org/packages/m/record)
[![Coverage Status](https://coveralls.io/repos/github/dotser/record/badge.svg?branch=master)](https://coveralls.io/github/dotser/record?branch=master)
