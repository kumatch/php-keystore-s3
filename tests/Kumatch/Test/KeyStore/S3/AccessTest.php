<?php
namespace Kumatch\Test\KeyStore\S3;

use Kumatch\KeyStore\S3\Access;
use Kumatch\Fs\Temp\Temp;
use Kumatch\Path;

class AccessTest extends \PHPUnit_Framework_TestCase
{
    /** @var  string */
    protected $dir;

    protected function setUp()
    {
        parent::setUp();

        $temp = new Temp();

        $prefix = sprintf("%s-", strtolower( str_replace('\\', '-', get_called_class()) ));
        $this->dir = $temp->dir()->prefix($prefix)->create();
    }

    protected function tearDown()
    {
        parent::tearDown();

        @stream_wrapper_unregister('s3');
    }

    /**
     * @return \Kumatch\KeyStore\S3\Access|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAccess()
    {
        $s3Config = array();

        return new Access($s3Config);
    }

    /**
     * @test
     */
    public function extendsFilesystemAccessClass()
    {
        $access = $this->getAccess();

        $this->assertInstanceOf('\Kumatch\KeyStore\Filesystem\Access', $access);
    }

    /**
     * @test
     */
    public function regiserS3Stream()
    {
        $this->assertFalse(in_array('s3', stream_get_wrappers()));

        $access = $this->getAccess();

        $this->assertTrue(in_array('s3', stream_get_wrappers()));
    }

    /**
     * @test
     */
    public function dontCreateDirectoryByMkdir()
    {
        $access = $this->getAccess();

        $path = Path::join($this->dir, "foo");

        $this->assertFileNotExists($path);
        $this->assertFalse(is_dir($path));

        $access->mkdir($path);

        $this->assertFileNotExists($path);
        $this->assertFalse(is_dir($path));
    }

    /**
     * @test
     */
    public function dontRemoveDirectoryByRmdir()
    {
        $access = $this->getAccess();

        $path = Path::join($this->dir, "foo");

        mkdir($path, 0755);

        $this->assertFileExists($path);
        $this->assertTrue(is_dir($path));

        $access->rmdir($path);

        $this->assertFileExists($path);
        $this->assertTrue(is_dir($path));
    }

    /**
     * @test
     */
    public function dontScanByScandir()
    {
        $access = $this->getAccess();

        $dir = Path::join($this->dir, "foo");
        $file1 = Path::join($this->dir, "foo/bar");
        $file2 = Path::join($this->dir, "foo/baz");

        mkdir($dir, 0755);
        touch($file1);
        touch($file2);

        $this->assertTrue(is_dir($dir));
        $this->assertTrue(is_file($file1));
        $this->assertTrue(is_file($file2));

        $children = array_diff(scandir($dir), array('.', '..'));

        $this->assertCount(2, $children);
        $this->assertContains("bar", $children);
        $this->assertContains("baz", $children);
        $this->assertNotContains("foo", $children);

        $this->assertCount(0, $access->scandir($dir));
    }
}