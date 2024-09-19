<?php

namespace marksync_libs\Elastic;

use Elastica\Bulk;
use Elastica\Client;
use Elastica\Index;
use Elastica\Query;
use Elastica\Query\MatchAll;
use marksync\provider\Mark;

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

        $result = [];
        foreach ($results as $data) {
            $result[] = $data->getData();
        }

        return $result;
    }
}
