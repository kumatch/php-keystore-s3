<?php
namespace Kumatch\KeyStore\S3;

use Kumatch\Path;
use Kumatch\KeyStore\Filesystem\Driver as FilesystemDriver;
use Kumatch\KeyStore\AccessDriverInterface;

class Driver extends FilesystemDriver implements AccessDriverInterface
{
    /** @var array */
    protected $s3Config = array();
    /** @var  string */
    protected $bucket;


    /** @var  Access */
    protected $access;

    /**
     * @param array $s3Config
     * @param $bucket
     * @see \Kumatch\KeyStore\Filesystem\Driver::__construct()
     */
    public function __construct(array $s3Config, $bucket)
    {
        $this->s3Config = $s3Config;
        $this->bucket = $bucket;

        $this->rootPath = $bucket;
    }

    /**
     * @return Access
     * @see \Kumatch\KeyStore\Filesystem\Driver::access()
     */
    protected function access()
    {
        if (!$this->access) {
            $this->access = new Access($this->s3Config);
        }

        return $this->access;
    }


    /**
     * @param $key
     * @return mixed
     * @see \Kumatch\KeyStore\Filesystem\Driver::createPath()
     */
    protected function createPath($key)
    {
        $path = parent::createPath($key);

        return sprintf('s3://%s', $path);
    }



    /**
     * @param $dirname
     * @return bool
     * @see \Kumatch\KeyStore\Filesystem\Driver::createDirectory()
     */
    protected function createDirectory($dirname)
    {
        // do nothing.
        return true;
    }

    /**
     * @param string $path
     * @return bool
     * @see \Kumatch\KeyStore\Filesystem\Driver::removeParents()
     */
    protected function removeParents($path)
    {
        // do nothing.
        return true;
    }
}