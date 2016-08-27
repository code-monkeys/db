<?php
namespace M;


interface RecordInterface
{

    public static function fromConfig(array $config);
    public static function fromUrl($url);

    public function read($sql);
    public function write($sql);
    public function config($name = null, $value = null);

}
