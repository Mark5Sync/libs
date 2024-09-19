<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\s3\S3Connection;
use marksync_libs\s3\results\BucketFile;
use marksync_libs\s3\results\BucketListResult;

/**
 * @property-read S3Connection $s3Connection
 * @property-read BucketFile $bucketFile
 * @property-read BucketListResult $bucketListResult

*/
trait s3 {
    use provider;

   function _createS3Connection(): S3Connection { return new S3Connection($this); }
   function createBucketFile(): BucketFile { return new BucketFile; }
   function createBucketListResult(): BucketListResult { return new BucketListResult; }

}