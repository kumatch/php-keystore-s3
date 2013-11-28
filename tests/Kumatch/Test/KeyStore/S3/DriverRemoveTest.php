<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverRemoveTest extends TestCase
{
    protected $methodName = "remove";

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
    public function removeExistsKey()
    {
        $key = 42;
        $accessKey = "s3://{$this->bucket}/42";

        $access = $this->getAccess(array('isFile', 'unlink'));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(true));
        $access->expects($this->once())
            ->method('unlink')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(true));
        $access->expects($this->never())
            ->method('scandir');

        $driver = $this->getDriver();

        $this->assertTrue($driver->remove($key));
    }

    /**
     * @test
     */
    public function removeNotExistsKey()
    {
        $key = "foo../bar";
        $accessKey = "s3://{$this->bucket}/foo../bar";

        $access = $this->getAccess(array('isFile', 'unlink'));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(false));
        $access->expects($this->never())
            ->method('unlink');
        $access->expects($this->never())
            ->method('scandir');

        $driver = $this->getDriver();

        $this->assertTrue($driver->remove($key));
    }
}