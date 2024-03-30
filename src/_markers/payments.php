<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\payments\TinkoffBank\Receipt;

/**
 * @property-read Receipt $receipt

*/
trait payments {
    use provider;

   function _receipt(): Receipt { return new Receipt; }

}