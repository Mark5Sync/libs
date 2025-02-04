<?php

namespace marksync_libs\Elastic2;

use Elastica\Document;
use marksync_libs\_markers\Elastic2;
use Pego\Pego;

trait ElasticPegoHandler
{
    use Elastic2;

    /** 
     * Подсветка синтаксиса
    */
    #[Pego]
    function __highlight(array $highlightTags = ['<mark>', '</mark>'], null &...$props)
    {
        $this->highlightTags = $highlightTags;
        $this->highlightProps = &$props;

        return $this;
    }


    #[Pego]
    function __index(?string $id = null, ...$body)
    {
        $this->bulk[] = new Document($id, $body, $this->title);
        if (count($this->bulk) > $this->limit)
            $this->fetch();
    }


    #[Pego]
    function __update(string | int $id = null, ...$body)
    {
        $document = new Document($id, null, $this->title);
        $document->setData(['doc' => $body]);

        $this->bulk[] = $document;
        if (count($this->bulk) > $this->limit)
            $this->fetch();
    }


}