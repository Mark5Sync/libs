<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticClient;
use marksync_libs\Elastic\Search\Search;
use marksync_libs\Elastic\Search\Operator;
use marksync_libs\Elastic\Search\IndexInstance;
use marksync_libs\Elastic\ElasticIndex;

/**
 * @property-read ElasticClient $elasticClient
 * @property-read Search $search
 * @property-read Operator $operator
 * @property-read IndexInstance $index
 * @property-read ElasticIndex $elasticIndex

*/
trait Elastic {
    use provider;

   function createElasticClient(): ElasticClient { return new ElasticClient($this); }
   function _createSearch(): Search { return new Search($this); }
   function createOperator(): Operator { return new Operator; }
   function _createIndex(): IndexInstance { return new IndexInstance($this); }
   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }

}