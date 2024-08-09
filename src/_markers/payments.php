<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\payments\TinkoffBank\Taxition;
use marksync_libs\payments\TinkoffBank\Receipt;
use marksync_libs\payments\TinkoffBank\Tax;

/**
 * @property-read Taxition $taxition
 * @property-read Receipt $receipt
 * @property-read Tax $tax

*/
trait payments {
    use provider;

   function createTaxition(): Taxition { return new Taxition; }
   function _createReceipt(): Receipt { return new Receipt; }
   function createTax(): Tax { return new Tax; }

}