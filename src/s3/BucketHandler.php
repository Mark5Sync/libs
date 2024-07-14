<?php

namespace marksync_libs\s3;

use marksync_libs\_markers\s3;

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




    function getList()
    {
        $this->s3Connection->client->listObjects([
            'Bucket' => $this->bucket
        ]);
    }


    function getContent(string $file)
    {
        return null;
    }
}
