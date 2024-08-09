<?php

namespace marksync_libs\lib;

use Denismitr\Translit\Translit as TranslitTranslit;

class Translit {

    private $trans;

    function __construct()
    {
        $this->trans = new TranslitTranslit();
    }

    function transform(string $text)
    {
        return $this->trans->transform($text);
    }

}