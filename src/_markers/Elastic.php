<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticIndex;
use marksync_libs\Elastic\ElasticClient;
use marksync_libs\Elastic\Search\Operator;
use marksync_libs\Elastic\Search\Search;
use marksync_libs\Elastic\Search\IndexInstance;

/**
 * @property-read ElasticIndex $elasticIndex
 * @property-read ElasticClient $elasticClient
 * @property-read Operator $operator
 * @property-read Search $search
 * @property-read IndexInstance $index

*/
trait Elastic {
    use provider;

   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }
   function createElasticClient(): ElasticClient { return new ElasticClient($this); }
   function createOperator(): Operator { return new Operator; }
   function _createSearch(): Search { return new Search($this); }
   function _createIndex(): IndexInstance { return new IndexInstance($this); }

}