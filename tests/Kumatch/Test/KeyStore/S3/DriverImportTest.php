<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverImportTest extends TestCase
{
    protected $methodName = "import";
    protected $append = false;

    protected function setUp()
    {
        parent::setUp();

        $this->secondArgument = __FILE__;
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function import()
    {
        $key = "foo";
        $accessKey = "s3://{$this->bucket}/foo";
        $importFilename = __FILE__;

        $src = "source";
        $dst = "destination";

        $access = $this->getAccess(array('isDir', 'fopen', 'streamCopyToStream'));
        $access->expects($this->at(0))
            ->method('isDir')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue(false));
        $access->expects($this->at(1))
            ->method('fopen')
            ->with($this->equalTo($importFilename))
            ->will($this->returnValue($src));
        $access->expects($this->at(2))
            ->method('fopen')
            ->with($this->equalTo($accessKey))
            ->will($this->returnValue($dst));
        $access->expects($this->at(3))
            ->method('streamCopyToStream')
            ->with($this->equalTo($src), $this->equalTo($dst))
            ->will($this->returnValue(true));

        $driver = $this->getDriver();

        $driver->import($key, $importFilename);
    }
}