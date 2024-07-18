<?php

namespace marksync_libs\s3;

use Aws\S3\S3Client;
use marksync\provider\Mark;
use marksync_libs\s3\Bucket;

#[Mark(mode: Mark::LOCAL, args: ['parent'])]
class S3Connection {

    public S3Client $client;

    final function __construct(private Bucket $parent)
    {
        [$endpoint, $key, $secret] = $this->parent->getConnection();

        $this->client = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => $key,
                'secret' => $secret,
            ],
        ]);
    }

}