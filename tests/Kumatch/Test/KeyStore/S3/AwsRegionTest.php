<?php

namespace Kumatch\Test\KeyStore\S3;

use Kumatch\KeyStore\S3\AwsRegion;

class AwsRegionTest extends \PHPUnit_Framework_TestCase
{

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
    public function extendsAwsSDKRegion()
    {
        $ref = new \ReflectionClass('Kumatch\KeyStore\S3\AwsRegion');

        $this->assertEquals('Aws\Common\Enum\Region', $ref->getParentClass()->getName());
    }

    /**
     * @test
     */
    public function useRegionConst()
    {
        $this->assertEquals("us-east-1", AwsRegion::US_EAST_1);
        $this->assertEquals("us-west-1", AwsRegion::US_WEST_1);

        $keys = AwsRegion::keys();

        $this->assertGreaterThan(10, count($keys));
        $this->assertContains("US_EAST_1", $keys);
        $this->assertContains("US_WEST_1", $keys);
        $this->assertContains("AP_NORTHEAST_1", $keys);
    }
}