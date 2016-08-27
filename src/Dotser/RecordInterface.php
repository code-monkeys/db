<?php
namespace Dotser;


interface RecordInterface
{

    public static function config($name = null, $value = null);
    public static function fromUrl($url);

    public function read($sql);
    public function write($sql);

}
