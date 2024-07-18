<?php

namespace marksync_libs\s3;

use Aws\Exception\AwsException;
use marksync_libs\_markers\s3;
use marksync_libs\s3\results\BucketListResult;

abstract class BucketHandler
{
    use s3;

    protected string $bucket;
    protected string $endpoint;
    protected string $key;
    protected string $secret;

    function getConnection()
    {
        return [
            $this->endpoint,
            $this->key,
            $this->secret,
        ];
    }




    function getList(?string $prefix = null)
    {
        $result = $this->s3Connection->client->listObjectsV2([
            'Bucket' => $this->bucket,
            'Prefix' => $prefix,
        ]);

        return new BucketListResult($result, $prefix);
    }


    function getContent(string $file): string
    {
        $result = $this->s3Connection->client->getObject([
            'Bucket' => $this->bucket,
            'Key'    => $file,
        ]);

        return $result['Body'];
    }
}
