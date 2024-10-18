<?php

namespace marksync_libs\s3;

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


    function exists(string $key): bool
    {
        $result = $this->s3Connection->client->doesObjectExist($this->bucket, $key);
        return $result;
    }

    function getContent(string $key): string
    {
        $result = $this->s3Connection->client->getObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);

        return $result['Body'];
    }


    function putContent(string $key, ?string $body = null, ?string $file = null)
    {
        $this->s3Connection->client->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
            'SourceFile' => $file,
            'Body' => $body,
        ]);
    }


    function forCsvContent(string $key, string $separator = ',')
    {
        $result = $this->s3Connection->client->getObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);

        $csv = fopen('php://temp', 'r+');

        fwrite($csv, $result['Body']);
        rewind($csv);

        $header = null;
        while (($row = fgetcsv($csv, 0, $separator)) !== false) {
            if (is_null($header)) {
                $header = $row;
                continue;
            }


            if (count($header) != count($row))
                continue;

            $result = array_combine($header, $row);
            yield $result;
        }

        fclose($csv);
    }


    function getCsvContent(string $key, string $separator = ',')
    {
        $result = [];

        foreach ($this->forCsvContent($key, $separator) as $row) {
            $result[] = $row;
        }

        return $result;
    }


    function forList(?string $prefix = null, int $maxKeys = 100)
    {
        $nextContinuationToken = null;

        do {
            $result = $this->s3Connection->client->listObjectsV2([
                'Bucket' => $this->bucket,
                'Prefix' => $prefix,
                'ContinuationToken' => $nextContinuationToken,
                'MaxKeys' => $maxKeys,
            ]);

            foreach ($result['Contents'] as ['Key' => $key]) {
                yield $key;
            }

            if ($result['IsTruncated'])
                $nextContinuationToken = $result['NextContinuationToken'];
        } while ($result['IsTruncated']);
    }
}
