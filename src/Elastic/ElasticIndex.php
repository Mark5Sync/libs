<?php

namespace marksync_libs\Elastic;

class ElasticIndex extends ElasticIndexHandler
{
    public string $host;
    public int $port;
    public string $indexName;
}
