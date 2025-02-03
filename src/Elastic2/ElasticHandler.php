<?php

namespace marksync_libs\Elastic2;

use marksync_libs\_markers\Elastic2;

trait ElasticHandler
{
    use Elastic2;

    protected $bulk = [];



    function __destruct()
    {
        $this->fetch();
    }

    /** 
     * Выполнить запрос
    */
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
        $this->index->index->delete();
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





    function getConnection(): string
    {
        return "http://{$this->host}:{$this->port}";
    }
}