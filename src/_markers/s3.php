<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\s3\results\BucketFile;
use marksync_libs\s3\results\BucketListResult;
use marksync_libs\s3\S3Connection;

/**
 * @property-read BucketFile $bucketFile
 * @property-read BucketListResult $bucketListResult
 * @property-read S3Connection $s3Connection

*/
trait s3 {
    use provider;

   function createBucketFile(): BucketFile { return new BucketFile; }
   function createBucketListResult(): BucketListResult { return new BucketListResult; }
   function _createS3Connection(): S3Connection { return new S3Connection($this); }

}