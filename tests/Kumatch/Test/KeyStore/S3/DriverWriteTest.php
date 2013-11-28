<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverWriteTest extends TestCase
{
    protected $methodName = "write";
    protected $append = false;

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
    public function writeOne()
    {
        $key = "foo";
        $value = "hello, world";
        $accessKey = "s3://{$this->bucket}/foo";

        $access = $this->getAccess(array('isDir', 'put'));
        $access->expects($this->once())
            ->method('isDir')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(false));
        $access->expects($this->once())
            ->method('put')
            ->with($this->equalTo($accessKey), $this->equalTo($value), $this->equalTo($this->append))
            ->will($this->returnValue(true));

        $driver = $this->getDriver();

        call_user_func_array(array($driver, $this->methodName), array($key, $value));
    }

    /**
     * @test
     */
    public function writeTwo()
    {
        $key = "foo/bar/baz.txt";
        $value = "hello, world";
        $accessKey = "s3://{$this->bucket}/foo/bar/baz.txt";

        $access = $this->getAccess(array('isDir', 'put', 'mkdir'));
        $access->expects($this->once())
            ->method('isDir')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(false));
        $access->expects($this->once())
            ->method('put')
            ->with($this->equalTo($accessKey), $this->equalTo($value), $this->equalTo($this->append))
            ->will($this->returnValue(true));
        $access->expects($this->never())
            ->method('mkdir');

        $driver = $this->getDriver();

        call_user_func_array(array($driver, $this->methodName), array($key, $value));
    }
}