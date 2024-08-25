<?php

namespace marksync_libs\lib;

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
        $this->frize = !!$callback($this->stack);
        $this->stack = [];
    }
}