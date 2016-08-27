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

}
