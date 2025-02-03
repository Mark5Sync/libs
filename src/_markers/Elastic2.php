<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic2\Search\Operator;
use marksync_libs\Elastic2\Search\ElasticClient;
use marksync_libs\Elastic2\Search\Search;
use marksync_libs\Elastic2\Search\IndexInstance;

/**
 * @property-read Operator $operator
 * @property-read ElasticClient $elasticClient
 * @property-read Search $search
 * @property-read IndexInstance $index

*/
trait Elastic2 {
    use provider;

   function createOperator(): Operator { return new Operator; }
   function _createElasticClient(): ElasticClient { return new ElasticClient($this); }
   function _createSearch(): Search { return new Search($this); }
   function _createIndex(): IndexInstance { return new IndexInstance($this); }

}