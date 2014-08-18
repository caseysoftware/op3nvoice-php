<?php
include '../vendor/autoload.php';
include 'creds.php';

use \Mockery;

class BundleTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;

    public function setUp()
    {
        global $apikey;

        $this->bundle = new \Clarify\Bundle($apikey);
    }

    /**
     * @expectedException Clarify\Exceptions\InvalidResourceException
     */
    public function testCreate()
    {
        $name = 'name' . rand(0, 500);
        $media = 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav';

        $this->bundle->create($name, $media);
        $this->assertEquals(32, strlen($this->bundle->id));
        $this->assertEquals($name, strlen($this->bundle->name));
    }
}