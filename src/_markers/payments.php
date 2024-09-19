<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\payments\TinkoffBank\Receipt;
use marksync_libs\payments\TinkoffBank\Tax;
use marksync_libs\payments\TinkoffBank\Taxition;

/**
 * @property-read Receipt $receipt
 * @property-read Tax $tax
 * @property-read Taxition $taxition

*/
trait payments {
    use provider;

   function _createReceipt(): Receipt { return new Receipt; }
   function createTax(): Tax { return new Tax; }
   function createTaxition(): Taxition { return new Taxition; }

}