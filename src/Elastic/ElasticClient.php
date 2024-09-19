<?php

namespace marksync_libs\Elastic;

use Elastica\Client;
use marksync\provider\Mark;

#[Mark(args: ['parent'])]
class ElasticClient
{
    public Client $client;

    function __construct(ElasticIndex $config)
    {
        $this->client = new Client("http://{$config->host}:{$config->port}");
    }
}
