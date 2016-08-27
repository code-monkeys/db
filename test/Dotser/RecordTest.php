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

    public function testConfigMergeArray()
    {
        $config = ["user" => __FILE__];
        Record::config($config);
        $this->assert(__FILE__, Record::config("user"));
        exit('<pre>' . print_r(Record::config(), true) . '</pre>' . PHP_EOL);
    }

}
