<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\s3\S3Connection;

/**
 * @property-read S3Connection $s3Connection

*/
trait s3 {
    use provider;

   function _createS3Connection(): S3Connection { return new S3Connection($this); }

}