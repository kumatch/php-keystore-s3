<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverIsNamespaceTest extends TestCase
{
    protected $methodName = "isNamespace";

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
    public function isNamespace()
    {
        $key = "/foo/bar/../baz/";
        $accessKey = "s3://{$this->bucket}/foo/baz";

        $access = $this->getAccess(array('isDir'));
        $access->expects($this->once())
            ->method('isDir')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(true));

        $driver = $this->getDriver();

        $this->assertTrue($driver->isNamespace($key));
    }
}