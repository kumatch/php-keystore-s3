<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverReadTest extends TestCase
{
    protected $methodName = "read";

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function readExistsKey()
    {
        $key = "/foo/bar/../baz/../quux";
        $accessKey = "s3://{$this->bucket}/foo/quux";
        $value = "hello, world";

        $access = $this->getAccess(array('isFile', 'get'));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(true));
        $access->expects($this->once())
            ->method('get')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue($value));

        $driver = $this->getDriver();

        $this->assertEquals($value, $driver->read($key));
    }

    /**
     * @test
     */
    public function readNotExistsKey()
    {
        $key = "foo/bar/./baz/";
        $accessKey = "s3://{$this->bucket}/foo/bar/baz";

        $access = $this->getAccess(array('isFile', 'get'));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(false));
        $access->expects($this->never())
            ->method('get');

        $driver = $this->getDriver();

        $this->assertNull($driver->read($key));
    }
}