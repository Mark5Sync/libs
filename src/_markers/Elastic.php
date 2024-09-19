<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Elastic\ElasticIndex;
use marksync_libs\Elastic\IndexInstance;

/**
 * @property-read ElasticIndex $elasticIndex
 * @property-read IndexInstance $index

*/
trait Elastic {
    use provider;

   function createElasticIndex(): ElasticIndex { return new ElasticIndex; }
   function createIndex(): IndexInstance { return new IndexInstance($this); }

}