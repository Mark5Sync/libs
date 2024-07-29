<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\libx\Translit;
use marksync_libs\libx\Env;

/**
 * @property-read Translit $translit
 * @property-read Env $env

*/
trait libx {
    use provider;

   function createTranslit(): Translit { return new Translit; }
   function createEnv(): Env { return new Env; }

}