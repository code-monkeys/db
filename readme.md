# Record

A small mysql library.



## Installation

```
composer require m/record
```


## Usage

```php
use M\Record;

$rec = Record::fromConfig([
    "host" => "db01.internal",
    "user" => "app",
    "pass" => "secret",
    "db"   => "shop",
]);

$rows = $rec->read("SELECT * FROM cart WHERE user_id = 123");
// returns array of associative arrays

$num = $rec->write("UPDATE cart SET updated = NOW() WHERE id = 456");
// returns number of affected rows
```

## API

```php
interface RecordInterface
{
    public static function fromConfig(array $config);
    public static function fromUrl($url);

    public function read($sql);
    public function write($sql);
    public function config($key = null, $value = null);
}
```

The config can be parsed from a URL and changed at will:

```php
$rec  = Record::fromUrl("mysql://username:password@host/db");
$rec  = Record::fromUrl($_ENV["DATABASE_URL"]);

$user = $rec->config("user");                   // get one item back
$all  = $rec->config();                         // get all current config back
$old  = $rec->config("host", "db02.internal");  // change one item, returns old value
```


## Status

[![Travis Status](https://api.travis-ci.org/dotser/record.svg?branch=master)](https://travis-ci.org/dotser/record)
[![Latest Stable Version](https://poser.pugx.org/m/record/v/stable)](https://packagist.org/packages/m/record)
[![Total Downloads](https://poser.pugx.org/m/record/downloads)](https://packagist.org/packages/m/record)
[![Coverage Status](https://coveralls.io/repos/github/dotser/record/badge.svg?branch=master)](https://coveralls.io/github/dotser/record?branch=master)
