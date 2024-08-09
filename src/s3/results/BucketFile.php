<?php

namespace marksync_libs\s3\results;

use JsonSerializable;

class BucketFile implements JsonSerializable
{
    public string $filename;
    public string $dirname;
    public string $extension;
    public string $basename;

    public string $subfilename;


    function __construct(public string $key, private ?string $prefix = null)
    {
        [
            'filename' => $this->filename,
            'dirname' => $this->dirname,
            'extension' => $this->extension,
            'basename' => $this->basename,
        ] = pathinfo($key);


        $this->subfilename = !$this->prefix ? $key : substr($key, strlen($this->prefix));
    }


    function jsonSerialize(): mixed
    {
        return [
            'filename' => $this->filename,
            'dirname' => $this->dirname,
            'extension' => $this->extension,
            'basename' => $this->basename,
            'key' => $this->key,
        ];
    }
}
