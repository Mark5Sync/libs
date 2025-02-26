<?php

namespace marksync_libs\Elastic;

use Elastica\Document;
use Elastica\Mapping;
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

    function update(string | int $id = null, ...$body)
    {
        $document = new Document($id, null, $this->indexName);
        $document->setData(['doc' => $body]);

        $this->bulk[] = $document;
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

    function match(string | int | bool ...$colls)
    {
        return $this->index->match(...$colls);
    }

    function deleteIndex()
    {
        if ($this->exists())
            $this->index->index->delete();
    }

    function setMapping(array $mapping, int $number_of_shards = 1, int $number_of_replicas = 1)
    {
        $this->deleteIndex();
        $this->create($number_of_shards, $number_of_replicas);

        $mapping = new Mapping($mapping);
        $mapping->send($this->index->index);
    }

    function create(int $number_of_shards = 1, int $number_of_replicas = 1)
    {
        $this->index->index->create(options: [
            "number_of_shards" => $number_of_shards,
            "number_of_replicas" => $number_of_replicas,
        ]);
    }

    function getMapping()
    {
        return $this->index->index->getMapping();
    }

    function page(int $offset = 0, int $limit = 10, ?int &$size = null)
    {
        $this->search->page($offset, $limit, $size);

        return $this;
    }


    function setIndexLimit(int $limit)
    {
        $this->limit = $limit;
    }


    function search() {}

    function loadMore($offset, $limit, bool &$canLoadMore = null)
    {
        $this->search->loadMore($offset, $limit, $canLoadMore);
    }
}
