<?php

namespace marksync_libs\Elastic;

use Elastica\Document;
use Elastica\Exception\Bulk\ResponseException;
use Elastica\Index;
use Elastica\Query;
use Elastica\Query\MatchAll;
use marksync_libs\_markers\Elastic;

abstract class ElasticIndexHandler
{
    use Elastic;

    public string $host;
    public int $port;
    public string $indexName;
    protected int $limit = 1000;

    protected $bulk = [];


    function __destruct()
    {
        $this->fetch();
    }

    function index(?string $id = null, ...$body)
    {
        $this->bulk[] = new Document($id, $body, $this->indexName);
        if (count($this->bulk) > $this->limit)
            $this->fetch();
    }

    function fetch()
    {
        if (!empty($this->bulk))
            $this->index->bulk($this->bulk);

        $this->bulk = [];
    }

    function exists()
    {
        return $this->index->index->exists();
    }

    function select(int $from = 0, int $size = 10)
    {
        return $this->index->select($from, $size);
    }

    function deleteIndex()
    {
        $this->index->index->delete();
    }


    function search() {}
}