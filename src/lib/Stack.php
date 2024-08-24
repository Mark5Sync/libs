<?php

namespace marksync_libs\lib;

use marksync\provider\NotMark;

#[NotMark]
class Stack {

    private array $stack = [];
    public bool $frize = false;
    

    function __construct(private $callback, private int $limit = 100)
    {
        
    }

    function __destruct()
    {
        $this->run();
    }

    
    function push(mixed $value)
    {
        if ($this->frize)
            return;

        $this->stack[] = $value;
        if (count($this->stack) < $this->limit)
            return;

        $this->run();
    }


    function run()
    {
        if (empty($this->stack))
            return;

        $callback = $this->callback;
        $callback($this->stack, $this->frize);
        $this->stack = [];
    }
}