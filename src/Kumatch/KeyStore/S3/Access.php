<?php
namespace Kumatch\KeyStore\S3;

use Aws\S3\S3Client;
use Kumatch\KeyStore\Filesystem\Access as FilesystemAccess;
use Kumatch\KeyStore\S3\Exception\Exception;

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

    /**
     * @param StreamPath $src
     * @param StreamPath $dst
     * @throws Exception
     * @return bool
     */
    public function copy($src, $dst)
    {
        if (!is_a($src, '\Kumatch\KeyStore\S3\StreamPath')
            || !is_a($dst, '\Kumatch\KeyStore\S3\StreamPath')
        ) {
            throw new Exception();
        }

        $params = array(
            'Bucket' => $dst->getBucket(),
            'Key' => $dst->getKey(),
            'CopySource' => sprintf("/%s/%s", $src->getBucket(), $src->getKey()),
            'MetadataDirective' => 'COPY'
        );

        $s3Client = $this->getS3Client();
        $s3Client->copyObject($params);
        $s3Client->waitUntilObjectExists(array(
            'Bucket' => $dst->getBucket(),
            'Key' => $dst->getKey(),
        ));

        return true;
    }

    /**
     * @param StreamPath $src
     * @param StreamPath $dst
     * @throws Exception
     * @return bool|void
     */
    public function rename($src, $dst)
    {
        if (!is_a($src, '\Kumatch\KeyStore\S3\StreamPath')
            || !is_a($dst, '\Kumatch\KeyStore\S3\StreamPath')
        ) {
            throw new Exception();
        }

        if (!$this->copy($src, $dst)) {
            return false;
        }

        return $this->unlink($src);
    }
}