<?php

namespace Kumatch\Test\KeyStore\S3;

class DriverAppendTest extends DriverWriteTest
{
    protected $methodName = "append";
    protected $append = true;
}