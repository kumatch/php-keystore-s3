<?php
namespace Kumatch\KeyStore\S3;

use Kumatch\KeyStore\Filesystem\Access as FilesystemAccess;
use Aws\S3\S3Client;

class Access extends FilesystemAccess
{
    /** @var  S3Client */
    protected $s3Client;

    public function __construct(array $s3Config)
    {
        $this->s3Client = S3Client::factory($s3Config);
        $this->s3Client->registerStreamWrapper();
    }

    /**
     * @return S3Client
     */
    public function getS3Client()
    {
        return $this->s3Client;
    }

    /**
     * @param $filename
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public function mkdir($filename, $mode = 0700, $recursive = true)
    {
        // do nothing.
        return true;
    }

    /**
     * @param $dirname
     * @return array
     */
    public function scandir($dirname)
    {
        // do nothing.
        return array();
    }

    /**
     * @param $filename
     * @return bool
     */
    public function rmdir($filename)
    {
        // do nothing.
        return true;
    }
}