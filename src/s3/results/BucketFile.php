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


    function __construct(public string $fullFileName, private ?string $prefix = null)
    {
        [
            'filename' => $this->filename,
            'dirname' => $this->dirname,
            'extension' => $this->extension,
            'basename' => $this->basename,
        ] = pathinfo($fullFileName);


        $this->subfilename = !$this->prefix ? $fullFileName : substr($fullFileName, strlen($this->prefix));
    }


    function jsonSerialize(): mixed
    {
        return [
            'filename' => $this->filename,
            'dirname' => $this->dirname,
            'extension' => $this->extension,
            'basename' => $this->basename,
            'full' => $this->fullFileName,
        ];
    }
}
