<?php

namespace marksync_libs\s3\results;

use Aws\Result;

class BucketListResult
{

    function __construct(public Result $requestResult, public ?string $prefix = null)
    {
    }


    public function getBucketFileList(?callable $callback = null): array
    {
        $result = [];

        if (empty($this->requestResult['Contents'])) {
            return $result;
        }

        $folder = trim($this->prefix, '/') . '/';


        foreach ($this->requestResult['Contents'] as ['Key' => $key]) {
            if ($this->prefix ? str_ends_with($key, "$folder.empty") : $key != '.empty')
                continue;

            if ($this->prefix && $key == $folder)
                continue;

            $item = new BucketFile($key, $this->prefix);
            $result[] = $callback ? $callback($item) : $item;
        }

        return $result;
    }
}
