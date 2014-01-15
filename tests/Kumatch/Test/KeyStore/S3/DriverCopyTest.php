<?php

namespace Kumatch\Test\KeyStore\S3;

use Kumatch\KeyStore\S3\StreamPath;

class DriverCopyTest extends TestCase
{
    protected $methodName = "copy";
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
    public function copy()
    {
        $src = "foo/bar";
        $dst = "path/to/dst";

        $srcPath = new StreamPath($this->bucket, $src);
        $dstPath = new StreamPath($this->bucket, $dst);

        $access = $this->getAccess(array('isFile', 'isDir', $this->methodName));
        $access->expects($this->once())
            ->method('isFile')
            ->with($this->equalTo($srcPath))
            ->will($this->returnValue(true));
        $access->expects($this->once())
            ->method('isDir')
            ->with($this->equalTo($dstPath))
            ->will($this->returnValue(false));
        $access->expects($this->once())
            ->method($this->methodName)
            ->with($this->equalTo($srcPath), $this->equalTo($dstPath))
            ->will($this->returnValue(true));

        $driver = $this->getDriver();

        call_user_func_array(array($driver, $this->methodName), array($src, $dst));
    }
}