<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverExistsTest extends TestCase
{
    protected $methodName = "exists";

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
    public function exists()
    {
        $key = "/foo/bar/../baz/";
        $accessKey = "s3://{$this->bucket}/foo/baz";

        $access = $this->getAccess(array('isFile'));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(true));

        $driver = $this->getDriver();

        $this->assertTrue($driver->exists($key));
    }
}