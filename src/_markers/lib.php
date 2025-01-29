<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\lib\Translit;
use marksync_libs\lib\Stack;

/**
 * @property-read Translit $translit
 * @property-read Stack $stack

*/
trait lib {
    use provider;

   function createTranslit(): Translit { return new Translit; }
   function createStack(): Stack { return new Stack; }

}