<?php

namespace marksync_libs\Elastic\Search;

use Elastica\Bulk;
use Elastica\Client;
use Elastica\Index;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchAll;
use Elastica\Query\MatchQuery;
use Elastica\ResultSet;
use marksync\provider\Mark;
use marksync_libs\Elastic\ElasticIndex;

#[Mark(title: 'index', args: ['parent'])]
class IndexInstance
{
    public Client $client;
    public Index $index;

    function __construct(ElasticIndex $config)
    {
        $this->client = new Client("http://{$config->host}:{$config->port}");
        $this->index = $this->client->getIndex($config->indexName);

        if (!$this->index->exists())
            $this->index->create();
    }


    function bulk(array $documents)
    {
        $bulk = new Bulk($this->client);
        $bulk->addDocuments($documents);
        $bulk->send();

        $this->index->refresh();
    }


    function select(int $from = 0, int $size = 10)
    {
        $query = new MatchAll();

        $query = new Query($query);
        $query->setFrom($from);
        $query->setSize($size);

        $results = $this->index->search($query);

        return $this->resultToArray($results);
    }


    function match(string | int | bool ...$colls)
    {
        $boolQuery = new BoolQuery();

        foreach ($colls as $coll => $value) {
            $boolQuery->addMust((new MatchQuery($coll, $value)));
        }

        $query = new Query($boolQuery);
        $results = $this->index->search($query);

        return $this->resultToArray($results);
    }


    function resultToArray(ResultSet $requestResult)
    {
        $result = [];

        foreach ($requestResult as $data) {
            $result[] = $data->getData();
        }

        return $result;
    }
}
