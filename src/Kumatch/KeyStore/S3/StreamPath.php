<?php
namespace Kumatch\KeyStore\S3;

class StreamPath
{
    /** @var string */
    protected $bucket;
    /** @var string */
    protected $key;

    /**
     * @param $path
     * @return bool|static
     */
    static public function parse($path)
    {
        $regex = "!/([^/]+)/(.*)!";

        if (!preg_match($regex, $path, $matches)) {
            return false;
        }

        return new static($matches[1], $matches[2]);
    }

    /**
     * @param $bucket
     * @param $key
     */
    public function __construct($bucket, $key)
    {
        $this->bucket = preg_replace('!/!', '', $bucket);
        $this->key = preg_replace('!^[/]+!', '', $key);
    }

    /**
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getStreamPath()
    {
        return sprintf('s3://%s/%s', $this->bucket, $this->key);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getStreamPath();
    }
}