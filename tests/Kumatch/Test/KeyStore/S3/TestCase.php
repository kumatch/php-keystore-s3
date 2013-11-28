<?php
namespace Kumatch\Test\KeyStore\S3;


class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $access;

    protected $awsKey = "example_key";
    protected $awsSecret = "example_secret";
    protected $awsRegion = "us-west-1";
    protected $bucket = "example_bucket";

    /** @var  string */
    protected $methodName;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @param array $methods
     * @return \Kumatch\KeyStore\S3\Access|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAccess($methods = array())
    {
        if (!$this->access) {
            $this->access = $this->getMockBuilder('\Kumatch\KeyStore\S3\Access')
                ->disableOriginalConstructor()
                ->setMethods($methods)
                ->getMock();
        }

        return $this->access;
    }


    /**
     * @return \Kumatch\KeyStore\S3\Driver|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getDriver()
    {
        $s3Config = array(
            "key" => $this->awsKey,
            "secret" => $this->awsSecret,
            "region" => $this->awsRegion,
        );

        $driver = $this->getMockBuilder('\Kumatch\KeyStore\S3\Driver')
            ->setConstructorArgs(array( $s3Config, $this->bucket ))
            ->setMethods(array('access'))
            ->getMock();
        $driver->expects($this->any())
            ->method('access')
            ->will($this->returnValue( $this->getAccess() ));

        return $driver;
    }


    /**
     * @test
     * @expectedException \Kumatch\KeyStore\Exception\ErrorException
     */
    public function throwExceptionIfPathIsTraversed()
    {
        $driver = $this->getDriver();

        $key = "../foo";
        $value = "hello, world";

        call_user_func_array(array($driver, $this->methodName), array($key, $value));
    }

    /**
     * @test
     * @expectedException \Kumatch\KeyStore\Exception\ErrorException
     */
    public function throwExceptionIfKeyIsBlank()
    {
        $driver = $this->getDriver();

        $key = "";
        $value = "hello, world";

        call_user_func_array(array($driver, $this->methodName), array($key, $value));
    }

    /**
     * @test
     * @expectedException \Kumatch\KeyStore\Exception\ErrorException
     */
    public function throwExceptionIfKeyIsDotOnly()
    {
        $driver = $this->getDriver();

        $key = ".";
        $value = "hello, world";

        call_user_func_array(array($driver, $this->methodName), array($key, $value));
    }
}