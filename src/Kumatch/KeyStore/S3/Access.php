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

    /**
     * @param StreamPath $src
     * @param StreamPath $dst
     * @return bool
     */
    public function copy(StreamPath $src, StreamPath $dst)
    {
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
     * @return bool|void
     */
    public function rename(StreamPath $src, StreamPath $dst)
    {
        if (!$this->copy($src, $dst)) {
            return false;
        }

        return $this->unlink($src);
    }
}