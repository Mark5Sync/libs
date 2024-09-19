<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticIndex;
use marksync_libs\Elastic\Search\Operator;
use marksync_libs\Elastic\Search\IndexInstance;
use marksync_libs\Elastic\Search\Search;
use marksync_libs\Elastic\ElasticClient;

/**
 * @property-read ElasticIndex $elasticIndex
 * @property-read Operator $operator
 * @property-read IndexInstance $index
 * @property-read Search $search
 * @property-read ElasticClient $elasticClient

*/
trait Elastic {
    use provider;

   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }
   function createOperator(): Operator { return new Operator; }
   function _createIndex(): IndexInstance { return new IndexInstance($this); }
   function _createSearch(): Search { return new Search($this); }
   function createElasticClient(): ElasticClient { return new ElasticClient($this); }

}