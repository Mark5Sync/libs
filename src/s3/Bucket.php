<?php

namespace marksync_libs\s3;

abstract class Bucket extends BucketHandler
{

    protected string $version = "latest";
    protected string $region;
    protected string $bucket;
    protected string $endpoint;
    protected string $key;
    protected string $secret;

}
