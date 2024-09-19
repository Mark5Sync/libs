<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticIndex;
use marksync_libs\Elastic\Search\IndexInstance;
use marksync_libs\Elastic\Search\Search;

/**
 * @property-read ElasticIndex $elasticIndex
 * @property-read IndexInstance $index
 * @property-read Search $search

*/
trait Elastic {
    use provider;

   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }
   function createIndex(): IndexInstance { return new IndexInstance($this); }
   function createSearch(): Search { return new Search($this); }

}