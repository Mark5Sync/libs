<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticIndex;
use marksync_libs\Elastic\Search\Search;
use marksync_libs\Elastic\Search\IndexInstance;

/**
 * @property-read ElasticIndex $elasticIndex
 * @property-read Search $search
 * @property-read IndexInstance $index

*/
trait Elastic {
    use provider;

   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }
   function createSearch(): Search { return new Search($this); }
   function createIndex(): IndexInstance { return new IndexInstance($this); }

}