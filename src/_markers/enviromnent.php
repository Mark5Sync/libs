<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\enviromnent\Env;

/**
 * @property-read Env $env

*/
trait enviromnent {
    use provider;

   function createEnv(): Env { return new Env; }

}