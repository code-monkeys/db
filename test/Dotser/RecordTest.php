<?php
namespace Dotser;


class RecordTest extends \PHPUnit_Framework_TestCase
{

    protected $object = null;

    public function setup()
    {
        $this->object = new Record();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf("Dotser\Record", $this->object);
    }

    public function testConfigGetArray()
    {
        $return = Record::config();
        $this->assertTrue(is_array($return));
        $this->assertTrue(isset($return["user"]));
    }

    public function testConfigGetOneValue()
    {
        $return = Record::config("user");
        $this->assertNotNull($return);
    }

    public function testConfigMergeArray()
    {
        $name  = "user";
        $value = __FILE__;
        Record::config([$name => $value]);
        $this->assertEquals($value, Record::config($name));
    }

    public function testConfigOneValue()
    {
        $name  = "host";
        $value = "test";
        Record::config($name, $value);
        $this->assertEquals($value, Record::config($name));
    }

    public function testFromUrl()
    {
        $url = "mysql://username:passord@some-host:3344/some-db";
        Record::fromUrl($url);

        $this->assertEquals("username", Record::config("user"));
        $this->assertEquals("passord", Record::config("pass"));
        $this->assertEquals("some-host", Record::config("host"));
        $this->assertEquals("some-db", Record::config("db"));
    }

}
