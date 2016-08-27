<?php
namespace M;


class RecordTest extends \PHPUnit_Framework_TestCase
{

    protected $object = null;

    public function setup()
    {
        $this->object = new Record();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf("M\Record", $this->object);
    }

    public function testConfigGetArray()
    {
        $return = $this->object->config();
        $this->assertTrue(is_array($return));
        $this->assertTrue(isset($return["user"]));
    }

    public function testConfigGetOneValue()
    {
        $return = $this->object->config("user");
        $this->assertNotNull($return);
    }

    public function testConfigMergeArray()
    {
        $name  = "user";
        $value = __FILE__;
        $this->object->config([$name => $value]);
        $this->assertEquals($value, $this->object->config($name));
    }

    public function testConfigOneValue()
    {
        $name  = "host";
        $value = "test";
        $this->object->config($name, $value);
        $this->assertEquals($value, $this->object->config($name));
    }

    public function testConfigSetGetOldValue()
    {
        $name = "host";
        $old  = "old";
        $new  = "new";

        $ignored  = $this->object->config($name, $old);
        $returned = $this->object->config($name, $new);
        $this->assertEquals($old, $returned);
    }

    public function testFromUrl()
    {
        $url = "mysql://username:passord@some-host:3344/some-db";
        $obj = Record::fromUrl($url);

        $this->assertEquals("username",   $obj->config("user"));
        $this->assertEquals("passord",    $obj->config("pass"));
        $this->assertEquals("some-host",  $obj->config("host"));
        $this->assertEquals("some-db",    $obj->config("db"));
    }

}
