<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\Redis\RedisProvider;

/**
 * @property-read RedisProvider $redis

*/
trait Redis {
    use provider;

   function createRedis(): RedisProvider { return new RedisProvider; }

}