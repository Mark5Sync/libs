<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\lib\Translit;

/**
 * @property-read Translit $translit

*/
trait lib {
    use provider;

   function createTranslit(): Translit { return new Translit; }

}