<?php

namespace marksync_libs\Elastic2\Search;

use Elastica\Client;
use marksync\provider\Mark;
use marksync_libs\Elastic2\AbstractElasticConnectionConfig;

#[Mark(title: 'elasticClient', args: ['parent'], mode: Mark::LOCAL)]
class ElasticClient {
    public Client $client;

    function __construct(private AbstractElasticConnectionConfig $config)
    {
        $this->client = new Client($config->getConnection());
    }

}