<?php
namespace marksync_libs\_markers;
use marksync\provider\provider;
use marksync_libs\mail\Letter;

/**

*/
trait mail {
    use provider;

   function createLetter(string $htmlTemplate): Letter { return new Letter($htmlTemplate); }

}