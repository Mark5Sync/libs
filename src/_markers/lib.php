<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\lib\Stack;
use marksync_libs\lib\Translit;

/**
 * @property-read Stack $stack
 * @property-read Translit $translit

*/
trait lib {
    use provider;

   function createStack(): Stack { return new Stack; }
   function createTranslit(): Translit { return new Translit; }

}