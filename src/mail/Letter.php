<?php


namespace marksync_libs\mail;

use marksync\provider\MarkInstance;
use SebastianBergmann\Template\Template;


#[MarkInstance]
class Letter
{
    private array $props = [];

    function __construct(private string $htmlTemplate)
    {
    }

    function setProps(...$props)
    {
        $this->props = $props;

        return $this;
    }


    function getHtml()
    {
        $template = new Template($this->htmlTemplate, '{{', '}}');
        $template->setVar($this->props);

        $result = $template->render();
        return $result;
    }
}
